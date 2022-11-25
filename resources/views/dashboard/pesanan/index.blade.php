@extends('dashboard.base')

@section('content')

<div class="container-fluid">
            <div class="fade-in">
              <div class="row">
                <div class="col-lg-12">
                  <div class="card">
                    <div class="card-header"><i class="fa fa-align-justify"></i> PESANAN</div>
                    <div class="card-body">
                      <a href="{{ url('/pesanan/create') }}" class="btn btn-primary btn-md">+ Tambah</a>
                      <br>
                      <br>
                      @if(Session::has('message'))
                          <div class="alert alert-success" role="alert">{{ Session::get('message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                      @endif
                      <table id="table" name="table" class="table table-responsive-sm">
                        <thead>
                          <tr>
                            <th>No</th>
                            <th>Kode Pesanan</th>
                            <th>Tanggal Pesanan</th>
                            <th>Nama Konsumen</th>
                            <th>Tipe Pesanan</th>
                            <th>Total Harga (Rp)</th>
                            <th>Status</th>
                            <th colspan="2" class="text-center">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($pesananH as $pesanan)
                          <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $pesanan->kode_pesanan }}</td>
                            <td>{{ $pesanan->tanggal_pesanan }}</td>
                            <td>{{ $pesanan->nama_lengkap }}</td>
                            <td>{{ $pesanan->tipe_pesanan }}</td>
                            <td>{{ number_format($pesanan->total) }}</td>
                            <td>{{ $pesanan->status }}</td>
                            @if($pesanan->status == 'Ordered' || $pesanan->status == 'Closed')
                            <td>
                              <a href="{{ url('/pesanan/view/' . $pesanan->id) }}" class="btn btn-block btn-primary">View</a>
                            </td>
                            @endif
                            @if($pesanan->status == 'Draft')
                            <td>
                              <form action="{{ url('/pesanan/delete/' . $pesanan->id) }}" method="POST" onsubmit="return validateForm()">
                                  @method('DELETE')
                                  @csrf
                                  <button class="btn btn-block btn-danger">Hapus</button>
                              </form>
                            </td>
                            @endif
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                      {{ $pesananH->links() }}
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
  </script>
@endpush