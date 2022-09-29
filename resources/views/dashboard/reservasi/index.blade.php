@extends('dashboard.base')

@section('content')

<div class="container-fluid">
            <div class="fade-in">
              <div class="row">
                <div class="col-lg-12">
                  <div class="card">
                    <div class="card-header"><i class="fa fa-align-justify"></i> DATA RESERVASI</div>
                    <div class="card-body">
                      <a href="{{ route('reservasi.create') }}" class="btn btn-primary btn-md">Tambah</a>
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
                            <th>Nama Konsumen</th>
                            <th>Untuk Tanggal</th>
                            <th>Jumlah Tamu</th>
                            <th>Status</th>
                            <th colspan="2" class="text-center">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($reservasi as $reserv)
                          <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $reserv->kode_booking }}</td>
                            <td>{{ $reserv->tanggal_reservasi }}</td>
                            <td>{{ $reserv->nama_lengkap }}</td>
                            <td>{{ $reserv->untuk_tanggal }}</td>
                            <td>{{ $reserv->jumlah_tamu }}</td>
                            <td>{{ $reserv->status }}</td>
                            <td>
                              <button class="btn btn-block btn-primary" type="button" data-toggle="modal" data-target="#primaryModal">Barcode</button>
                              <!-- /.modal-->
                              <div class="modal fade" id="primaryModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-sm modal-primary" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h4 class="modal-title">View Barcode</h4>
                                      <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    </div>
                                    <div class="modal-body">
                                    <span style="text-align:center;">{!! DNS2D::getBarcodeHTML($reserv->kode_booking, 'QRCODE') !!}</span>
                                    </div>
                                    <div class="modal-footer">
                                      <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                                    </div>
                                  </div>
                                  <!-- /.modal-content-->
                                </div>
                                <!-- /.modal-dialog-->
                              </div>
                              <!-- /.modal-->
                            </td>
                            @if($reserv->status != 'Cancel')
                            <td>
                            <form method="POST" action="/reservasi/{{ $reserv->id }}" enctype="multipart/form-data">
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