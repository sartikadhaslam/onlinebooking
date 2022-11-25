@extends('dashboard.base')

@section('content')
<style>
.zoom {
  transition: transform .2s; /* Animation */
  margin: 0 auto;
}

.zoom:hover {
  transform: scale(3.0); /* (150% zoom - Note: if the zoom is too large, it will go outside of the viewport) */
}
</style>
        <div class="container-fluid">
          <div class="animated fadeIn">
            <div class="row">
              <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-header">
                      <i class="fa fa-align-justify"></i> Tambah Data Pesanan</div>
                    <div class="card-body m-3">
                        <button id="menu" class="btn btn-primary mb-3" type="button" data-toggle="modal" data-target="#primaryModal">+ Menu</button>
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
                              <th>Foto Menu</th>
                              <th>Nama Menu</th>
                              <th>Harga</th>
                              <th>Jumlah Pesanan</th>
                              <th>Total Harga</th>
                              <th colspan="2" class="text-center">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($pesananDetail as $pesananDetail)
                            <tr>
                              <td>{{ $no++ }}</td>
                              <td><div class="zoom"><img src="{{asset('images/'.$pesananDetail->foto)}}" alt="" width="50px" height="50px"></div></td>
                              <td>{{ $pesananDetail->nama_menu }}</td>
                              <td>{{ number_format($pesananDetail->harga) }}</td>
                              <td>{{ $pesananDetail->jumlah_pesanan }}</td>
                              <td>{{ number_format($pesananDetail->total_harga) }}</td>
                              <td class="text-center">
                              <form method="POST" action="{{ url('/pesanan/delete_detail/'.$pesananDetail->id) }}" onsubmit="return validateForm()">
                                  @csrf
                                  @method('DELETE')
                                  <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                              </form>
                              </td>
                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                        <button id="checkout" class="btn btn-success" onclick="checkoutFunction()">Checkout</button>
                        <div id="header" style="display:none;">
                          <button id="uncheckout" class="btn btn-success" onclick="ubahFunction()">Ubah Menu</button>
                          <div class="m-3">
                            <form method="POST" action="{{ url('/pesanan/update/'.$pesananHeader->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group row">
                                    <label>Kode Pesanan (AUTO)</label>
                                    <input class="form-control" type="text" id="kode_pesanan" name="kode_pesanan" value="{{ $pesananHeader->kode_pesanan }}" readonly>
                                </div>

                                <div class="form-group row">
                                    <label>Tanggal Pesanan (AUTO)</label>
                                    <input class="form-control" type="date" id="tanggal_pesanan" name="tanggal_pesanan" value="{{ $pesananHeader->tanggal_pesanan }}"  readonly>
                                </div>

                                <div class="form-group row">
                                    <label>Tipe Pesanan</label>
                                    <select name="tipe_pesanan" id="tipe_pesanan" class="form-control" required>
                                      <option>--Pilih Tipe--</option>
                                      <option value="Dine In" <?php if($pesananHeader->tipe_pesanan == 'Dine In'){echo 'selected';}?>>Dine In</option>
                                      <option value="Take Away" <?php if($pesananHeader->tipe_pesanan == 'Take Away'){echo 'selected';}?>>Take Away</option>
                                      <option value="Delivery" <?php if($pesananHeader->tipe_pesanan == 'Delivery'){echo 'selected';}?>>Delivery</option>
                                    </select>
                                </div>

                                <div id="dine_in" style="display:none;">
                                  <div class="form-group row">
                                      <label>ID Reservasi</label>
                                      <select name="id_reservasi" id="id_reservasi" class="form-control">
                                        <option>--Pilih Data Reservasi--</option>
                                        @foreach($dataReservasi as $dataReservasi)
                                        <option value="{{ $dataReservasi->id }}" <?php if($pesananHeader->id_reservasi == $dataReservasi->id){echo 'selected';}?>>{{ $dataReservasi->kode_booking }} - {{ $dataReservasi->tanggal_reservasi }} - {{ $dataReservasi->jumlah_tamu }} orang</option>
                                        @endforeach
                                      </select>
                                  </div>
                                </div>

                                <div id="delivery" style="display:none;">
                                  <div class="form-group row">
                                      <label>Nama Penerima</label>
                                      <input class="form-control" type="text" id="nama_penerima" name="nama_penerima" placeholder="Masukkan nama penerima" value="{{ $pesananHeader->nama_penerima }}">
                                  </div>

                                  <div class="form-group row">
                                      <label>No HP Penerima</label>
                                      <input class="form-control" type="text" id="no_hp_penerima" name="no_hp_penerima" placeholder="Masukkan no hp penerima" value="{{ $pesananHeader->no_hp_penerima }}">
                                  </div>

                                  <div class="form-group row">
                                      <label>Alamat Penerima</label>
                                      <textarea class="form-control" type="text" id="alamat_penerima" name="alamat_penerima" placeholder="Masukkan alamat penerima" value="{{ $pesananHeader->alamat_penerima }}"></textarea>
                                  </div>
                                </div>
                                <div class="form-group row">
                                    <label>Catatan</label>
                                    <textarea class="form-control" type="text" id="catatan" name="catatan" placeholder="Masukkan catatan">{{ $pesananHeader->catatan }}</textarea>
                                </div>

                                <div class="form-group row">
                                    <label>Total (AUTO)</label>
                                    <input class="form-control" type="text" id="total" name="total" readonly value="{{ $pesananHeader->total }}">
                                </div>

                                <div class="form-group row">
                                  <button class="btn btn-md btn-success mr-3" type="submit">Pesan</button>
                                </div>
                            </form>
                          </div>
                        </div>
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
              <form method="POST" action="{{ url('/pesanan/store_detail') }}" enctype="multipart/form-data">
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

    function validateForm(){
        if (confirm("Yakin data akan dihapus?") == true) {
        return true;
        } else {
        return false;
        }
    }
  </script>
@endpush