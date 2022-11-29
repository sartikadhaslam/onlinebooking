<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservasi;
use App\Models\DataMenu;
use App\Models\Konsumen;
use App\Models\PesananHeader;
use App\Models\PesananDetail;
use App\Models\PembayaranHeader;
use App\Models\PembayaranDetail;
use Auth;
use DB;

class HomeController extends Controller
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
    public function index()
    {
        $role = Auth::user()->menuroles;
        $data_konsumen      = [];
        $data_reservasi     = [];
        $data_pesanan       = [];
        $data_pembayaran    = [];
        $pesanan            = [];
        if($role == 'admin'){
            $data_konsumen      = Konsumen::get();
            $data_reservasi     = Reservasi::where('status',  '!=', 'Cancel')->get();
            $data_pesanan       = PesananHeader::where('status',  '!=', 'Draft')->get();
            $data_pembayaran    = PembayaranHeader::get();
            $pesanan            = PesananHeader::select('tanggal_pesanan', DB::RAW('COUNT(id) as id'))->whereMonth('created_at', date('m'))->groupBy('tanggal_pesanan')->get();
        }
        if($role == 'user'){
            $data_konsumen      = Konsumen::where('email', Auth::user()->email)->first();
            $data_reservasi     = Reservasi::where([
                    ['status',  '!=', 'Cancel'],
                    ['id_konsumen',  $data_konsumen->id]
                ])
                ->get();
            $data_pesanan       = PesananHeader::where([
                    ['status',  '!=', 'Draft'],
                    ['id_konsumen',  $data_konsumen->id]
                ])
                ->get();
            $data_pembayaran    = PembayaranHeader::where('id_konsumen',  $data_konsumen->id)->get();
            $pesanan            = PesananHeader::select('tanggal_pesanan', DB::RAW('COUNT(id) as id'))
                ->where('id_konsumen',  $data_konsumen->id)->whereMonth('created_at', date('m'))->groupBy('tanggal_pesanan')
                ->get();
        }
        if($role == 'pemilik'){
            $data_konsumen      = Konsumen::get();
            $data_reservasi     = Reservasi::where('status',  '!=', 'Cancel')->get();
            $data_pesanan       = PesananHeader::where('status',  '!=', 'Draft')->get();
            $data_pembayaran    = PembayaranHeader::get();
            $pesanan            = PesananHeader::select('tanggal_pesanan', DB::RAW('COUNT(id) as id'))->whereMonth('created_at', date('m'))->groupBy('tanggal_pesanan')->get();
        }
        $month = date('M');

        $year = date('Y');

        $commonData = [
            'data_konsumen'     => $data_konsumen,
            'data_reservasi'    => $data_reservasi,
            'data_pesanan'      => $data_pesanan,
            'data_pembayaran'   => $data_pembayaran,
            'role'              => $role,
            'pesanan'           => $pesanan,
            'month'             => $month,
            'year'              => $year
        ];

        return view('dashboard.homepage', $commonData);
    }
}
