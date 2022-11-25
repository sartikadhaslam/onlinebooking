@extends('dashboard.base')

@section('content')
        <div class="container-fluid">
          <div class="animated fadeIn">
            <div class="row">
              <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-header">
                      <i class="fa fa-align-justify"></i> Data Pembayaran
                    </div>
                    <div class="card-body m-3">
                    <div id="header">
                          <div class="m-3">
                                <div class="form-group row">
                                    <label>Kode Pesanan (AUTO)</label>
                                    <input class="form-control" type="text" id="kode_pesanan" name="kode_pesanan" value="{{ $pembayaranHeader->kode_pesanan }}" readonly>
                                </div>

                                <div class="form-group row">
                                    <label>Tanggal Pembayaran (AUTO)</label>
                                    <input class="form-control" type="date" id="tanggal_pembayaran" name="tanggal_pembayaran" value="<?php echo date('Y-m-d'); ?>"  readonly>
                                </div>

                                <div class="form-group row">
                                    <label>Konsumen</label>
                                    <input class="form-control" type="hidden" id="id_konsumen" name="id_konsumen" value="{{ $pembayaranHeader->id_konsumen }}" readonly>
                                    <input class="form-control" type="text" id="nama_lengkap" name="nama_lengkap" value="{{ $pembayaranHeader->nama_lengkap }}" readonly>
                                </div>
                       
                                <div class="form-group row">
                                    <label>Metode Pembayaran</label>
                                    <select name="metode_pembayaran" id="metode_pembayaran"  class="form-control" disabled>
                                      <option>--Pilih Metode Pembayaran--</option>
                                      <option value="Cash" <?php if($pembayaranHeader->metode_pembayaran == 'Cash'){echo 'selected';}?>>Cash</option>
                                      <option value="Bank Transfer" <?php if($pembayaranHeader->metode_pembayaran == 'Bank Transfer'){echo 'selected';}?>>Bank Transfer</option>
                                    </select>
                                </div>

                                <div class="form-group row">
                                    <label>Jumlah Pembayaran</label>
                                    <input type="text" class="form-control" id="jumlah_pembayaran" name="jumlah_pembayaran" value="{{ $pembayaranHeader->jumlah_pembayaran }}" readonly></input>
                                </div>

                                <div class="form-group row">
                                    <label>Catatan</label>
                                    <textarea class="form-control" type="text" id="catatan" name="catatan" readonly>{{ $pembayaranHeader->catatan }}</textarea>
                                </div>

                                <div class="form-group row">
                                    <label>Status (AUTO)</label>
                                    <input class="form-control" type="text" id="status" name="status" value="{{ $pembayaranHeader->status }}" readonly>
                                </div>
                          </div>
                        </div>
                        <br>
                        <h5 class="text-center">Detail Pesanan</h5>
                        <br>
                        <table id="table" name="table" class="table table-responsive-sm">
                          <thead>
                            <tr>
                              <th>No</th>
                              <th>Nama Menu</th>
                              <th>Harga</th>
                              <th>Jumlah Pesanan</th>
                              <th class="text-right">Total Harga</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($pembayaranDetail as $pembayaranDetail)
                            <tr>
                              <td>{{ $no++ }}</td>
                              <td>{{ $pembayaranDetail->nama_menu }}</td>
                              <td>{{ number_format($pembayaranDetail->harga) }}</td>
                              <td>{{ $pembayaranDetail->jumlah_pesanan }}</td>
                              <td class="text-right">{{ number_format($pembayaranDetail->total_harga) }}</td>
                            </tr>
                            @endforeach
                            <tr>
                              <td colspan="4" class="text-right"><strong>Total Tagihan</strong></td>
                              <td class="text-right"><strong>{{ number_format($pembayaranHeader->total_tagihan) }}</strong></td>
                            </tr>
                            <tr>
                              <td colspan="4" class="text-right"><strong>PPN 10%</strong></td>
                              <td class="text-right"><strong>{{ number_format($pembayaranHeader->total_tagihan*10/100) }}</strong></td>
                            </tr>
                            <tr>
                              <td colspan="4" class="text-right"><strong>Total Tagihan Setelah PPN</strong></td>
                              <td class="text-right"><strong>{{ number_format($pembayaranHeader->total_tagihan_ppn) }}</strong></td>
                            </tr>
                          </tbody>
                        </table>
                        @if($pembayaranHeader->status == 'Billed')
                        <a href="{{ url('/pembayaran/bill/'. $pembayaranHeader->id ) }}" class="btn btn-danger btn-md"  target="_blank"> <i class="cil-print"></i> Bill</a>
                        @endif
                        @if($pembayaranHeader->status == 'Closed')
                        <a href="{{ url('/pembayaran/kwintansi/'. $pembayaranHeader->id) }}" class="btn btn-danger btn-md"  target="_blank"><i class="cil-print"></i> Kwintansi</a>
                        @endif
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
@endsection