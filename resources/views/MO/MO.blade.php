@extends('layouts.master')
@section('content')
<div class="container mt-4">
    <form action="{{ route('moUpload') }}" method="post" name="input-form" id="input-form">
        {{ csrf_field() }}
        <div class="row mb-3">
            <label class="col-sm-2 col-form-label">Pilih Material</label>
            <div class="col-sm-10">
                <div class="dropdown">
                    <select class="form-select" name="kode_bom">
                        <option selected>-- Pilih BOM --</option>
                        @if ($boms->count())
                        @foreach ($boms as $item)
                        <option value="{{ $item->id }}" data-toggle="">{{ $item->kode_bom }} -
                            {{ $item->nama_produk }}
                        </option>
                        @endforeach
                        @endif
                    </select>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-2 col-form-label">Jumlah</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="quantity" name="qty" required>
            </div>
        </div>
        <div class="form-group mt-3">
            <button type="submit" class="btn btn-primary">Add</button>
            <button type="button" class="btn btn-success" onclick="cetakTabel()">Cetak</button>
        </div>
        <br>
    </form>
    <div class="card">
        <div class="card-body">
            <br>
            <table class="table table-bordered datatable" id="moTable">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">ID Manufacture</th>
                        <th scope="col">Nama Produk</th>
                        <th scope="col">Jumlah</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($moDatas->count())
                    @foreach ($moDatas as $item)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $item->kode_mo }}</td>
                        @if ($item->status == 3)
                        <td>{{ $item->nama_produk }}</td>
                        @else
                        <td>{{ $item->nama_produk }}</td>
                        @endif
                        <td>{{ $item->qty }}</td>
                        <td>
                            @if ($item->status == 1)
                            <span class="badge badge-secondary" style="color: black">Backlog</span>
                            @elseif($item->status == 2)
                            <span class="badge badge-primary" style="color: black">Ditandai</span>
                            @elseif($item->status == 3)
                            <span class="badge badge-warning" style="color: black">Cek Ketersediaan</span>
                            @elseif($item->status == 4)
                            <span class="badge badge-secondary" style="color: black">Produksi</span>
                            @elseif($item->status == 5)
                            <span class="badge badge-success" style="color: black">Selesai</span>
                            @endif

                        </td>
                        <td>
                            @if ($item->status == 1)
                            <form action="/mo/update/{{ $item->id }}" method="post">
                                @method('put')
                                {{ csrf_field() }}
                                <button type="submit" onclick="return confirm('Proses Mark as todo?');"
                                    class="btn btn-info">Tandai</button>
                            </form>
                            @elseif($item->status == 2)
                            <form action="/mo/update/{{ $item->id }}" method="post">
                                @method('put')
                                {{ csrf_field() }}
                                <button type="submit" onclick="return confirm('Proses CA?');"
                                    class="btn btn-info">Cek Ketersediaan</button>
                            </form>
                            @elseif($item->status == 3)
                            <a href="{{ url('/mo/update/produk/cek/' . $item->id) }}"
                                class="btn btn-primary bi bi-search"></a>
                            @elseif($item->status == 4)
                            <form action="/mo/produksi/proses/{{ $item->id }}" method="post">
                                @method('post')
                                {{ csrf_field() }}
                                <button type="submit" onclick="return confirm('Sudah selesai?');"
                                    class="btn btn-info">Selesai</button>
                            </form>
                            @endif
                            @if ($item->status != 5)
                            <form action="{{ url('/mo/delete/' . $item->id) }}" method="post">
                                @method('delete')
                                {{ csrf_field() }}
                                <button type="submit"
                                    onclick="return confirm('Yakin hapus Rencana Produksi '+'{{ $item->nama_produk }}?');"
                                    class="btn btn-danger delete-confirm my-1 bi bi-trash3-fill">
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="7"> No record found </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function cetakTabel() {
        var printWindow = window.open('', '', 'height=600,width=800');
        printWindow.document.write('<html><head><title>Manufacturing Order - KonveksiKita</title>');
        printWindow.document.write('<style>');
        printWindow.document.write('body { font-family: Arial, sans-serif; padding: 20px; }');
        printWindow.document.write('h2 { text-align: center; margin-bottom: 20px; }');
        printWindow.document.write('table { border-collapse: collapse; width: 100%; margin-top: 20px; }');
        printWindow.document.write('th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }');
        printWindow.document.write('th { background-color: #f2f2f2; font-weight: bold; }');
        printWindow.document.write('.badge { padding: 4px 8px; border-radius: 4px; font-size: 12px; }');
        printWindow.document.write('.badge-secondary { background-color: #6c757d; color: white; }');
        printWindow.document.write('.badge-primary { background-color: #007bff; color: white; }');
        printWindow.document.write('.badge-warning { background-color: #ffc107; color: black; }');
        printWindow.document.write('.badge-success { background-color: #28a745; color: white; }');
        printWindow.document.write('@media print { body { margin: 0; } }');
        printWindow.document.write('</style>');
        printWindow.document.write('</head><body>');
        printWindow.document.write('<h2>Laporan Manufacturing Order</h2>');

        // Clone tabel dan hapus kolom Action
        var table = document.getElementById('moTable').cloneNode(true);
        var rows = table.getElementsByTagName('tr');

        // Hapus kolom Action (kolom terakhir)
        for (var i = 0; i < rows.length; i++) {
            var cells = rows[i].getElementsByTagName(i === 0 ? 'th' : 'td');
            if (cells.length > 0) {
                rows[i].removeChild(cells[cells.length - 1]);
            }
        }

        printWindow.document.write(table.outerHTML);
        printWindow.document.write('<br><p style="text-align: center; margin-top: 30px;">Dicetak pada: ' + new Date().toLocaleString('id-ID') + '</p>');
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.focus();

        setTimeout(function() {
            printWindow.print();
            printWindow.close();
        }, 250);
    }
</script>
@endsection