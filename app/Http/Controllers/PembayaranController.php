<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PesananHeader;
use App\Models\PesananDetail;
use App\Models\PembayaranHeader;
use App\Models\PembayaranDetail;
use App\Models\DataMenu;
use App\Models\Reservasi;
use App\Models\Konsumen;
use Auth;
use Carbon\Carbon;
use PDF;

class PembayaranController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        $role = Auth::user()->menuroles;
        $pembayaranH = [];
        if($role == 'user'){
            $dataKonsumen   = Konsumen::where('email', Auth::user()->email)->first();
            $pembayaranH    = PembayaranHeader::select('pembayaran_header.kode_pesanan', 'data_konsumen.nama_lengkap', 'pembayaran_header.total_tagihan_ppn', 'pembayaran_header.status', 'pembayaran_header.id')
            ->join('data_konsumen', 'data_konsumen.id', 'pembayaran_header.id_konsumen')
            ->where('pembayaran_header.id_konsumen', $dataKonsumen->id)
            ->orderBy('pembayaran_header.created_at', 'asc')
            ->paginate(10);
        }
        if($role == 'admin'){
            $pembayaranH    = PembayaranHeader::select('pembayaran_header.kode_pesanan', 'data_konsumen.nama_lengkap', 'pembayaran_header.total_tagihan_ppn', 'pembayaran_header.status', 'pembayaran_header.id')
            ->join('data_konsumen', 'data_konsumen.id', 'pembayaran_header.id_konsumen')
            ->orderBy('pembayaran_header.created_at', 'asc')
            ->paginate(10);
        }
        $no             = 1;
        return view('dashboard.pembayaran.index', [ 'pembayaranH' => $pembayaranH , 'no' => $no]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $no = 1;
        $pembayaranHeader  = PembayaranHeader::select('pembayaran_header.kode_pesanan', 'data_konsumen.nama_lengkap', 'pembayaran_header.id_konsumen', 'pembayaran_header.total_tagihan_ppn', 'pembayaran_header.total_tagihan', 'pembayaran_header.status', 'pembayaran_header.id')
            ->join('data_konsumen', 'data_konsumen.id', 'pembayaran_header.id_konsumen')
            ->where('pembayaran_header.id', $id)
            ->first();
        $pembayaranDetail  = PembayaranDetail::select('data_menu.nama_menu', 'data_menu.harga', 'pembayaran_detail.jumlah_pesanan', 'pembayaran_detail.total_harga', 'pembayaran_detail.id')
            ->join('data_menu', 'data_menu.id', 'pembayaran_detail.id_menu')
            ->where('pembayaran_detail.kode_pesanan', $pembayaranHeader->kode_pesanan)
            ->get();
        return view('dashboard.pembayaran.edit', ['no'=>$no, 'pembayaranHeader'=> $pembayaranHeader, 'pembayaranDetail'=>$pembayaranDetail]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $updatePembayaranHeader = PembayaranHeader::find($id);
        $updatePembayaranHeader->tanggal_pembayaran = $request->tanggal_pembayaran;
        $updatePembayaranHeader->jumlah_pembayaran  = $request->jumlah_pembayaran;
        $updatePembayaranHeader->metode_pembayaran  = $request->metode_pembayaran;
        $updatePembayaranHeader->catatan            = $request->catatan;
        $updatePembayaranHeader->status             = 'Closed';
        $updatePembayaranHeader->save();

        $pemesananHeader = PesananHeader::where('kode_pesanan',  $updatePembayaranHeader->kode_pesanan)->first();

        $updatePemesananHeader = PesananHeader::find($pemesananHeader->id);
        $updatePemesananHeader->status  = 'Closed';
        $updatePemesananHeader->save();

        if($pemesananHeader->tipe_pesanan == 'Dine In'){
            $reservasi = Reservasi::where('id', $pemesananHeader->id_reservasi)->first();
            $updateReservasi = Reservasi::find($reservasi->id);
            $updateReservasi->status  = 'Closed';
            $updateReservasi->save();
        }

        return redirect('/pembayaran')->with('message', 'Data Pembayaran berhasil dibuat!');
    }

    public function view($id){
        $no = 1;
        $pembayaranHeader  = PembayaranHeader::select('pembayaran_header.kode_pesanan', 'data_konsumen.nama_lengkap', 'pembayaran_header.id_konsumen', 'pembayaran_header.total_tagihan_ppn', 'pembayaran_header.total_tagihan', 'pembayaran_header.status', 'pembayaran_header.id', 'pembayaran_header.jumlah_pembayaran', 'pembayaran_header.metode_pembayaran', 'pembayaran_header.catatan')
            ->join('data_konsumen', 'data_konsumen.id', 'pembayaran_header.id_konsumen')
            ->where('pembayaran_header.id', $id)
            ->first();
        $pembayaranDetail  = PembayaranDetail::select('data_menu.nama_menu', 'data_menu.harga', 'pembayaran_detail.jumlah_pesanan', 'pembayaran_detail.total_harga', 'pembayaran_detail.id')
            ->join('data_menu', 'data_menu.id', 'pembayaran_detail.id_menu')
            ->where('pembayaran_detail.kode_pesanan', $pembayaranHeader->kode_pesanan)
            ->get();
        return view('dashboard.pembayaran.view', ['no'=>$no, 'pembayaranHeader'=> $pembayaranHeader, 'pembayaranDetail'=>$pembayaranDetail]);
    }

    public function bill($id){
        $no = 1;
        $pembayaranHeader  = PembayaranHeader::select('pembayaran_header.tanggal_pembayaran', 'pembayaran_header.kode_pesanan', 'data_konsumen.nama_lengkap', 'pembayaran_header.id_konsumen', 'pembayaran_header.total_tagihan_ppn', 'pembayaran_header.total_tagihan', 'pembayaran_header.status', 'pembayaran_header.id', 'pembayaran_header.jumlah_pembayaran', 'pembayaran_header.metode_pembayaran', 'pembayaran_header.catatan')
            ->join('data_konsumen', 'data_konsumen.id', 'pembayaran_header.id_konsumen')
            ->where('pembayaran_header.id', $id)
            ->first();
        $pembayaranDetail  = PembayaranDetail::select('data_menu.nama_menu', 'data_menu.harga', 'pembayaran_detail.jumlah_pesanan', 'pembayaran_detail.total_harga', 'pembayaran_detail.id')
            ->join('data_menu', 'data_menu.id', 'pembayaran_detail.id_menu')
            ->where('pembayaran_detail.kode_pesanan', $pembayaranHeader->kode_pesanan)
            ->get();

    	$pdf = PDF::loadview('dashboard.pembayaran.bill',[
            'no' => $no, 
            'pembayaranHeader' => $pembayaranHeader,
            'pembayaranDetail' => $pembayaranDetail
        ])->setPaper('b6', 'potrait');
    	return $pdf->stream('Bill'.$pembayaranHeader->kode_pesanan.'.pdf');
    }

    public function kwintansi($id){
        $no = 1;
        $pembayaranHeader  = PembayaranHeader::select('pembayaran_header.catatan', 'pembayaran_header.metode_pembayaran', 'pembayaran_header.tanggal_pembayaran', 'pembayaran_header.kode_pesanan', 'data_konsumen.nama_lengkap', 'pembayaran_header.id_konsumen', 'pembayaran_header.total_tagihan_ppn', 'pembayaran_header.total_tagihan', 'pembayaran_header.status', 'pembayaran_header.id', 'pembayaran_header.jumlah_pembayaran', 'pembayaran_header.metode_pembayaran', 'pembayaran_header.catatan')
            ->join('data_konsumen', 'data_konsumen.id', 'pembayaran_header.id_konsumen')
            ->where('pembayaran_header.id', $id)
            ->first();
        $pembayaranDetail  = PembayaranDetail::select('data_menu.nama_menu', 'data_menu.harga', 'pembayaran_detail.jumlah_pesanan', 'pembayaran_detail.total_harga', 'pembayaran_detail.id')
            ->join('data_menu', 'data_menu.id', 'pembayaran_detail.id_menu')
            ->where('pembayaran_detail.kode_pesanan', $pembayaranHeader->kode_pesanan)
            ->get();

    	$pdf = PDF::loadview('dashboard.pembayaran.kwintansi',[
            'no' => $no, 
            'pembayaranHeader' => $pembayaranHeader,
            'pembayaranDetail' => $pembayaranDetail
        ])->setPaper('b6', 'potrait');
    	return $pdf->stream('Kwintansi'.$pembayaranHeader->kode_pesanan.'.pdf');
    }
    
}
