<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pengaduan</title>
    <style>
        table {
            width: 100%; border-collapse: collapse;
        }
        th, td {
            padding: 8px; border: 1px solid black; text-align: center;
        }
    </style>
</head>
<body>
    <h2>Laporan Rekapitulasi Pengaduan</h2>

    <form method="GET" action="{{ url('/laporan/pengaduan') }}">
        <label>Dari:</label>
        <input type="date" name="start_date" value="{{ request('start_date') }}">
        <label>Sampai:</label>
        <input type="date" name="end_date" value="{{ request('end_date') }}">
        <button type="submit">Filter</button>
    </form>

    <br>
    <table>
        <thead>
            <tr>
                <th>Kategori</th>
                <th>Status</th>
                <th>Jumlah Pengaduan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rekap as $row)
                <tr>
                    <td>{{ $row->kategori }}</td>
                    <td>{{ $row->status }}</td>
                    <td>{{ $row->jumlah }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">Tidak ada data untuk rentang tanggal ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
