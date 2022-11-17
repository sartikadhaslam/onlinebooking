@extends('dashboard.base')

@section('content')

<div class="container-fluid">
            <div class="fade-in">
              <div class="row">
                <div class="col-lg-12">
                  <div class="card">
                    <div class="card-header"><i class="fa fa-align-justify"></i> PESANAN</div>
                    <div class="card-body">
                      <a href="{{ route('pesanan.create') }}" class="btn btn-primary btn-md">Tambah</a>
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
                            <th>Total Harga</th>
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
                            <td>{{ $pesanan->id_konsumen }}</td>
                            <td>{{ $pesanan->tipe_pesanan }}</td>
                            <td>{{ $pesanan->jumlah_tamu }}</td>
                            <td>{{ $pesanan->status }}</td>
                            @if($reserv->status != 'Cancel')
                            <td>
                            <form method="POST" action="/pesanan/{{ $pesanan->id }}" enctype="multipart/form-data">
                              @csrf
                              @method('PUT')
                              <button type="submit" class="btn btn-block btn-danger">Cancel</button>
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

@section('javascript')

@endsection