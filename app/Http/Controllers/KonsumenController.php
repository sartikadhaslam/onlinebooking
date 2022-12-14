<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Konsumen;
use Auth;

class KonsumenController extends Controller
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
        $dataKonsumen = Konsumen::paginate(10);
        $no = 1;
        return view('dashboard.konsumen.index', [ 'dataKonsumen' => $dataKonsumen, 'no' => $no ]);
    }
}
