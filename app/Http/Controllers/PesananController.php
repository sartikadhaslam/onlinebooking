<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PesananHeader;
use App\Models\PesananDetail;
use App\Models\DataMenu;
use Auth;

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
        $pesanan    = PesananHeader::paginate(10);
        $no         = 1;
        return view('dashboard.pesanan.index', [ 'pesanan' => $pesanan , 'no' => $no]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dataMenu = DataMenu::all();
        return view('dashboard.data-menu.create', [ 'dataMenu' => $dataMenu]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $fotoName = time().'.'.$request->foto->extension();  
     
        $request->foto->move(public_path('images'), $fotoName);

        $dataMenu = new DataMenu();
        $dataMenu->nama_menu     = $request->input('nama_menu');
        $dataMenu->deskripsi     = $request->input('deskripsi');
        $dataMenu->harga         = $request->input('harga');
        $dataMenu->foto          = $fotoName;
        $dataMenu->save();
        $request->session()->flash('message', 'Successfully created');
        return redirect()->route('data-menu.index');
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
