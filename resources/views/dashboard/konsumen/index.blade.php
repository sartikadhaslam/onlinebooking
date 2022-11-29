@extends('dashboard.base')

@section('content')

<div class="container-fluid">
            <div class="fade-in">
              <div class="row">
                <div class="col-lg-12">
                  <div class="card">
                    <div class="card-header"><i class="fa fa-align-justify"></i> DATA KONSUMEN</div>
                    <div class="card-body">
                    <div class="col-md-4 float-right">
                        <input class="form-control no-print" id="myInput" type="text" placeholder="Cari.."><br>
                    </div>
                    <table id="table" name="table" class="table table-responsive-sm">
                        <thead>
                          <tr>
                            <th>No</th>
                            <th>Nama Lengkap</th>
                            <th>Nomor Telepon</th>
                            <th>Nomor KTP</th>
                            <th>Alamat Domisili</th>
                            <th>Email</th>
                          </tr>
                        </thead>
                        <tbody id="myTable">
                          @foreach($dataKonsumen as $konsumen)
                          <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $konsumen->nama_lengkap}}</td>
                            <td>{{ $konsumen->nomor_telepon }}</td>
                            <td>{{ $konsumen->no_ktp }}</td>
                            <td>{{ $konsumen->alamat_domisili }}</td>
                            <td>{{ $konsumen->email }}</td>
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                      {{ $dataKonsumen->links() }}
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