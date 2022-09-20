<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Reservasi;

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
        $reservasi = Reservasi::paginate(10);
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
        $reservasi = new DataMenu();
        $reservasi->tanggal_reservasi     = $request->input('tanggal_reservasi');
        $reservasi->kode_booking          = $request->input('kode_booking');
        $reservasi->id_konsumen           = $request->input('id_konsumen');
        $reservasi->jumlah_tamu           = $request->input('jumlah_tamu');
        $reservasi->untuk_tanggal         = $request->input('untuk_tanggal');
        $reservasi->status                = $request->input('status');
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
        $reservasi = Reservasi::find($id);
        return view('dashboard.reservasi.edit', [ 'Reservasi' => $Reservasi]);
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
        $reservasi = Reservasi::find($id);
        $reservasi->jumlah_tamu     = $request->input('jumlah_tamu');
        $reservasi->untuk_tanggal   = $request->input('untuk_tanggal');
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
