<!DOCTYPE html>
<html>
<head>
    <title>Hasil SPK PDF</title>
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
    </style>
</head>
<body>
    <h2>Hasil Sistem Pendukung Keputusan (SPK)</h2>
    <p>Nama Mahasiswa: {{ $user->name }}</p>

    <h3>Skor Per Kriteria</h3>
    <table>
        <thead>
            <tr>
                <th>Kriteria</th>
                <th>Skor Rata-rata</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($criteriaScores as $kriteria => $score)
                <tr>
                    <td>{{ ucfirst($kriteria) }}</td>
                    <td>{{ $score }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Rekomendasi UKM (SAW)</h3>
    <table>
        <thead>
            <tr>
                <th>UKM</th>
                <th>Skor Akhir</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($finalUKM as $ukm => $score)
                <tr>
                    <td>{{ $ukm }}</td>
                    <td>{{ $score }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if ($showBonus)
        <h3>Bonus UKM: {{ $bonusUKM }}</h3>
        <p>Skor Bonus: {{ $bonusScore }}</p>
    @endif

    <h3>Prediksi KNN</h3>
    <table>
        <thead>
            <tr>
                <th>UKM</th>
                <th>Prediksi Kelas</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($knnPredictions as $prediction)
                <tr>
                    <td>{{ $prediction['ukm_name'] }}</td>
                    <td>{{ $prediction['predicted_class'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
