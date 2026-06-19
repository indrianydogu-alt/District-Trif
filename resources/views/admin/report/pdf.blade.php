<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #222; }
        h2 { margin: 0 0 4px; }
        .meta { margin-bottom: 12px; color: #555; font-size: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #999; padding: 6px 8px; text-align: left; }
        th { background: #f0f0f0; }
        tfoot td { font-weight: bold; }
    </style>
</head>
<body>
    <h2>{{ $title }}</h2>
    <div class="meta">
        Periode: {{ $from->format('d M Y') }} s.d. {{ $to->format('d M Y') }}
        | Dibuat: {{ now()->format('d M Y H:i') }}
    </div>
    <table>
        <thead>
            <tr>
                @foreach($headings as $h)
                    <th>{{ $h }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse($rows as $row)
                <tr>
                    @foreach($row as $cell)
                        <td>{{ $cell }}</td>
                    @endforeach
                </tr>
            @empty
                <tr><td colspan="{{ count($headings) }}" style="text-align:center;color:#888;">Tidak ada data.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
