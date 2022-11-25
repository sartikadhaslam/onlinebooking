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
                      <i class="fa fa-align-justify"></i> View Data Pesanan</div>
                    <div class="card-body m-3">
                        <table id="table" name="table" class="table table-responsive-sm">
                          <thead>
                            <tr>
                              <th>No</th>
                              <th>Foto Menu</th>
                              <th>Nama Menu</th>
                              <th>Harga</th>
                              <th>Jumlah Pesanan</th>
                              <th>Total Harga</th>
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
                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                        <div id="header">
                          <div class="m-3">
                                @csrf
                                @method('PUT')
                                <div class="form-group row">
                                    <label>Kode Pesanan</label>
                                    <input class="form-control" type="text" id="kode_pesanan" name="kode_pesanan" value="{{ $pesananHeader->kode_pesanan }}" readonly>
                                </div>

                                <div class="form-group row">
                                    <label>Tanggal Pesanan</label>
                                    <input class="form-control" type="date" id="tanggal_pesanan" name="tanggal_pesanan" value="{{ $pesananHeader->tanggal_pesanan }}"  readonly>
                                </div>

                                <div class="form-group row">
                                    <label>Tipe Pesanan</label>
                                    <select name="tipe_pesanan" id="tipe_pesanan" class="form-control" required disabled>
                                      <option>--Pilih Tipe--</option>
                                      <option value="Dine In" <?php if($pesananHeader->tipe_pesanan == 'Dine In'){echo 'selected';}?>>Dine In</option>
                                      <option value="Take Away" <?php if($pesananHeader->tipe_pesanan == 'Take Away'){echo 'selected';}?>>Take Away</option>
                                      <option value="Delivery" <?php if($pesananHeader->tipe_pesanan == 'Delivery'){echo 'selected';}?>>Delivery</option>
                                    </select>
                                </div>
                                @if($pesananHeader->tipe_pesanan == 'Dine In')
                                <div id="dine_in">
                                  <div class="form-group row">
                                      <label>ID Reservasi</label>
                                      <select name="id_reservasi" id="id_reservasi" class="form-control" disabled>
                                        <option>--Pilih Data Reservasi--</option>
                                        @foreach($dataReservasi as $dataReservasi)
                                        <option value="{{ $dataReservasi->id }}" <?php if($pesananHeader->id_reservasi == $dataReservasi->id){echo 'selected';}?>>{{ $dataReservasi->kode_booking }} - {{ $dataReservasi->tanggal_reservasi }} - {{ $dataReservasi->jumlah_tamu }} orang</option>
                                        @endforeach
                                      </select>
                                  </div>
                                </div>
                                @endif
                                @if($pesananHeader->tipe_pesanan == 'Delivery')
                                <div id="delivery">
                                  <div class="form-group row">
                                      <label>Nama Penerima</label>
                                      <input class="form-control" type="text" id="nama_penerima" name="nama_penerima" placeholder="Masukkan nama penerima" value="{{ $pesananHeader->nama_penerima }}" readonly>
                                  </div>

                                  <div class="form-group row">
                                      <label>No HP Penerima</label>
                                      <input class="form-control" type="text" id="no_hp_penerima" name="no_hp_penerima" placeholder="Masukkan no hp penerima" value="{{ $pesananHeader->no_hp_penerima }}" readonly>
                                  </div>

                                  <div class="form-group row">
                                      <label>Alamat Penerima</label>
                                      <textarea class="form-control" type="text" id="alamat_penerima" name="alamat_penerima" placeholder="Masukkan alamat penerima" value="{{ $pesananHeader->alamat_penerima }}" readonly></textarea>
                                  </div>
                                </div>
                                @endif
                                <div class="form-group row">
                                    <label>Catatan</label>
                                    <textarea class="form-control" type="text" id="catatan" name="catatan" placeholder="Masukkan catatan" readonly>{{ $pesananHeader->catatan }}</textarea>
                                </div>

                                <div class="form-group row">
                                    <label>Total</label>
                                    <input class="form-control" type="text" id="total" name="total" readonly value="{{ $pesananHeader->total }}">
                                </div>

                                <div class="form-group row">
                                    <label>Status</label>
                                    <input class="form-control" type="text" id="status" name="status" readonly value="{{ $pesananHeader->status }}">
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
@endsection
