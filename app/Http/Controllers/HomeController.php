<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use App\Models\MKelas;
use App\Models\Pengeluaran;
use App\Models\Pemasukan;
use App\Models\SPP;
use App\Models\Gaji;

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
        $data['title'] = "Home Page";
        return view('welcome', $data);
    }



    public function indexSMP()
    {
        $data['title'] = 'Dashboard SMP';
        $data['kelas'] = MKelas::get();
        $pemasukanData = [];
    $pengeluaranData = [];

    // Ambil data pemasukan
    $pemasukan = Pemasukan::whereBetween('tanggal', [now()->subMonths(5)->startOfMonth(), now()->endOfMonth()])
        ->get();
        $spp = SPP::whereBetween('paid_at', [now()->subMonths(5)->startOfMonth(), now()->endOfMonth()])
        ->get();

    // Ambil data pengeluaran
    $pengeluaran = Pengeluaran::whereBetween('tanggal', [now()->subMonths(5)->startOfMonth(), now()->endOfMonth()])
        ->get();
        $gaji = Gaji::whereBetween('paid_at', [now()->subMonths(5)->startOfMonth(), now()->endOfMonth()])
        ->get();

    // Loop untuk mengisi data pemasukan dan pengeluaran ke dalam array
    for ($i = 5; $i >= 0; $i--) {
        $month = now()->subMonths($i);
        $labels[] = $month->format('F'); // Format nama bulan
        $pemasukanData[] = $pemasukan->where('tanggal', '>=', $month->startOfMonth())
            ->where('tanggal', '<=', $month->endOfMonth())
            ->sum('jumlah') + $spp->where('paid_at', '>=', $month->startOfMonth())
            ->where('paid_at', '<=', $month->endOfMonth())
            ->sum('jumlah');
        $pengeluaranData[] = $pengeluaran->where('tanggal', '>=', $month->startOfMonth())
            ->where('tanggal', '<=', $month->endOfMonth())
            ->sum('jumlah') + $gaji->where('paid_at', '>=', $month->startOfMonth())
            ->where('paid_at', '<=', $month->endOfMonth())
            ->sum('total');
    }

    $areaChartData = [
        'labels' => $labels,
        'datasets' => [
            [
                'label' => 'Pemasukan',
                'backgroundColor' => 'rgba(60,141,188,0.9)',
                'borderColor' => 'rgba(60,141,188,0.8)',
                'pointRadius' => false,
                'pointColor' => '#3b8bba',
                'pointStrokeColor' => 'rgba(60,141,188,1)',
                'pointHighlightFill' => '#fff',
                'pointHighlightStroke' => 'rgba(60,141,188,1)',
                'data' => $pemasukanData,
            ],
            [
                'label' => 'Pengeluaran',
                'backgroundColor' => 'rgba(210, 214, 222, 1)',
                'borderColor' => 'rgba(210, 214, 222, 1)',
                'pointRadius' => false,
                'pointColor' => 'rgba(210, 214, 222, 1)',
                'pointStrokeColor' => '#c1c7d1',
                'pointHighlightFill' => '#fff',
                'pointHighlightStroke' => 'rgba(220,220,220,1)',
                'data' => $pengeluaranData,
            ],
        ],
    ];

    // DonutChat
    $bulanIni = Carbon::now()->format('Y-m');

    // Ambil data pemasukan untuk bulan ini dan donut chart
    $pemasukanDonut = Pemasukan::select(DB::raw('transaksi, SUM(jumlah) as total'))
        ->whereRaw('MONTH(tanggal) = ?', [Carbon::now()->month])
        ->whereRaw('YEAR(tanggal) = ?', [Carbon::now()->year])
        ->groupBy('transaksi')
        ->get();

        $sppDonut = SPP::select(DB::raw('SUM(jumlah) as total'))
        ->whereRaw('MONTH(paid_at) = ?', [Carbon::now()->month])
        ->whereRaw('YEAR(paid_at) = ?', [Carbon::now()->year])
        ->get();

    // Format data untuk donut chart
    $donutChartData = [
        'labels' => $pemasukanDonut->pluck('transaksi')->merge(['SPP']),
        'datasets' => [
            [
                'data' => $pemasukanDonut->pluck('total')->merge([$sppDonut->sum('total')]),
                'backgroundColor' => ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
            ],
        ],
    ];


    // DonutChat2
    $bulanIni = Carbon::now()->format('Y-m');

    // Ambil data pemasukan untuk bulan ini dan donut chart
    $pengeluaranDonut = Pengeluaran::select(DB::raw('transaksi, SUM(jumlah) as total'))
        ->whereRaw('MONTH(tanggal) = ?', [Carbon::now()->month])
        ->whereRaw('YEAR(tanggal) = ?', [Carbon::now()->year])
        ->groupBy('transaksi')
        ->get();

        $gajiDonut = Gaji::select(DB::raw('SUM(total) as Grand'))
        ->whereRaw('MONTH(paid_at) = ?', [Carbon::now()->month])
        ->whereRaw('YEAR(paid_at) = ?', [Carbon::now()->year])
        ->get();

    // Format data untuk donut chart
    $donutChartPengeluaran = [
        'labels' => $pengeluaranDonut->pluck('transaksi')->merge(['Gaji']),
        'datasets' => [
            [
                'data' => $pengeluaranDonut->pluck('total')->merge([$sppDonut->sum('Grand')]),
                'backgroundColor' => ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
            ],
        ],
    ];

        return view('home', compact('areaChartData', 'donutChartData', 'donutChartPengeluaran'), $data)->with('success','Selamat Datang');
    }

    public function indexSD()
    {

        return back()->with('error', 'Still In Developmetn');
    }

   
}
