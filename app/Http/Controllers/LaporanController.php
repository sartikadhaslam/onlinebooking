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
use DB;

class LaporanController extends Controller
{
    public function laporan_reservasi(Request $request){
        $data = [];
        $no = 1;
        $tanggal_awal = [];
        $tanggal_akhir = [];
        
        if($request->tanggal_awal != null && $request->tanggal_akhir != null){
            $data = Reservasi::select('reservasi.id', 'reservasi.untuk_tanggal', 'reservasi.kode_booking', 'data_konsumen.nama_lengkap', 'data_konsumen.nomor_telepon', 'reservasi.jumlah_tamu', 'reservasi.status')
                ->join('data_konsumen', 'data_konsumen.id', 'reservasi.id_konsumen')
                ->whereBetween('reservasi.untuk_tanggal', [$request->tanggal_awal, $request->tanggal_akhir])
                ->orderBy('reservasi.untuk_tanggal', 'asc')
                ->get();
        }

        $commandData = [
            'data'          => $data,
            'no'            => $no,
            'tanggal_awal'  => $request->tanggal_awal,
            'tanggal_akhir' => $request->tanggal_akhir

        ];

        return view('dashboard.laporan.reservasi.index', $commandData);
    }

    public function laporan_pesanan(Request $request){
        $data = [];
        $no = 1;
        $tanggal_awal = [];
        $tanggal_akhir = [];
        
        if($request->tanggal_awal != null && $request->tanggal_akhir != null){
            $data = PesananHeader::select('pesanan_header.id', 'pesanan_header.tanggal_pesanan', 'pesanan_header.kode_pesanan', 'data_konsumen.nama_lengkap', 'pesanan_header.tipe_pesanan', 'pesanan_header.total', 'pesanan_header.status')
                ->join('data_konsumen', 'data_konsumen.id', 'pesanan_header.id_konsumen')
                ->whereBetween('pesanan_header.tanggal_pesanan', [$request->tanggal_awal, $request->tanggal_akhir])
                ->orderBy('pesanan_header.tanggal_pesanan', 'asc')
                ->get();
        }

        $commandData = [
            'data'          => $data,
            'no'            => $no,
            'tanggal_awal'  => $request->tanggal_awal,
            'tanggal_akhir' => $request->tanggal_akhir

        ];

        return view('dashboard.laporan.pesanan.index', $commandData);
    }

    public function laporan_pembayaran(Request $request){
        $data = [];
        $no = 1;
        $tanggal_awal = [];
        $tanggal_akhir = [];
        
        if($request->tanggal_awal != null && $request->tanggal_akhir != null){
            $data = PembayaranHeader::select('pembayaran_header.id', 'pembayaran_header.tanggal_pembayaran', 'pembayaran_header.kode_pesanan', 'data_konsumen.nama_lengkap', 'pembayaran_header.total_tagihan', 'pembayaran_header.total_tagihan_ppn', 'pembayaran_header.metode_pembayaran', 'pembayaran_header.jumlah_pembayaran', 'pembayaran_header.status')
                ->join('data_konsumen', 'data_konsumen.id', 'pembayaran_header.id_konsumen')
                ->whereBetween('pembayaran_header.tanggal_pembayaran', [$request->tanggal_awal, $request->tanggal_akhir])
                ->orderBy('pembayaran_header.tanggal_pembayaran', 'asc')
                ->get();
        }

        $commandData = [
            'data'          => $data,
            'no'            => $no,
            'tanggal_awal'  => $request->tanggal_awal,
            'tanggal_akhir' => $request->tanggal_akhir

        ];

        return view('dashboard.laporan.pembayaran.index', $commandData);
    }

    public function laporan_menu(Request $request){
        $data = [];
        $no = 1;
        $tanggal_awal = [];
        $tanggal_akhir = [];
        
        if($request->tanggal_awal != null && $request->tanggal_akhir != null){
            $data = PesananDetail::select('data_menu.nama_menu', DB::raw("SUM(pesanan_detail.total_harga) as total_harga"))
                ->join('data_menu', 'data_menu.id', 'pesanan_detail.id_menu')
                ->whereBetween('pesanan_detail.created_at', [$request->tanggal_awal, $request->tanggal_akhir])
                ->groupBy('data_menu.nama_menu')
                ->orderBy('total_harga', 'asc')
                ->get();
        }

        $commandData = [
            'data'          => $data,
            'no'            => $no,
            'tanggal_awal'  => $request->tanggal_awal,
            'tanggal_akhir' => $request->tanggal_akhir

        ];

        return view('dashboard.laporan.tren-menu.index', $commandData);
    }

    public function laporan_konsumen(Request $request){
        $data = [];
        $no = 1;
        $tanggal_awal = [];
        $tanggal_akhir = [];
        
        if($request->tanggal_awal != null && $request->tanggal_akhir != null){
            $data = Konsumen::whereBetween('created_at', [$request->tanggal_awal, $request->tanggal_akhir])->get();
        }

        $commandData = [
            'data'          => $data,
            'no'            => $no,
            'tanggal_awal'  => $request->tanggal_awal,
            'tanggal_akhir' => $request->tanggal_akhir

        ];

        return view('dashboard.laporan.konsumen.index', $commandData);
    }
}
