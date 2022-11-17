<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservasi;
use App\Models\Konsumen;
use Carbon\Carbon;

class ReservasiController extends Controller
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
        $reservasi = Reservasi::select('reservasi.id', 'reservasi.kode_booking', 'data_konsumen.nama_lengkap', 'reservasi.tanggal_reservasi',
                    'reservasi.untuk_tanggal', 'reservasi.jumlah_tamu', 'reservasi.status')
                    ->join('data_konsumen', 'data_konsumen.id', 'reservasi.id_konsumen')
                    ->where('reservasi.id_konsumen', $dataKonsumen->id)
                    ->orderBy('tanggal_reservasi', 'asc')
                    ->paginate(10);
        $no = 1;
        return view('dashboard.reservasi.index', [ 'reservasi' => $reservasi , 'no' => $no]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $reservasi = Reservasi::all();
        return view('dashboard.reservasi.create', [ 'reservasi' => $reservasi]);
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

        $check = Reservasi::whereDate('created_at', Carbon::today())->get();
        
        $max = count($check);

        if($max > 0){
            $kode_booking = 'BO' . $tahun . $bulan . $tanggal . sprintf("%04s", abs($max + 1));
        }else{
            $kode_booking = 'BO' . $tahun . $bulan . $tanggal . sprintf("%04s", $no);
        }    

        $reservasi = new Reservasi();
        $reservasi->tanggal_reservasi     = date("Y-m-d H:i:s");
        $reservasi->kode_booking          = $kode_booking;
        $reservasi->id_konsumen           = $dataKonsumen->id;
        $reservasi->jumlah_tamu           = $request->input('jumlah_tamu');
        $reservasi->untuk_tanggal         = $request->input('untuk_tanggal');
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
    /*public function edit($id)
    {
        $reservasi = Reservasi::find($id);
        return view('dashboard.reservasi.edit', [ 'Reservasi' => $Reservasi]);
    }
    */
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $reservasi = Reservasi::find($id);
        $reservasi->status     = 'Cancel';
        $reservasi->save();
        $request->session()->flash('message', 'Successfully edited');
        return redirect()->route('reservasi.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /*public function destroy(Request $request, $id)
    
        $reservasi = Reservasi::find($id);
        if($reservasi){
            $reservasi->delete();
        }
        $request->session()->flash('message', 'Successfully deleted');
        return redirect()->route('reservasi.index');
    }
    */
}
