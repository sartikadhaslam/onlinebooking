@extends('dashboard.base')

@section('content')

        <div class="container-fluid">
          <div class="animated fadeIn">
            <div class="row">
              <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-header">
                      <i class="fa fa-align-justify"></i> Tambah Data Menu</div>
                    <div class="card-body m-3">
                        <form method="POST" action="{{ route('reservasi.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <label>Tanggal Reservasi</label>
                                <input class="form-control" type="date" id="tanggal_reservasi" name="tanggal_reservasi" readonly value="<?php echo date('Y-m-d'); ?>">
                            </div>
                            <div class="form-group row">
                                <label>Untuk Tanggal</label>
                                <input class="form-control" type="date" id="untuk_tanggal" name="untuk_tanggal" required>
                            </div>
                            <div class="form-group row">
                                <label>Jumlah Tamu</label>
                                <input class="form-control" type="text" id="jumlah_tamu" name="jumlah_tamu" required>
                            </div>
                            <div class="form-group row">
                              <button class="btn btn-md-m btn-success mr-3" type="submit">Simpan</button>
                              <a href="{{ route('reservasi.index') }}" class="btn btn-md btn-primary">Kembali</a> 
                            </div>
                        </form>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>

@endsection

@section('javascript')

@endsection