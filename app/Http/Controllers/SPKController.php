<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Alternative;
use App\Models\Result;
use Illuminate\Http\Request;
use PDF;

class SPKController extends Controller
{
    public function index()
    {
        return view('layouts.mahasiswa.SPK.index');
    }

    public function showQuestion($index = 1)
    {
        $user = auth()->user();
        $questions = Question::orderBy('id')->get();
        $total = $questions->count();
        $question = $questions[$index - 1] ?? null;

        if (!$question) {
            return redirect()->route('spk.result');
        }

        return view('layouts.mahasiswa.SPK.question', compact('question', 'index', 'total', 'user'));
    }

    public function storeAnswer(Request $request, $index)
    {
        $request->validate([
            'value' => 'required|integer|min:1|max:5',
        ]);

        $user = auth()->user();
        $questions = Question::orderBy('id')->get();
        $question = $questions[$index - 1] ?? null;

        if (!$question) {
            return redirect()->route('spk.result');
        }

        Answer::updateOrCreate(
            ['user_id' => $user->id, 'question_id' => $question->id],
            ['value' => $request->value]
        );

        if ($index >= $questions->count()) {
            return redirect()->route('spk.result');
        }

        return redirect()->route('spk.form', ['index' => $index + 1]);
    }

    public function result()
    {
        $user = auth()->user();
        $answers = Answer::with('question')->where('user_id', $user->id)->get();

        $userScores = $this->calculateUserScores($answers);
        $alternatives = Alternative::all();
        $finalScores = $this->calculateFinalScores($userScores, $alternatives);
        $finalUKM = $this->mergeReligiousUKM($finalScores, $user);

        // ✅ Simpan hasil ke tabel results
        Result::updateOrCreate(
            ['user_id' => $user->id],
            [
                'recommended_1' => array_key_first($finalUKM['top_ukms']),
                'recommended_2' => array_keys($finalUKM['top_ukms'])[1] ?? null,
                'recommended_3' => array_keys($finalUKM['top_ukms'])[2] ?? null,
                'show_innovator_center' => 0,
            ]
        );

        return view('layouts.mahasiswa.SPK.result', [
            'criteriaScores' => $userScores,
            'finalUKM' => $finalUKM,
            'user' => $user,
        ]);
    }

    protected function calculateUserScores($answers)
    {
        $criteria = ['kreativitas', 'fisik', 'musik', 'teknologi', 'religiusitas'];
        $scores = array_fill_keys($criteria, 0);
        $counts = array_fill_keys($criteria, 0);

        foreach ($answers as $answer) {
            $q = $answer->question;
            $val = $answer->value;
            $criteriaKey = strtolower($q->kriteria);
            $score = $q->is_favorable ? $val : (6 - $val);

            if (in_array($criteriaKey, $criteria)) {
                $scores[$criteriaKey] += $score;
                $counts[$criteriaKey]++;
            }
        }

        foreach ($criteria as $c) {
            $scores[$c] = $counts[$c] > 0 ? round($scores[$c] / $counts[$c], 2) : 0;
        }

        return $scores;
    }

    protected function calculateFinalScores($userScores, $alternatives)
{
    $criteria = ['kreativitas', 'fisik', 'musik', 'teknologi', 'religiusitas'];

    // Bobot kriteria (pastikan jumlahnya 1)
    $weights = [
        'kreativitas' => 0.2,
        'fisik' => 0.2,
        'musik' => 0.2,
        'teknologi' => 0.2,
        'religiusitas' => 0.2,
    ];

    // Cari max dari alternatif per kriteria
    $maxAlternatives = [];
    foreach ($criteria as $c) {
        $maxAlternatives[$c] = $alternatives->max($c);
    }

    $results = [];

    foreach ($alternatives as $alt) {
        $totalScore = 0;

        foreach ($criteria as $c) {
            // Normalisasi nilai user (antara 1-5)
            $userNorm = $userScores[$c] > 0 ? $userScores[$c] / 5 : 0;

            // Normalisasi nilai alternatif
            $altNorm = $maxAlternatives[$c] > 0 ? $alt->$c / $maxAlternatives[$c] : 0;

            // Perhitungan skor akhir: user * alternatif * bobot
            $totalScore += $userNorm * $altNorm * $weights[$c];
        }

        $results[$alt->name] = round($totalScore, 4);
    }

    arsort($results);
    return $results;
}



    protected function mergeReligiousUKM($finalScores, $user)
    {
        $religiousUKMs = [
            'UKM LDK ALQORIB' => 'islam',
            'UKM Persekutuan Mahasiswa Kristen & Katolik (PMKK)' => 'kristen',
            'UKM Kesatuan Mahasiswa Hindu Darma Indonesia (KMHDI)' => 'hindu',
        ];

        $mergedScores = [];
        $religiousScores = ['islam' => 0, 'kristen' => 0, 'hindu' => 0];

        foreach ($finalScores as $name => $score) {
            if (isset($religiousUKMs[$name])) {
                $religiousScores[$religiousUKMs[$name]] = max($religiousScores[$religiousUKMs[$name]], $score);
            } else {
                $mergedScores[$name] = $score;
            }
        }

        $agamaUser = strtolower($user->setting->jurusan ?? '');
        $description = '';
        $religiousKey = null;

        if (in_array($agamaUser, ['islam', 'muslim'])) {
            $religiousKey = 'islam';
            $description = 'Rekomendasi UKM keagamaan untuk agama Islam: UKM LDK ALQORIB.';
        } elseif (in_array($agamaUser, ['kristen', 'katolik'])) {
            $religiousKey = 'kristen';
            $description = 'Rekomendasi UKM keagamaan untuk agama Kristen dan Katolik: UKM PMKK.';
        } elseif (in_array($agamaUser, ['hindu'])) {
            $religiousKey = 'hindu';
            $description = 'Rekomendasi UKM keagamaan untuk agama Hindu: UKM KMHDI.';
        }

        if ($religiousKey) {
            $mergedScores['UKM Keagamaan'] = $religiousScores[$religiousKey];
        }

        arsort($mergedScores);

        return [
            'top_ukms' => array_slice($mergedScores, 0, 3, true),
            'description' => $description,
        ];
    }

    public function exportPdf()
    {
        $user = auth()->user();
        $answers = Answer::with('question')->where('user_id', $user->id)->get();
        $userScores = $this->calculateUserScores($answers);
        $alternatives = Alternative::all();
        $finalScores = $this->calculateFinalScores($userScores, $alternatives);
        $finalUKM = $this->mergeReligiousUKM($finalScores, $user);

        $pdf = PDF::loadView('layouts.mahasiswa.SPK.pdf', compact('user', 'userScores', 'finalUKM'));
        return $pdf->download('hasil_spk_' . $user->id . '.pdf');
    }
}
