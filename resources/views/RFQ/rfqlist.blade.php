@extends('layouts.master')
@section('content')
<div class="container">
  <form action="{{url('/rfq/data/list/proses')}}" method="post" name="input-form" id="input-form">
    {{ csrf_field() }}
    <div class="row mb-3">
      <div class="col-sm-10">
        <input type="hidden" class="form-control" id="id_rfq" value="{{$rfq->id_rfq}}" name="id_rfq">
      </div>
    </div>
    <div class="row mb-3">
      <label class="col-sm-2 col-form-label">Vendor</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="vendor" value="{{$rfq->nama_vendor.' - '.$rfq->alamat}}" name="vendor" readonly>
      </div>
    </div>
    @if($rfq->status == 0)
    <div class="row mb-3">
      <label class="col-sm-2 col-form-label">Pilih Produk</label>
      <div class="col-sm-10">
        <select class="form-select" name="kode_produk" required>
          <option value="" disabled selected>-- Pilih Bahan --</option>
          @if($produk->count())
            @foreach($produk as $item)
              <option value="{{$item->id}}">{{$item->nama_produk}}</option>
            @endforeach
          @endif
        </select>
      </div>
    </div>
    <div class="row mb-3">
      <label class="col-sm-2 col-form-label">Quantity</label>
      <div class="col-sm-10">
        <input type="number" step="0.01" class="form-control" id="qty" name="qty" placeholder="Masukkan jumlah" required>
      </div>
    </div>
    <div class="row mb-3">
      <label class="col-sm-2 col-form-label">Satuan</label>
      <div class="col-sm-10">
        <select class="form-select" name="satuan" id="satuan" required>
          <option value="" disabled selected>-- Select Option --</option>
          <option value="M">M</option>
          <option value="Cm">Cm</option>
          <option value="Buah">Buah</option>
        </select>
      </div>
    </div>
    <div class="form-group mb-3">
      <button type="submit" name="simpan" class="btn btn-primary">Add Bahan</button>
      <a href="{{ route('RfqTampil') }}" class="btn btn-danger">Batal</a>
      <!-- <button type="button" class="btn btn-success" onclick="cetakRFQ()">Cetak RFQ</button> -->
    </div>
    @endif
  </form>
</div>

<div class="card">
  <div class="card-body">
    <br>
    <table class="table table-bordered" id="myTable">
      <thead>
        <tr>
          <th scope="col">No</th>
          <th scope="col">Kode</th>
          <th scope="col">Nama</th>
          <th scope="col">Banyak</th>
          <th scope="col">Satuan</th>
          <th scope="col">Harga</th>
          <th scope="col">Sub Total</th>
          @if($rfq->status == 0)
            <th scope="col">Action</th>
          @endif
        </tr>
      </thead>
      <tbody>
        @if($List->count())
          @foreach($List as $item)
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
              @if($rfq->status == 0)
                <td>
                  <a href="{{ url('product/bom-delete-item/'.$item->kode_bom_list) }}" 
                     class="btn btn-danger delete-confirm bi bi-trash3-fill" 
                     role="button"
                     onclick="return confirm('Yakin hapus item ini?');"></a>
                </td>
              @endif
            </tr>
          @endforeach
        @else
          <tr>
            <td colspan="8" class="text-center">Belum ada data</td>
          </tr>
        @endif
      </tbody>
    </table>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <br>
    <div class="row mb-3">
      <div class="col-sm-12">
        <label for="text_harga" class="font-weight-bold">Total Harga: </label>
        <label for="total_harga" id="val" class="ms-2">Rp {{number_format($rfq->total_harga, 0, ',', '.')}}</label>
      </div>
    </div>

    @if($rfq->status == 0)
      <form action="{{url('/rfq/data/list/saveitem/'.$rfq->id_rfq)}}" method="post" class="d-inline" name="confirm-form">
        {{ csrf_field() }}
        <input type="hidden" id="kode_rfq" name="kode_rfq" value="{{$rfq->id_rfq}}">
        <button type="submit" onclick="return confirm('Confirm Order?');" class="btn btn-success">Confirm Order</button>
      </form>

    @elseif($rfq->status == 1)
      <form action="{{url('/rfq/data/list/Pembayaran/'.$rfq->id_rfq)}}" method="post" name="payment-form">
        {{ csrf_field() }}
        <h6 class="mb-3">Pilih Metode Pembayaran:</h6>
        <div class="d-flex gap-3 mb-4">
          <div class="form-check">
            <input class="form-check-input" type="radio" name="payment" id="flexRadioDefault1" value="1" checked>
            <label class="form-check-label" for="flexRadioDefault1">
              Cash
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="payment" value="2" id="flexRadioDefault2">
            <label class="form-check-label" for="flexRadioDefault2">
              Transfer
            </label>
          </div>
        </div>
        <input type="hidden" id="kode_rfq" name="kode_rfq" value="{{$rfq->id_rfq}}">
        <button type="submit" onclick="return confirm('Proses Create Bill?');" class="btn btn-success">Create Bill</button>
      </form>

    @elseif($rfq->status == 2)
      <div class="mb-3">
        <label class="fw-bold">Metode Pembayaran: </label>
        <span>{{$rfq->pembayaran == 1 ? 'Cash' : 'Transfer'}}</span>
      </div>
      <form action="{{url('/rfq/data/list/Pembayaran/confirm/'.$rfq->id_rfq)}}" method="post" class="d-inline" name="bill-confirm-form">
        {{ csrf_field() }}
        <input type="hidden" id="id_rfq" name="id_rfq" value="{{$rfq->id_rfq}}">
        <button type="submit" onclick="return confirm('Confirm Bill?');" class="btn btn-success">Confirm Bill</button>
      </form>

    @elseif($rfq->status == 3)
      <div class="mb-2">
        <label class="fw-bold">Metode Pembayaran: </label>
        <span>{{$rfq->pembayaran == 1 ? 'Cash' : 'Transfer'}}</span>
      </div>
      <div class="mb-3">
        <label class="fw-bold">Status Pembayaran: </label>
        <span class="badge bg-success">Lunas</span>
      </div>
      <!-- <button type="button" class="btn btn-primary" onclick="cetakRFQ()">Cetak Laporan</button> -->
    @endif
  </div>
