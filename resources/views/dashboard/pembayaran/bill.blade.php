<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bill</title>
</head>
<body>
<hr>
<h3 style="text-align:center">PONDOK KEMANGI PLUIT <br>RECEIPT</h3>
<hr>
<table width="100%">
  <tr>
    <td style="text-align:left;">{{$pembayaranHeader->tanggal_pembayaran}}</td>
    <td style="text-align:right;">#{{$pembayaranHeader->kode_pesanan}}</td>
  </tr>
</table>
<br>
<table width="100%">
  <tr>
    <th style="text-align:left;">Pesanan</th>
    <th style="text-align:right;">Total</th>
  </tr>
  @foreach($pembayaranDetail as $pembayaranDetail)
  <tr>
    <td style="text-align:left;">{{$pembayaranDetail->jumlah_pesanan}} x {{$pembayaranDetail->nama_menu}}</td>
    <td style="text-align:right;">{{ number_format($pembayaranDetail->total_harga) }}</td>
  </tr>
  @endforeach
</table>
<br>
<hr>
<table width="100%">
  <tr>
    <th style="text-align:left;">Total</th>
    <td style="text-align:right;">{{ number_format($pembayaranHeader->total_tagihan) }}</td>
  </tr>
  <tr>
    <th style="text-align:left;">PPN</th>
    <td style="text-align:right;">{{ number_format(10/100*$pembayaranHeader->total_tagihan) }}</td>
  </tr>
  <tr>
    <th style="text-align:left;">Total Setelah PPN</th>
    <td style="text-align:right;">{{ number_format($pembayaranHeader->total_tagihan_ppn)  }}</td>
  </tr>
</table>
</body>
</html>
