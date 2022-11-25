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

class PesananController extends Controller
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
        $pesananH = [];
        if($role == 'user'){
            $dataKonsumen   = Konsumen::where('email', Auth::user()->email)->first();
            $pesananH       = PesananHeader::select('pesanan_header.kode_pesanan', 'pesanan_header.tanggal_pesanan', 'data_konsumen.nama_lengkap', 'pesanan_header.tipe_pesanan', 'pesanan_header.total', 'pesanan_header.status', 'pesanan_header.id')
            ->join('data_konsumen', 'data_konsumen.id', 'pesanan_header.id_konsumen')
            ->where('pesanan_header.id_konsumen', $dataKonsumen->id)
            ->orderBy('pesanan_header.tanggal_pesanan', 'asc')
            ->paginate(10);
        }
        if($role == 'admin'){
            $pesananH       = PesananHeader::select('pesanan_header.kode_pesanan', 'pesanan_header.tanggal_pesanan', 'data_konsumen.nama_lengkap', 'pesanan_header.tipe_pesanan', 'pesanan_header.total', 'pesanan_header.status', 'pesanan_header.id')
            ->join('data_konsumen', 'data_konsumen.id', 'pesanan_header.id_konsumen')
            ->orderBy('pesanan_header.tanggal_pesanan', 'asc')
            ->paginate(10);
        }
        $no             = 1;
        return view('dashboard.pesanan.index', [ 'pesananH' => $pesananH , 'no' => $no]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dataKonsumen   = Konsumen::where('email', Auth::user()->email)->first();
        
        $tahun = date('Y');
        
        $bulan = date('m');

        $tanggal = date('d');

        $no = 1;

        $check = PesananHeader::whereDate('created_at', Carbon::today())->get();
        
        $max = count($check);

        if($max > 0){
            $kode_pesanan = 'OR' . $tahun . $bulan . $tanggal . sprintf("%04s", abs($max + 1));
        }else{
            $kode_pesanan = 'OR' . $tahun . $bulan . $tanggal . sprintf("%04s", $no);
        } 

        $dataReservasi  = Reservasi::where('status', 'Booked')->where('id_konsumen', $dataKonsumen->id)->get();
        $dataMenu       = DataMenu::all();
        return view('dashboard.pesanan.create', [ 'dataMenu' => $dataMenu, 'dataReservasi'=> $dataReservasi, 'kode_pesanan' => $kode_pesanan]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dataKonsumen   = Konsumen::where('email', Auth::user()->email)->first();
        
        $pesananHeader = new PesananHeader();
        $pesananHeader->tanggal_pesanan       = date("Y-m-d H:i:s");
        $pesananHeader->kode_pesanan          = $request->kode_pesanan;
        $pesananHeader->id_konsumen           = $dataKonsumen->id;
        $pesananHeader->status                = 'Draft';
        $pesananHeader->save();
        
        $dataMenu = DataMenu::where('id', $request->id_menu)->first();  

        $pesananDetail = new PesananDetail();
        $pesananDetail->kode_pesanan          = $request->kode_pesanan;
        $pesananDetail->id_menu               = $request->id_menu;
        $pesananDetail->harga                 = $dataMenu->harga;
        $pesananDetail->jumlah_pesanan        = $request->jumlah_pesanan;
        $pesananDetail->total_harga           = $dataMenu->harga * $request->jumlah_pesanan;
        $pesananDetail->save();

        $request->session()->flash('message', 'Successfully created');
        return redirect('/pesanan/edit/'. $request->kode_pesanan);
    }

    public function store_detail(Request $request)
    {
        $dataMenu = DataMenu::where('id', $request->id_menu)->first();  

        $pesananDetail = new PesananDetail();
        $pesananDetail->kode_pesanan          = $request->kode_pesanan;
        $pesananDetail->id_menu               = $request->id_menu;
        $pesananDetail->harga                 = $dataMenu->harga;
        $pesananDetail->jumlah_pesanan        = $request->jumlah_pesanan;
        $pesananDetail->total_harga           = $dataMenu->harga * $request->jumlah_pesanan;
        $pesananDetail->save();

        $request->session()->flash('message', 'Successfully created');
        return redirect('/pesanan/edit/'. $request->kode_pesanan);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    /*public function show($id)
    {
        $note = Notes::with('user')->with('status')->find($id);
        return view('dashboard.data-menu.noteShow', [ 'note' => $note ]);
    }*/

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($kode)
    {
        $no = 1;
        $dataKonsumen   = Konsumen::where('email', Auth::user()->email)->first();
        $dataReservasi  = Reservasi::where('status', 'Booked')->where('id_konsumen', $dataKonsumen->id)->get();
        $dataMenu       = DataMenu::all();   
        $pesananHeader  = PesananHeader::where('kode_pesanan', $kode)->first();
        $pesananDetail  = PesananDetail::select('data_menu.foto', 'data_menu.nama_menu', 'data_menu.harga', 'pesanan_detail.jumlah_pesanan', 'pesanan_detail.total_harga', 'pesanan_detail.id')
            ->join('data_menu', 'data_menu.id', 'pesanan_detail.id_menu')
            ->where('pesanan_detail.kode_pesanan', $kode)
            ->get();
        return view('dashboard.pesanan.edit', [ 'dataReservasi' => $dataReservasi, 'no'=>$no, 'dataMenu' => $dataMenu, 'pesananHeader'=> $pesananHeader, 'pesananDetail'=>$pesananDetail, 'kode_pesanan' => $kode]);
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
        $pesananHeader = PesananHeader::where('id', $id)->first();
        $pesananDetail = PesananDetail::where('kode_pesanan', $pesananHeader->kode_pesanan)->get();
        $total = $pesananDetail->sum('total_harga');

        $updatePesananHeader = PesananHeader::find($id);
        $updatePesananHeader->tipe_pesanan      = $request->tipe_pesanan;

        if($request->tipe_pesanan != 'Dine In'){
            $updatePesananHeader->id_reservasi      = null;
        }else{
            $updatePesananHeader->id_reservasi      = $request->id_reservasi;
            $updateReservasi = Reservasi::find($request->id_reservasi);
            $updateReservasi->status            = 'Ordered';
            $updateReservasi->save();
        }
        $updatePesananHeader->nama_penerima     = $request->nama_penerima;
        $updatePesananHeader->no_hp_penerima    = $request->no_hp_penerima;
        $updatePesananHeader->alamat_penerima   = $request->alamat_penerima;
        $updatePesananHeader->catatan           = $request->catatan;
        $updatePesananHeader->total             = $total;
        $updatePesananHeader->status            = 'Ordered';
        $updatePesananHeader->save();
        
        $pembayaranHeader = new PembayaranHeader();
        $pembayaranHeader->kode_pesanan       = $pesananHeader->kode_pesanan;
        $pembayaranHeader->id_konsumen        = $pesananHeader->id_konsumen;
        $pembayaranHeader->total_tagihan      = $total;
        $pembayaranHeader->total_tagihan_ppn  = $total + (10/100 * $total);
        $pembayaranHeader->status             = 'Billed';
        $pembayaranHeader->save();

        foreach($pesananDetail as $detail){
            $pembayaranDetail = new PembayaranDetail;
            $pembayaranDetail->kode_pesanan       = $detail->kode_pesanan;
            $pembayaranDetail->id_menu            = $detail->id_menu;
            $pembayaranDetail->harga              = $detail->harga;
            $pembayaranDetail->jumlah_pesanan     = $detail->jumlah_pesanan;
            $pembayaranDetail->total_harga        = $detail->total_harga;
            $pembayaranDetail->save();
        }

        return redirect('/pesanan')->with('message', 'Data Pesanan berhasil dikirim!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $pesananHeader      = PesananHeader::where('id', $id)->first();
        $pesananDetail      = PesananDetail::where('kode_pesanan', $pesananHeader->kode_pesanan)->get();
        
        foreach($pesananDetail as $detail){
            $delPesananDetail   = PesananDetail::destroy($detail->id);
        }

        $delPesananHeader   = PesananHeader::destroy($id);

        return redirect('/pesanan')->with('message', 'Data Pesanan berhasil dihapus!');
        
    }

    public function view($id){
        $no = 1;
        $role = Auth::user()->menuroles;
        $dataReservasi = [];
        if($role == 'user'){
            $dataKonsumen   = Konsumen::where('email', Auth::user()->email)->first();
            $dataReservasi  = Reservasi::where('id_konsumen', $dataKonsumen->id)->get();
        }
        if($role == 'admin'){
            $dataReservasi  = Reservasi::get();
        }
        $dataMenu       = DataMenu::all();   
        $pesananHeader  = PesananHeader::where('id', $id)->first();
        $pesananDetail  = PesananDetail::select('data_menu.foto', 'data_menu.nama_menu', 'data_menu.harga', 'pesanan_detail.jumlah_pesanan', 'pesanan_detail.total_harga', 'pesanan_detail.id')
            ->join('data_menu', 'data_menu.id', 'pesanan_detail.id_menu')
            ->where('pesanan_detail.kode_pesanan', $pesananHeader->kode_pesanan)
            ->get();
        return view('dashboard.pesanan.view', [ 'dataReservasi' => $dataReservasi, 'no'=>$no, 'dataMenu' => $dataMenu, 'pesananHeader'=> $pesananHeader, 'pesananDetail'=>$pesananDetail]);
    }
    

    public function destroy_detail(Request $request, $id)
    {
        $pesananDetail      = PesananDetail::where('id', $id)->first();
        $kode_pesanan       = $pesananDetail->kode_pesanan;

        $delPesananDetail   = PesananDetail::destroy($id);

        return redirect('/pesanan/edit/'. $kode_pesanan)->with('message', 'Data Pesanan berhasil dihapus!');
        
    }
}