</div>

<!-- <script>
  function cetakRFQ() {
    var printWindow = window.open('', '', 'height=600,width=800');
    printWindow.document.write('<html><head><title>Request for Quotation - KonveksiKita</title>');
    printWindow.document.write('<style>');
    printWindow.document.write('body { font-family: Arial, sans-serif; padding: 20px; }');
    printWindow.document.write('h2, h3 { text-align: center; margin-bottom: 10px; }');
    printWindow.document.write('.info-section { margin: 20px 0; }');
    printWindow.document.write('.info-row { display: flex; margin-bottom: 8px; }');
    printWindow.document.write('.info-label { font-weight: bold; width: 150px; }');
    printWindow.document.write('table { border-collapse: collapse; width: 100%; margin-top: 20px; }');
    printWindow.document.write('th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }');
    printWindow.document.write('th { background-color: #f2f2f2; font-weight: bold; }');
    printWindow.document.write('.total-section { margin-top: 20px; text-align: right; font-size: 16px; }');
    printWindow.document.write('.total-label { font-weight: bold; font-size: 18px; }');
    printWindow.document.write('.footer { margin-top: 30px; text-align: center; font-size: 12px; color: #666; }');
    printWindow.document.write('@media print { body { margin: 0; } }');
    printWindow.document.write('</style>');
    printWindow.document.write('</head><body>');
    
    printWindow.document.write('<h2>REQUEST FOR QUOTATION</h2>');
    printWindow.document.write('<h3>KonveksiKita</h3>');
    
    printWindow.document.write('<div class="info-section">');
    printWindow.document.write('<div class="info-row"><span class="info-label">ID RFQ:</span><span>{{ $rfq->id_rfq }}</span></div>');
    printWindow.document.write('<div class="info-row"><span class="info-label">Vendor:</span><span>{{ $rfq->nama_vendor }}</span></div>');
    printWindow.document.write('<div class="info-row"><span class="info-label">Alamat:</span><span>{{ $rfq->alamat }}</span></div>');
    
    // Status pembayaran
    var statusText = '';
    @if($rfq->status >= 1)
      @if($rfq->status == 1)
        statusText = 'Menunggu Pembayaran';
      @elseif($rfq->status == 2)
        statusText = 'Bill Created - {{ $rfq->pembayaran == 1 ? "Cash" : "Transfer" }}';
      @elseif($rfq->status == 3)
        statusText = 'Lunas - {{ $rfq->pembayaran == 1 ? "Cash" : "Transfer" }}';
      @endif
      printWindow.document.write('<div class="info-row"><span class="info-label">Status:</span><span>' + statusText + '</span></div>');
    @endif
    printWindow.document.write('</div>');
    
    // Clone tabel dan hapus kolom Action
    var table = document.getElementById('myTable').cloneNode(true);
    var rows = table.getElementsByTagName('tr');
    
    var shouldRemoveAction = {{ $rfq->status == 0 ? 'true' : 'false' }};
    
    if (shouldRemoveAction) {
      // Hapus kolom Action (kolom terakhir)
      for (var i = 0; i < rows.length; i++) {
        var cells = rows[i].getElementsByTagName(i === 0 ? 'th' : 'td');
        if (cells.length > 0) {
          rows[i].removeChild(cells[cells.length - 1]);
        }
      }
    }
    
    printWindow.document.write(table.outerHTML);
    
    printWindow.document.write('<div class="total-section">');
    printWindow.document.write('<span class="total-label">Total Harga: Rp {{ number_format($rfq->total_harga, 0, ",", ".") }}</span>');
    printWindow.document.write('</div>');
    
    printWindow.document.write('<div class="footer">');
    printWindow.document.write('<p>Dicetak pada: ' + new Date().toLocaleString('id-ID') + '</p>');
    printWindow.document.write('</div>');
    
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.focus();
    
    setTimeout(function() {
      printWindow.print();
      printWindow.close();
    }, 250);
  }
</script> -->
@endsection