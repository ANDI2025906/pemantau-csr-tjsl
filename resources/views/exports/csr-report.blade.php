<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>CSR Assessment Report</title>
    <style>
        body { 
            font-family: DejaVu Sans, sans-serif; 
            padding: 20px;
        }
        .header { 
            text-align: center; 
            margin-bottom: 30px; 
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 20px; 
            font-size: 12px;
        }
        th, td { 
            border: 1px solid #ddd; 
            padding: 8px; 
            text-align: left; 
        }
        th { 
            background-color: #f4f4f4; 
        }
        .summary { 
            margin-bottom: 30px; 
        }
        .summary-item { 
            margin-bottom: 10px; 
        }
        .page-break { 
            page-break-after: always; 
        }
        h1 { font-size: 24px; }
        h2 { font-size: 18px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Penilaian CSR</h1>
        <p>Periode: {{ $startDate->format('d/m/Y') }} - {{ $endDate->format('d/m/Y') }}</p>
        @if($company)
            <p>Perusahaan: {{ $company->name }}</p>
        @endif
    </div>

    <div class="summary">
        <h2>Ringkasan</h2>
        <div class="summary-item">Total Penilaian: {{ $statistics['total_assessments'] }}</div>
        <div class="summary-item">Skor Rata-rata: {{ $statistics['average_score'] }}/3</div>
        <div class="summary-item">Review Selesai: {{ $statistics['completed_reviews'] }}</div>
    </div>

    <h2>Skor per Kategori</h2>
    <table>
        <thead>
            <tr>
                <th>Kategori</th>
                <th>Skor Rata-rata</th>
                <th>Total Penilaian</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categoryScores as $score)
            <tr>
                <td>{{ $score->category }}</td>
                <td>{{ $score->average_score }}/3</td>
                <td>{{ $score->total_assessments }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="page-break"></div>

    <h2>Detail Penilaian</h2>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Indikator</th>
                <th>Skor</th>
                <th>Status</th>
                <th>Reviewer</th>
            </tr>
        </thead>
        <tbody>
            @foreach($assessments as $assessment)
            <tr>
                <td>{{ $assessment->created_at->format('d/m/Y') }}</td>
                <td>{{ $assessment->indicator->name }}</td>
                <td>{{ $assessment->score }}/3</td>
                <td>{{ ucfirst($assessment->status) }}</td>
                <td>{{ $assessment->reviewer ? $assessment->reviewer->name : '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
