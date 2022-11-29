@extends('dashboard.base')

@section('content')
<style>
    @media print
    {    
        .no-print, .no-print *
        {
            display: none !important;
        }
    }
</style>
<div class="container-fluid">
            <div class="fade-in">
              <div class="row">
                <div class="col-lg-12">
                  <div class="card">
                    <div class="card-header"><i class="fa fa-align-justify"></i> LAPORAN TREN MENU FAVORIT 
                    @if(count($data) > 0)
                        {{ $tanggal_awal }} s/d {{ $tanggal_akhir }}
                    @endif
                    </div>
                    <div class="card-body">
                        <div class="no-print">
                            <form class="form-inline" action="" method="get">
                                <label for="tanggal_awal" class="mr-sm-2">Tanggal Akhir:</label>
                                <input type="date" class="form-control mb-2 mr-sm-2" id="tanggal_awal" name="tanggal_awal">
                                <label for="tanggal_akhir" class="mr-sm-2">Tanggal Awal:</label>
                                <input type="date" class="form-control mb-2 mr-sm-2" id="tanggal_akhir" name="tanggal_akhir">
                                <button type="submit" class="btn btn-primary mb-2">Submit</button>
                            </form>
                        <br>
                        @if(count($data) > 0)
                        <div class="col-md-6 no-print pl-0">
                            <button class="btn btn-danger ml-0" onclick="window.print()">
                                <i class="cil-print"></i> PRINT
                            </button>
                        </div>
                        <div class="col-md-4 float-right">
                            <input class="form-control no-print" id="myInput" type="text" placeholder="Cari.."><br>
                        </div>
                      </div>
                      <table id="table" name="table" class="table table-responsive-sm">
                        <thead>
                          <tr>
                            <th>No</th>
                            <th>Nama Menu</th>
                            <th>Total Pendapatan (Rp)</th>
                          </tr>
                        </thead>
                        <tbody id="myTable">
                            @foreach($data as $data)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $data->nama_menu }}</td>
                                <td>{{ number_format($data->total_harga)  }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                      </table>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <script type="text/javascript">
              $("#myInput").on("keyup", function() {
                  var value = $(this).val().toLowerCase();
                  $("#myTable tr").filter(function() {
                  $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                  });
              });
          </script>
@endsection

@section('javascript')

@endsection