@extends('dashboard.base')

@section('content')

        <div class="container-fluid">
          <div class="animated fadeIn">
            <div class="row">
              <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-header">
                      <i class="fa fa-align-justify"></i> Ubah Data Menu</div>
                    <div class="card-body m-3">
                        <form method="POST" action="/data-menu/{{ $dataMenu->id }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group row">
                              <label>Foto</label>
                              <div class="col-md-9">
                                <input id="file-input" type="file" name="foto" id="foto">
                              </div>
                            </div>
                            <div class="form-group row">
                                <label>Nama Menu</label>
                                <input class="form-control" type="text" placeholder="Input nama menu" id="nama_menu" name="nama_menu" required autofocus value="{{ $dataMenu->nama_menu }}">
                            </div>

                            <div class="form-group row">
                                <label>Deskripsi</label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="9" placeholder="Input Deskripsi" required>{{ $dataMenu->deskripsi }}</textarea>
                            </div>

                            <div class="form-group row">
                                <label>Harga</label>
                                <input type="number" class="form-control" placeholder="Input harga" name="harga" id="harga" required value="{{ $dataMenu->harga }}"/>
                            </div>

                            <div class="form-group row">
                              <button class="btn btn-md btn-success mr-3" type="submit">Simpan</button>
                              <a href="{{ route('data-menu.index') }}" class="btn btn-md btn-primary">Kembali</a> 
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