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

    if (Result::where('user_id', $user->id)->exists()) {
        return redirect()->route('spk.result')->with('error', 'Kamu sudah mengikuti tes rekomendasi UKM.');
    }

    $questions = Question::orderBy('id')->get();
    $total = $questions->count();
    $question = $questions[$index - 1] ?? null;

    if (!$question) {
        return redirect()->route('spk.result');
    }

    // Ambil ID semua soal
    $answered = Answer::where('user_id', $user->id)->pluck('question_id')->toArray();

    return view('layouts.mahasiswa.SPK.question', [
        'question' => $question,
        'index' => $index,
        'total' => $total,
        'user' => $user,
        'questions' => $questions, // untuk daftar soal
        'answered' => $answered,   // array ID soal yang sudah dijawab
    ]);
}


    public function storeAnswer(Request $request, $index)
    {
        $request->validate([
            'value' => 'required|integer|min:1|max:5',
        ]);

        $user = auth()->user();

        if (Result::where('user_id', $user->id)->exists()) {
            return redirect()->route('spk.result')->with('error', 'Kamu sudah mengikuti tes rekomendasi UKM.');
        }

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

    // Hitung skor rata-rata user per kriteria
    $userScores = $this->calculateUserScores($answers);

    // Ambil semua alternatif termasuk Inovator Center
    $alternatives = Alternative::all();

    // Hitung skor SAW+KNN semua UKM
    $finalScores = $this->calculateFinalScores($userScores, $alternatives);

    // Nama UKM untuk bonus
    $bonusUKMName = 'Inovator Center (DIIB)';
    $bonusScore = null;

    // Cek apakah syarat bonus terpenuhi (semua >= 3.7)
    $bonusThreshold = 3.7;
    $bonusCriteria = ['kreativitas', 'keaktifan', 'teknologi', 'inovatif'];
    $showBonus = true;

    foreach ($bonusCriteria as $criteria) {
        if (($userScores[$criteria] ?? 0) < $bonusThreshold) {
            $showBonus = false;
            break;
        }
    }

    // Simpan skor bonus dan keluarkan dari daftar utama
    if (isset($finalScores[$bonusUKMName])) {
        $bonusScore = $finalScores[$bonusUKMName];
        unset($finalScores[$bonusUKMName]); // keluarkan dari finalScores agar tidak masuk 3 besar
    }

    // Ambil 3 teratas UKM dari hasil final tanpa Inovator Center
    arsort($finalScores); // urutkan dari skor tertinggi
    $topUKM = array_slice($finalScores, 0, 3, true);
    $topUKMKeys = array_keys($topUKM);

    // Simpan hasil ke database
    Result::updateOrCreate(
        ['user_id' => $user->id],
        [
            'recommended_1' => $topUKMKeys[0] ?? null,
            'recommended_2' => $topUKMKeys[1] ?? null,
            'recommended_3' => $topUKMKeys[2] ?? null,
            'show_innovator_center' => $showBonus ? 1 : 0,
        ]
    );

    return view('layouts.mahasiswa.SPK.result', [
        'criteriaScores' => $userScores,
        'finalUKM' => $topUKM,
        'showBonus' => $showBonus,
        'bonusUKM' => $bonusUKMName,
        'bonusScore' => $showBonus ? $bonusScore : null,
        'user' => $user,
    ]);
}



    protected function calculateUserScores($answers)
    {
        $criteria = ['kreativitas', 'keaktifan','teknologi','inovatif','fisik & olahraga','komunikasi & public speaking', 'religiusitas','seni & musik'];
        $scores = array_fill_keys($criteria, 0);
        $counts = array_fill_keys($criteria, 0);

        foreach ($answers as $answer) {
            $q = $answer->question;
            $val = $answer->value;

            $criteriaKey = strtolower($q->kriteria);
            $isFavorable = $q->indikator === 'favorable';

            if (!in_array($criteriaKey, $criteria)) {
                continue;
            }

            // Sesuaikan nilai sesuai indikator favorable/unfavorable
            $score = $isFavorable ? $val : (6 - $val);

            $scores[$criteriaKey] += $score;
            $counts[$criteriaKey]++;
        }

        // Hitung rata-rata skor per kriteria
        foreach ($criteria as $c) {
            $scores[$c] = $counts[$c] > 0 ? round($scores[$c] / $counts[$c], 2) : 0;
        }

        return $scores;
    }

    protected function calculateFinalScores($userScores, $alternatives)
    {
        $criteria = ['kreativitas', 'keaktifan','teknologi','inovatif','fisik & olahraga','komunikasi & public speaking', 'religiusitas','seni & musik'];

        // Cari nilai maksimum tiap kriteria dari alternatif (untuk normalisasi)
        $maxPerCriteria = [];
        foreach ($criteria as $c) {
            $values = $alternatives->pluck($c)->toArray();
            $maxPerCriteria[$c] = !empty($values) ? max($values) : 1;
        }

        // Normalisasi vektor user berdasarkan max nilai alternatif tiap kriteria
        $userVector = [];
        foreach ($criteria as $c) {
            $max = $maxPerCriteria[$c];
            $userVector[] = $max > 0 ? ($userScores[$c] ?? 0) / $max : 0;
        }

        $results = [];

        foreach ($alternatives as $alt) {
            // Vektor alternatif normalisasi
            $altVector = [];
            foreach ($criteria as $c) {
                $max = $maxPerCriteria[$c];
                $altVector[] = $max > 0 ? $alt->$c / $max : 0;
            }

            // Hitung dot product, magnitude user dan alternatif
            $dotProduct = 0;
            $userMagnitude = 0;
            $altMagnitude = 0;

            foreach ($criteria as $i => $c) {
                $dotProduct += $userVector[$i] * $altVector[$i];
                $userMagnitude += $userVector[$i] * $userVector[$i];
                $altMagnitude += $altVector[$i] * $altVector[$i];
            }

            $userMagnitude = sqrt($userMagnitude);
            $altMagnitude = sqrt($altMagnitude);

            // Hindari pembagian dengan nol
            if ($userMagnitude == 0 || $altMagnitude == 0) {
                $similarity = 0;
            } else {
                $similarity = $dotProduct / ($userMagnitude * $altMagnitude);
            }

            $results[$alt->name] = round($similarity, 4);
        }

        // Urutkan hasil dari yang tertinggi
        arsort($results);

        return $results;
    }

    public function exportPdf()
{
    $user = auth()->user();
    $answers = Answer::with('question')->where('user_id', $user->id)->get();

    // Hitung skor kriteria pengguna
    $criteriaScores = $this->calculateUserScores($answers);

    // Ambil semua alternatif termasuk Inovator Center
    $allAlternatives = Alternative::all();
    $finalScores = $this->calculateFinalScores($criteriaScores, $allAlternatives);

    $bonusUKMName = 'Inovator Center (DIIB)';
    $bonusThreshold = 3.7;

    // Cek apakah pengguna memenuhi syarat bonus
    $showBonus = (
        ($criteriaScores['kreativitas'] ?? 0) >= $bonusThreshold &&
        ($criteriaScores['keaktifan'] ?? 0) >= $bonusThreshold &&
        ($criteriaScores['teknologi'] ?? 0) >= $bonusThreshold &&
        ($criteriaScores['inovatif'] ?? 0) >= $bonusThreshold
    );

    // Simpan skor bonus jika ada
    $bonusScore = $finalScores[$bonusUKMName] ?? null;

    // Hapus dari 3 besar jika bukan bagian utama
    if (isset($finalScores[$bonusUKMName])) {
        unset($finalScores[$bonusUKMName]);
    }

    // Ambil 3 rekomendasi utama
    $top3UKM = array_slice($finalScores, 0, 3, true);

    // Generate PDF
    $pdf = PDF::loadView('layouts.mahasiswa.SPK.pdf', [
        'user' => $user,
        'criteriaScores' => $criteriaScores,
        'finalUKM' => $top3UKM,
        'showBonus' => $showBonus,
        'bonusUKM' => $bonusUKMName,
        'bonusScore' => $showBonus ? $bonusScore : null,
    ]);

    return $pdf->download('hasil_spk_' . $user->name . '.pdf');
}

}
