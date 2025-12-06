@extends('layouts.master')
@section('content')
<div class="container">

    {{-- Tampilkan error global (opsional) --}}
    @if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ url('/bom/item_list/upload') }}" method="post" name="input-form" id="input-form">
        {{ csrf_field() }}
        <div class="form-group">
            <input type="hidden" class="form-control" name="id" id="kode_bom" value="{{ $bom->id }}" readonly>
        </div>
        <div class="row mb-3">
            <label class="col-sm-2 col-form-label">Nama Produk</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="nama_produk" value="{{$bom->nama_produk}}" disabled>
            </div>
        </div>

        {{-- Pilih Material --}}
        <div class="row mb-3">
            <label class="col-sm-2 col-form-label">Pilih Material</label>
            <div class="col-sm-10">
                <select class="form-select" name="kode_produk" required>
                    <option value="" disabled selected>-- Pilih Bahan --</option>
                    @foreach($materials as $item)
                    <option value="{{ $item->id }}">{{ $item->nama_produk }}</option>
                    @endforeach
                </select>
                @error('kode_produk')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        {{-- Banyak Bahan --}}
        <div class="row mb-3">
            <label class="col-sm-2 col-form-label">Banyak Bahan</label>
            <div class="col-sm-10">
                <input type="number" step="0.01" class="form-control" name="qty" id="quantity" value="{{ old('qty') }}" required>
                @error('qty')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        {{-- Satuan --}}
        <div class="row mb-3">
            <label class="col-sm-2 col-form-label">Satuan</label>
            <div class="col-sm-10">
                <select class="form-select" name="satuan" id="satuan" required>
                    <option value="" disabled selected>-- Select Option --</option>
                    <option value="M">M</option>
                    <option value="Cm">Cm</option>
                    <option value="Buah">Buah</option>
                </select>
                @error('satuan')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="form-group mt-3">
            <button type="submit" name="simpan" class="btn btn-primary">Tambah Bahan</button>
            <a href="{{ route('tampilBom') }}" class="btn btn-danger">Batal</a>
            <button type="button" class="btn btn-success" onclick="cetakTabel()">Cetak</button>
        </div>
    </form>
</div>
<div class="container-fluid mt-4">
    <div class="card">
        <div class="card-body">
            <br>
            <table class="table table-bordered" id="myTable">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Kode</th>
                        <th scope="col">Nama Bahan</th>
                        <th scope="col">Banyak</th>
                        <th scope="col">Satuan</th>
                        <th scope="col">Harga Satuan</th>
                        <th scope="col">Harga Total</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if($list->count())
                    @foreach($list as $item)
                    <tr>
                        <th scope="row">{{$loop->iteration}}</th>
                        <td>{{ $item->id_reference }}</td>
                        <td>{{$item->nama_produk}}</td>
                        <td>{{$item->qty}}</td>
                        <td>{{$item->satuan}}</td>
                        <td>{{$item->harga}}</td>
                        @php
                        $total = $item->harga * $item->qty;
                        @endphp
                        <td>{{$total}}</td>
                        <td>
                            <a href="{{ url('/bom/delete_item_list/'.$item->kode_bom_list) }}" class="btn btn-danger delete-confirm bi bi-trash3-fill" role="button"></a>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <br>
            <div class="container-sm ">
                <div class="row"></div>
                <div class="row mt-auto p-2 bd-highlight">
                    <label for="text_harga" class="font-weight-bold"> Total Harga : </label>
                    <label for="total_harga" id="val">{{ $bom->total_harga }}</label>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function cetakTabel() {
        var printWindow = window.open('', '', 'height=600,width=800');
        printWindow.document.write('<html><head><title>KonveksiKita</title>');
        printWindow.document.write('<style>');
        printWindow.document.write('table { border-collapse: collapse; width: 100%; }');
        printWindow.document.write('th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }');
        printWindow.document.write('h2 { text-align: center; margin-bottom: 20px; }');
        printWindow.document.write('</style>');
        printWindow.document.write('</head><body>');
        printWindow.document.write('<h2>Tabel BOM</h2>');
        printWindow.document.write(document.getElementById('myTable').outerHTML);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
    }
</script>
@endsection