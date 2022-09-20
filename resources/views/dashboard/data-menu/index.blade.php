@extends('dashboard.base')

@section('content')

<div class="container-fluid">
            <div class="fade-in">
              <div class="row">
                <div class="col-lg-12">
                  <div class="card">
                    <div class="card-header"><i class="fa fa-align-justify"></i> DATA MENU</div>
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
                            <th>Foto</th>
                            <th>Nama Menu</th>
                            <th>Deskripsi</th>
                            <th>Harga</th>
                            <th colspan="2" class="text-center">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($dataMenu as $menu)
                          <tr>
                            <td>{{ $no++ }}</td>
                            <td><img src="{{asset('images/'.$menu->foto)}}" alt="" width="50px" height="50px"></td>
                            <td>{{ $menu->nama_menu }}</td>
                            <td>{{ $menu->deskripsi }}</td>
                            <td>{{ $menu->harga }}</td>
                            <td>
                              <a href="{{ url('/data-menu/' . $menu->id . '/edit') }}" class="btn btn-block btn-primary">Ubah</a>
                            </td>
                            <td>
                              <form action="{{ route('data-menu.destroy', $menu->id ) }}" method="POST">
                                  @method('DELETE')
                                  @csrf
                                  <button class="btn btn-block btn-danger">Hapus</button>
                              </form>
                            </td>
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                      {{ $dataMenu->links() }}
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

@endsection

@section('javascript')

@endsection