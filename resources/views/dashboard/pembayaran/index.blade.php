@extends('dashboard.base')

@section('content')

<div class="container-fluid">
            <div class="fade-in">
              <div class="row">
                <div class="col-lg-12">
                  <div class="card">
                    <div class="card-header"><i class="fa fa-align-justify"></i> PEMBAYARAN</div>
                    <div class="card-body">
                      <br>
                      @if(Session::has('message'))
                          <div class="alert alert-success" role="alert">{{ Session::get('message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                      @endif
                      <div class="col-md-4 float-right">
                        <input class="form-control no-print" id="myInput" type="text" placeholder="Cari.."><br>
                      </div>
                      <table id="table" name="table" class="table table-responsive-sm">
                        <thead>
                          <tr>
                            <th>No</th>
                            <th>Kode Pesanan</th>
                            <th>Nama Konsumen</th>
                            <th>Total Tagihan Setelah PPN (Rp)</th>
                            <th>Status</th>
                            <th colspan="2" class="text-center">Action</th>
                          </tr>
                        </thead>
                        <tbody id="myTable">
                          @foreach($pembayaranH as $pembayaran)
                          <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $pembayaran->kode_pesanan }}</td>
                            <td>{{ $pembayaran->nama_lengkap }}</td>
                            <td>{{ number_format($pembayaran->total_tagihan_ppn) }}</td>
                            <td>{{ $pembayaran->status }}</td>
                            @if($pembayaran->status == 'Closed')
                            <td>
                              <a href="{{ url('/pembayaran/view/' . $pembayaran->id) }}" class="btn btn-block btn-primary">View</a>
                            </td>
                            @endif
                            @if($pembayaran->status == 'Billed')
                            <td>
                              <a href="{{ url('/pembayaran/edit/' . $pembayaran->id) }}" class="btn btn-block btn-primary">Bayar</a>
                            </td>
                            @endif
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                      {{ $pembayaranH->links() }}
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

@endsection

@push('javascript')
  <script type="text/javascript">
   function validateForm(){
        if (confirm("Yakin data akan dihapus?") == true) {
        return true;
        } else {
        return false;
        }
    }
    
    $("#myInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#myTable tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
</script>
@endpush