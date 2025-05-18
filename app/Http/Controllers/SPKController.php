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

        // ⛔ CEK JIKA SUDAH PERNAH TES
        if (Result::where('user_id', $user->id)->exists()) {
            return redirect()->route('spk.result')->with('error', 'Kamu sudah mengikuti tes rekomendasi UKM.');
        }

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

        // ⛔ CEK JIKA SUDAH PERNAH TES
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

        // Hitung skor user berdasarkan jawaban
        $userScores = $this->calculateUserScores($answers);

        // Ambil alternatif UKM, kecuali UKM Inovator Center
        $alternatives = Alternative::where('name', '!=', 'Inovator Center (DIIB)')->get();

        // Hitung skor akhir dengan SAW
        $finalScores = $this->calculateFinalScores($userScores, $alternatives);

        // BONUS: Deteksi apakah layak tampilkan UKM Inovator Center
        $bonusThreshold = 4.0;
        $showBonus = ($userScores['kreativitas'] >= $bonusThreshold && $userScores['teknologi'] >= $bonusThreshold);

        // Pastikan tidak ada UKM Inovator Center dalam skor utama
        unset($finalScores['Inovator Center (DIIB)']);

        // Ambil 3 UKM teratas dari hasil finalScores
        $topUKMKeys = array_keys($finalScores);

        // Simpan ke database
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
            'finalUKM' => array_slice($finalScores, 0, 3, true),
            'showBonus' => $showBonus,
            'bonusUKM' => 'Inovator Center (DIIB)',
            'bonusScore' => 0.9,
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

    // Vektor user
    $userVector = [];
    foreach ($criteria as $c) {
        $userVector[] = $userScores[$c];
    }

    // Hitung magnitude (panjang) vektor user
    $userMagnitude = sqrt(array_reduce($userVector, fn($carry, $v) => $carry + ($v * $v), 0));

    $results = [];

    foreach ($alternatives as $alt) {
        // Vektor alternatif
        $altVector = [];
        foreach ($criteria as $c) {
            $altVector[] = $alt->$c;
        }

        // Hitung dot product
        $dotProduct = 0;
        foreach ($criteria as $i => $c) {
            $dotProduct += $userScores[$c] * $alt->$c;
        }

        // Hitung magnitude alternatif
        $altMagnitude = sqrt(array_reduce($altVector, fn($carry, $v) => $carry + ($v * $v), 0));

        // Cosine Similarity (hindari pembagian 0)
        if ($userMagnitude == 0 || $altMagnitude == 0) {
            $similarity = 0;
        } else {
            $similarity = $dotProduct / ($userMagnitude * $altMagnitude);
        }

        // Simpan hasil dengan 4 angka di belakang koma
        $results[$alt->name] = round($similarity, 4);
    }

    // Urutkan dari tertinggi ke terendah
    arsort($results);

    return $results;
}



    public function exportPdf()
    {
        $user = auth()->user();
        $answers = Answer::with('question')->where('user_id', $user->id)->get();

        // Skor per kriteria
        $criteriaScores = $this->calculateUserScores($answers);

        // Alternatif dan perhitungan final, exclude Inovator Center
        $alternatives = Alternative::where('name', '!=', 'Inovator Center (DIIB)')->get();

        $finalScores = $this->calculateFinalScores($criteriaScores, $alternatives);

        // Kirim variabel sesuai view
        $pdf = PDF::loadView('layouts.mahasiswa.SPK.pdf', [
            'user' => $user,
            'criteriaScores' => $criteriaScores,
            'finalUKM' => array_slice($finalScores, 0, 3, true),
        ]);

        return $pdf->download('hasil_spk_' . $user->name . '.pdf');
    }
}
