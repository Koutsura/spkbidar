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
                <td>{{ $criteria }}</td>
                <td>{{ $score }}</td>
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
            @foreach ($finalUKM['top_ukms'] as $ukm => $score)
            <tr>
                <td>{{ $ukm }}</td>
                <td>{{ number_format($score, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @if ($finalUKM['description'])
    <p><strong>Catatan:</strong> {{ $finalUKM['description'] }}</p>
    @endif

</body>
</html>
