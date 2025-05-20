<!DOCTYPE html>
<html>
<head>
    <title>Hasil SPK</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        h1, h3 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
    </style>
</head>
<body>
    <h1>Hasil Sistem Pendukung Keputusan</h1>

    <p><strong>Nama:</strong> {{ $user->name }}</p>
    <p><strong>NIM:</strong> {{ $user->setting->nim ?? '-' }}</p>
    <p><strong>Jurusan:</strong> {{ $user->setting->jurusan ?? '-' }}</p>

    <h3>Skor per Kriteria</h3>
    <table>
        <thead>
            <tr>
                <th>Kriteria</th>
                <th>Skor</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($criteriaScores as $criteria => $score)
            <tr>
                <td>{{ ucfirst($criteria) }}</td>
                <td>{{ number_format($score, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Rekomendasi UKM Terbaik</h3>
    <table>
        <thead>
            <tr>
                <th>UKM</th>
                <th>Skor</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($finalUKM as $ukm => $score)
            <tr>
                <td>{{ $ukm }}</td>
                <td>{{ number_format($score, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @if ($showBonus && $bonusUKM && $bonusScore)
    <h3>Rekomendasi Bonus</h3>
    <table>
        <thead>
            <tr>
                <th>Bonus</th>
                <th>Skor</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $bonusUKM }}</td>
                <td>{{ number_format($bonusScore, 2) }}</td>
            </tr>
        </tbody>
    </table>
    @endif

</body>
</html>
