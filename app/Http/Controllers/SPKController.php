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
        $index = max(1, min($index, $total));

        $question = $questions[$index - 1];
        $answered = Answer::where('user_id', $user->id)->pluck('question_id')->toArray();

        if (request()->ajax()) {
            return view('layouts.mahasiswa.SPK.question_partial', [
                'index' => $index,
                'total' => $total,
                'question' => $question,
                'user' => $user
            ]);
        }

        return view('layouts.mahasiswa.SPK.question', [
            'index' => $index,
            'total' => $total,
            'question' => $question,
            'questions' => $questions,
            'answered' => $answered,
            'user' => $user
        ]);
    }

    public function storeAnswer(Request $request, $index)
    {
        $request->validate([
            'value' => 'required|in:1,2,3,4,5',
        ]);

        $user = auth()->user();
        $question = Question::orderBy('id')->get()[$index - 1];

        Answer::updateOrCreate(
            ['user_id' => $user->id, 'question_id' => $question->id],
            ['value' => $request->input('value')]
        );

        $isLast = $index == Question::count();
        return response()->json([
            'success' => true,
            'redirect' => $isLast ? route('spk.result') : null,
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

protected function calculateSAWScores($userScores, $alternatives)
{
    $criteria = ['kreativitas', 'keaktifan', 'teknologi', 'inovatif', 'fisik & olahraga', 'komunikasi & public speaking', 'religiusitas', 'seni & musik'];
    $weight = 1 / count($criteria);

    $results = [];

    foreach ($alternatives as $alt) {
        $totalScore = 0;
        foreach ($criteria as $criterion) {
            $userValue = $userScores[$criterion] ?? 0;
            $altValue = $alt->$criterion;
            $criterionScore = $weight * $altValue * $userValue;
            $totalScore += $criterionScore;
        }
        $results[$alt->name] = round($totalScore, 4);
    }

    return $results;
}

// Hitung jarak Euclidean antar 2 data berdasarkan kriteria
protected function euclideanDistance($data1, $data2, $criteria)
{
    $sumSquares = 0;
    foreach ($criteria as $criterion) {
        $diff = ($data1->$criterion ?? 0) - ($data2->$criterion ?? 0);
        $sumSquares += $diff * $diff;
    }
    return sqrt($sumSquares);
}

// Prediksi 1 data testing dengan KNN
protected function predictKNN($testData, $trainingData, $criteria, $k = 3)
{
    $distances = [];

    foreach ($trainingData as $trainData) {
        if ($trainData->name === $testData->name) continue; // skip jika sama

        $distance = $this->euclideanDistance($testData, $trainData, $criteria);
        $distances[$trainData->name] = $distance;
    }

    asort($distances); // urutkan jarak terdekat

    // Ambil k terdekat
    $nearestNeighbors = array_slice($distances, 0, $k, true);

    // Voting mayoritas
    $votes = [];
    foreach ($nearestNeighbors as $neighborName => $dist) {
        $votes[$neighborName] = ($votes[$neighborName] ?? 0) + 1;
    }

    arsort($votes);

    return key($votes);
}

// Hitung prediksi KNN untuk banyak data testing
protected function calculateKNN($testAlternatives, $trainingAlternatives, $criteria, $k = 3)
{
    $predictions = [];

    foreach ($testAlternatives as $testAlt) {
        $predictedClass = $this->predictKNN($testAlt, $trainingAlternatives, $criteria, $k);
        $predictions[$testAlt->name] = $predictedClass;
    }

    return $predictions;
}

public function result()
{
    $user = auth()->user();
    $answers = Answer::with('question')->where('user_id', $user->id)->get();

    $userScores = $this->calculateUserScores($answers);
    $alternatives = Alternative::all();

    $finalScores = $this->calculateSAWScores($userScores, $alternatives);

    $bonusUKMName = 'Inovator Center (DIIB)';
    $bonusScore = null;

    $bonusThreshold = 3.7;
    $bonusCriteria = ['kreativitas', 'keaktifan', 'teknologi', 'inovatif'];
    $showBonus = true;

    foreach ($bonusCriteria as $criteria) {
        if (($userScores[$criteria] ?? 0) < $bonusThreshold) {
            $showBonus = false;
            break;
        }
    }

    if (isset($finalScores[$bonusUKMName])) {
        $bonusScore = $finalScores[$bonusUKMName];
        unset($finalScores[$bonusUKMName]);
    }

    arsort($finalScores);
    $topUKM = array_slice($finalScores, 0, 3, true);
    $topUKMKeys = array_keys($topUKM);

    $criteria = ['kreativitas', 'keaktifan', 'teknologi', 'inovatif', 'fisik & olahraga', 'komunikasi & public speaking', 'religiusitas', 'seni & musik'];

    $testAlternatives = Alternative::whereIn('name', $topUKMKeys)->get();
    $trainingAlternatives = $alternatives;

    $knnPredictions = $this->calculateKNN($testAlternatives, $trainingAlternatives, $criteria, 3);

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
        'knnPredictions' => $knnPredictions,
    ]);
}


    public function exportPdf()
{
    $user = auth()->user();
    $answers = Answer::with('question')->where('user_id', $user->id)->get();

    if ($answers->isEmpty()) {
        return redirect()->back()->with('error', 'Data jawaban tidak ditemukan.');
    }

    $userScores = $this->calculateUserScores($answers);
    $alternatives = Alternative::all();
    $finalScores = $this->calculateSAWScores($userScores, $alternatives);

    $bonusUKMName = 'Inovator Center (DIIB)';
    $bonusScore = null;

    $bonusThreshold = 3.7;
    $bonusCriteria = ['kreativitas', 'keaktifan', 'teknologi', 'inovatif'];
    $showBonus = true;

    foreach ($bonusCriteria as $criteria) {
        if (($userScores[$criteria] ?? 0) < $bonusThreshold) {
            $showBonus = false;
            break;
        }
    }

    if (isset($finalScores[$bonusUKMName])) {
        $bonusScore = $finalScores[$bonusUKMName];
        unset($finalScores[$bonusUKMName]);
    }

    arsort($finalScores);
    $topUKM = array_slice($finalScores, 0, 3, true);
    $topUKMKeys = array_keys($topUKM);

    $criteria = ['kreativitas', 'keaktifan', 'teknologi', 'inovatif', 'fisik & olahraga', 'komunikasi & public speaking', 'religiusitas', 'seni & musik'];

    $testAlternatives = Alternative::whereIn('name', $topUKMKeys)->get();
    $trainingAlternatives = $alternatives;

    $knnPredictionsRaw = $this->calculateKNN($testAlternatives, $trainingAlternatives, $criteria, 3);

    // Buat array sederhana agar di view gampang diakses (karena sekarang knnPredictionsRaw itu ['UKM' => 'PredictedClass', ...])
    $knnPredictions = [];
    foreach ($knnPredictionsRaw as $ukmName => $predictedClass) {
        $knnPredictions[] = [
            'ukm_name' => $ukmName,
            'predicted_class' => $predictedClass,
        ];
    }

    $pdf = PDF::loadView('layouts.mahasiswa.SPK.pdf', [
        'criteriaScores' => $userScores,
        'finalUKM' => $topUKM,
        'showBonus' => $showBonus,
        'bonusUKM' => $bonusUKMName,
        'bonusScore' => $showBonus ? $bonusScore : null,
        'user' => $user,
        'knnPredictions' => $knnPredictions,
    ]);

    return $pdf->download('hasil_spk_' . $user->name . '.pdf');
}





}
