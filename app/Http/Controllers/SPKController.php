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

    // Gabungkan UKM keagamaan dan tambah deskripsi agama
    $finalUKM = $this->mergeReligiousUKM($finalScores, $user);

    // BONUS: Cek kreativitas & teknologi user
    $bonusThreshold = 4.0;
    $hasBonus = ($userScores['kreativitas'] >= $bonusThreshold && $userScores['teknologi'] >= $bonusThreshold);

    if ($hasBonus) {
        // Beri skor bonus untuk UKM Inovator Center supaya muncul di rekomendasi
        // Misal skor bonus 0.9 agar masuk top
        $finalUKM['top_ukms']['UKM Inovator Center'] = 0.9;
    }

    // Urutkan ulang top UKM setelah tambah bonus (agar Inovator Center tepat posisi)
    arsort($finalUKM['top_ukms']);

    // Simpan hasil ke tabel results dengan kondisi bonus
    Result::updateOrCreate(
        ['user_id' => $user->id],
        [
            'recommended_1' => array_key_first($finalUKM['top_ukms']),
            'recommended_2' => array_keys($finalUKM['top_ukms'])[1] ?? null,
            'recommended_3' => array_keys($finalUKM['top_ukms'])[2] ?? null,
            'show_innovator_center' => $hasBonus ? 1 : 0,
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
        $isFavorable = $q->indikator === 'favorable'; // ← PERBAIKAN PENTING DI SINI

        if (!in_array($criteriaKey, $criteria)) {
            continue;
        }

        // Skor berdasarkan jenis indikator
        $score = $isFavorable ? $val : (6 - $val);

        $scores[$criteriaKey] += $score;
        $counts[$criteriaKey]++;
    }

    // Hitung rata-rata skor (1–5)
    foreach ($criteria as $c) {
        $scores[$c] = $counts[$c] > 0 ? round($scores[$c] / $counts[$c], 2) : 0;
    }

    return $scores;
}



    protected function calculateFinalScores($userScores, $alternatives)
{
    $criteria = ['kreativitas', 'fisik', 'musik', 'teknologi', 'religiusitas'];

    $weights = [
        'kreativitas' => 0.2,
        'fisik' => 0.2,
        'musik' => 0.2,
        'teknologi' => 0.2,
        'religiusitas' => 0.2,
    ];

    // Cari max nilai alternatif per kriteria untuk normalisasi
    $maxAlternatives = [];
    foreach ($criteria as $c) {
        $maxAlternatives[$c] = $alternatives->max($c);
    }

    $results = [];

    foreach ($alternatives as $alt) {
        $totalScore = 0;

        foreach ($criteria as $c) {
            $userNorm = $userScores[$c] > 0 ? $userScores[$c] / 5 : 0; // user max 5
            $altNorm = $maxAlternatives[$c] > 0 ? $alt->$c / $maxAlternatives[$c] : 0;

            $totalScore += $userNorm * $altNorm * $weights[$c];
        }

        $results[$alt->name] = round($totalScore, 4);
    }

    arsort($results); // Urutkan skor tertinggi

    return $results;
}




    // Potongan yang perlu diganti/ditambahkan:

protected function mergeReligiousUKM($finalScores, $user)
{
    $religiousUKMs = [
        'UKM LDK ALQORIB' => 'islam',
        'UKM Persekutuan Mahasiswa Kristen & Katolik (PMKK)' => 'kristen',
        'UKM Kesatuan Mahasiswa Hindu Darma Indonesia (KMHDI)' => 'hindu',
    ];

    $mergedScores = [];
    $religiousScores = ['islam' => 0, 'kristen' => 0, 'hindu' => 0];

    // Pisahkan UKM keagamaan dan non-keagamaan
    foreach ($finalScores as $name => $score) {
        if (isset($religiousUKMs[$name])) {
            $agama = $religiousUKMs[$name];
            $religiousScores[$agama] = max($religiousScores[$agama], $score);
        } else {
            $mergedScores[$name] = $score;
        }
    }

    // Ambil agama user (pastikan 'agama' disimpan di user->setting)
    $agamaUser = strtolower($user->setting->agama ?? '');

    $description = '';
    $religiousKey = null;

    if (in_array($agamaUser, ['islam', 'muslim'])) {
        $religiousKey = 'islam';
        $description = 'Rekomendasi UKM keagamaan untuk agama Islam: UKM LDK ALQORIB.';
    } elseif (in_array($agamaUser, ['kristen', 'katolik'])) {
        $religiousKey = 'kristen';
        $description = 'Rekomendasi UKM keagamaan untuk agama Kristen/Katolik: UKM PMKK.';
    } elseif (in_array($agamaUser, ['hindu'])) {
        $religiousKey = 'hindu';
        $description = 'Rekomendasi UKM keagamaan untuk agama Hindu: UKM KMHDI.';
    }

    // Tambahkan skor UKM keagamaan ke hasil akhir jika nilai religiusitas dominan
    if ($religiousKey) {
        $dominantCriteria = array_keys($this->calculateUserScores(Answer::where('user_id', $user->id)->get()), max($this->calculateUserScores(Answer::where('user_id', $user->id)->get())))[0];

        if ($dominantCriteria === 'religiusitas') {
            // Tambahkan UKM keagamaan dengan label khusus
            $mergedScores["UKM Keagamaan"] = $religiousScores[$religiousKey];
        }
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
