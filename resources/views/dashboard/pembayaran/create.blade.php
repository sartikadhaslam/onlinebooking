@extends('dashboard.base')

@section('content')

        <div class="container-fluid">
          <div class="animated fadeIn">
            <div class="row">
              <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-header">
                      <i class="fa fa-align-justify"></i> Tambah Data Pesanan</div>
                    <div class="card-body m-3">
                        <button id="menu" class="btn btn-primary mb-3" type="button" data-toggle="modal" data-target="#primaryModal">+ Menu</button>
                        <table id="table" name="table" class="table table-responsive-sm">
                          <thead>
                            <tr>
                              <th>No</th>
                              <th>Foto Menu</th>
                              <th>Nama Menu</th>
                              <th>Harga</th>
                              <th>Jumlah Pesanan</th>
                              <th>Total Harga</th>
                              <th colspan="2" class="text-center">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                            </tr>
                          </tbody>
                        </table>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /.modal-->
        <div class="modal fade" id="primaryModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-primary modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Tambah Menu</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
              </div>
              <div class="modal-body m-3">
              <form method="POST" action="{{ url('/pesanan/store') }}" enctype="multipart/form-data">
                  @csrf
                  <div class="form-group row">
                      <label>Menu</label>
                      <input type="text" id="kode_pesanan" name="kode_pesanan" style="display:none;" value="{{ $kode_pesanan }}">
                      <select name="id_menu" id="id_menu" class="form-control">
                        <option>--Pilih Menu--</option>
                        @foreach($dataMenu as $menu)
                        <option value="{{ $menu->id }}"><img src="{{asset('images/'.$menu->foto)}}" alt="" width="50px"> {{ $menu->nama_menu }} - Rp {{ number_format($menu->harga) }}</option>
                        @endforeach
                      </select>
                  </div>
                  <div class="form-group row">
                      <label>Jumlah Pesanan</label>
                      <input class="form-control" type="number" id="jumlah_pesanan" name="jumlah_pesanan" required>
                  </div>
              </div>
              <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                <button class="btn btn-success" type="submit">Save</button>
              </div>
            </div>
            </form>
            <!-- /.modal-content-->
          </div>
          <!-- /.modal-dialog-->
        </div>
        <!-- /.modal-->

@endsection
@push('javascript')
  <script type="text/javascript">
    $(document).ready(function(){
        $("#tipe_pesanan").change(function(){
            if(document.getElementById('tipe_pesanan').value == "Dine In"){
              $('#dine_in').show();
              $('#delivery').hide();
            }
            if(document.getElementById('tipe_pesanan').value == "Take Away"){
              $('#dine_in').hide();
              $('#delivery').hide();
            }
            if(document.getElementById('tipe_pesanan').value == "Delivery"){
              $('#dine_in').hide();
              $('#delivery').show();
            }
        });      
    });
    
    function checkoutFunction() {
      $('#header').show();
      $('#checkout').hide();
      $('#menu').hide();
    } 
    
    function ubahFunction() {
      $('#header').hide();
      $('#checkout').show();
      $('#menu').show();
    } 
  </script>
@endpush