@extends('dashboard.base')

@section('content')

<div class="container-fluid">
            <div class="fade-in">
              <div class="row">
                <div class="col-lg-12">
                  <div class="card">
                    <div class="card-header"><i class="fa fa-align-justify"></i> DATA RESERVASI</div>
                    <div class="card-body">
                      <a href="{{ route('data-menu.create') }}" class="btn btn-primary btn-md">Tambah</a>
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
                            <th>Kode</th>
                            <th>Tanggal Reservasi</th>
                            <th>Untuk Tanggal</th>
                            <th>Jumlah Tamu</th>
                            <th colspan="2" class="text-center">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($reservasi as $reserv)
                          <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $reserv->kode_booking }}</td>
                            <td>{{ $reserv->tanggal_reservasi }}</td>
                            <td>{{ $reserv->untuk_tanggal }}</td>
                            <td>{{ $reserv->jumlah_tamu }}</td>
                            <td>
                              <a href="{{ url('/reservasi/' . $reserv->id . '/edit') }}" class="btn btn-block btn-primary">Ubah</a>
                            </td>
                            <td>
                              <form action="{{ route('reservasi.destroy', $reserv->id ) }}" method="POST">
                                  @method('DELETE')
                                  @csrf
                                  <button class="btn btn-block btn-danger">Hapus</button>
                              </form>
                            </td>
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                      {{ $reservasi->links() }}
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

@endsection

@section('javascript')

@endsection