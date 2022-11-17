<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PesananHeader;
use App\Models\PesananDetail;
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
        $dataKonsumen   = Konsumen::where('email', Auth::user()->email)->first();
        $pesananH       = PesananHeader::where('id_konsumen', $dataKonsumen->id)
                            ->orderBy('tanggal_pesanan', 'asc')
                            ->paginate(10);
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

        $reservasi = new PesananHeader();
        $reservasi->tanggal_pesanan       = date("Y-m-d H:i:s");
        $reservasi->kode_pesanan          = $kode_pesanan;
        $reservasi->id_konsumen           = $dataKonsumen->id;
        $reservasi->tipe_pesanan           = $request->input('tipe_pesanan');
        $reservasi->id_reservasi         = $request->input('id_reservasi');
        $reservasi->status                = 'Booked';
        $reservasi->save();
        $request->session()->flash('message', 'Successfully created');
        return redirect()->route('reservasi.index');
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
    public function edit($id)
    {
        $dataMenu = DataMenu::find($id);
        return view('dashboard.data-menu.edit', [ 'dataMenu' => $dataMenu]);
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
        //var_dump('bazinga');
        //die();
        if($request->foto != null){
            $validatedData = $request->validate([
                'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $fotoName = time().'.'.$request->foto->extension();  
            $request->foto->move(public_path('images'), $fotoName);
        }
       

        $dataMenu = DataMenu::find($id);
        $dataMenu->nama_menu     = $request->input('nama_menu');
        $dataMenu->deskripsi     = $request->input('deskripsi');
        $dataMenu->harga         = $request->input('harga');
        if($request->foto != null){
            $dataMenu->foto          = $fotoName;
        }
        $dataMenu->save();
        $request->session()->flash('message', 'Successfully edited');
        return redirect()->route('data-menu.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $dataMenu = DataMenu::find($id);
        if($dataMenu){
            $dataMenu->delete();
        }
        $request->session()->flash('message', 'Successfully deleted');
        return redirect()->route('data-menu.index');
    }
}
