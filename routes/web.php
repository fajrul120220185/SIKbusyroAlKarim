<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\PemasukanController;
use App\Http\Controllers\GajiController;
use App\Http\Controllers\SPPController;
use App\Http\Controllers\TransisController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\SaldoAwal;
use App\Http\Controllers\BosController;
use App\Http\Controllers\SavingController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/smp', [App\Http\Controllers\HomeController::class, 'indexSMP'])->name('IndexSmp');
Route::get('/SD', [App\Http\Controllers\HomeController::class, 'indexSD'])->name('IndexSD');
Route::get('/get-chart-data', [App\Http\Controllers\HomeController::class, 'getChartData']);
// master
    // siswa
Route::get('/master/siswa', [SiswaController::class, 'Main']);
Route::get('/master/siswa/edit-{id}', [SiswaController::class, 'Edit']);
Route::post('/master/siswa/store', [SiswaController::class, 'Store']);
Route::post('/master/siswa/excel', [SiswaController::class, 'Excel']);
Route::post('/master/siswa/update', [SiswaController::class, 'Update']);
Route::post('/master/siswa/delete-{id}', [SiswaController::class, 'Delete']);

    //Guru 
Route::get('/master/guru', [GuruController::class, 'Main']);
Route::get('/master/guru/edit-{id}', [GuruController::class, 'Edit']);
Route::post('/master/guru/store', [GuruController::class, 'Store']);
Route::post('/master/guru/excel', [GuruController::class, 'Excel']);
Route::post('/master/guru/update', [GuruController::class, 'Update']);
Route::post('/master/guru/delete-{id}', [GuruController::class, 'Delete']);
    // Kelas
Route::get('/master/kelas', [KelasController::class, 'Main']);
Route::get('/master/kelas/edit-{id}', [KelasController::class, 'Edit']);
Route::post('/master/kelas/store', [KelasController::class, 'Store']);
Route::post('/master/kelas/update', [KelasController::class, 'Update']);
Route::post('/master/kelas/delete-{id}', [KelasController::class, 'Delete']);
    // Transaksi
Route::get('/master/transaksi/pengeluaran', [TransaksiController::class, 'MainPengeluaran']);
Route::get('/master/transaksi/pemasukan', [TransaksiController::class, 'MainPemasukan']);
Route::get('/master/transaksi/edit-{id}', [TransaksiController::class, 'Edit']);
Route::post('/master/transaksi/store', [TransaksiController::class, 'Store']);
Route::post('/master/transaksi/update', [TransaksiController::class, 'Update']);
Route::post('/master/transaksi/delete-{id}', [TransaksiController::class, 'Delete']);

Route::get('/master/transaksi/siswa', [TransaksiController::class, 'MainSiswa']);
Route::post('/master/transaksi/siswa/store', [TransaksiController::class, 'StoreSiswa']);






// Kelas List
Route::get('/kelas/{id}', [KelasController::class, 'ListView'])->name('kelasView');
Route::post('/kelas/addSiswa', [KelasController::class, 'addSiswa'])->name('addSiswa');
Route::post('/kelas/moveSiswa', [KelasController::class, 'moveSiswa'])->name('moveSiswa');


// Transaksi
    //Pengeluaran
    Route::get('/transaksi/pengeluaran', [PengeluaranController::class, 'main']);
    Route::post('/transaksi/pengeluaran/post', [PengeluaranController::class, 'post']);
    Route::get('/transaksi/pengeluaran/edit-{id}', [PengeluaranController::class, 'edit']);
    Route::post('/transaksi/pengeluaran/update', [PengeluaranController::class, 'update']);
    Route::post('/transaksi/pengeluaran/delete-{id}', [PengeluaranController::class, 'deleted']);
     
    //Pemasukan
    Route::get('/transaksi/pemasukan', [PemasukanController::class, 'main']);
    Route::post('/transaksi/pemasukan/post', [PemasukanController::class, 'post']);
    Route::get('/transaksi/pemasukan/edit-{id}', [PemasukanController::class, 'edit']);
    Route::post('/transaksi/pemasukan/update', [PemasukanController::class, 'update']);
    Route::post('/transaksi/pemasukan/delete-{id}', [PemasukanController::class, 'deleted']);

// Gaji
Route::get('/gaji/{tahun?}', [GajiController::class, 'main']);
Route::get('/gaji/guru/{guru}/{tahun}-{bulan}', [GajiController::class, 'formGaji']);
Route::post('/gaji/pay', [GajiController::class, 'Pay']);
Route::get('/gaji/foto/{guru}/{bulan}/{tahun}', [GajiController::class, 'lihatBukti']);
Route::get('/gaji/bukti/{id}', [GajiController::class, 'Bukti']);

// SPP
Route::get('/spp/{kelas?}', [SPPController::class, 'main'])->name('spp');
Route::post('/spp/pay', [SPPController::class, 'pay']);
Route::get('/spp/report/{kelas}/{bulan}/{tahun}', [SPPController::class, 'reportPrint']);
Route::get('/spp/bukti/{id}/{bulan}/{tahun}', [SPPController::class, 'Bukti']);
Route::get('/spp/foto/{id}', [SPPController::class, 'Print']);
Route::get('/spp/tagihan/{id}/{bulan}/{tahun}', [SPPController::class, 'Tagihan']);
Route::get('/spp/tagihan/print/{id}/{bulan}/{tahun}', [SPPController::class, 'PrintTagihan']);




// Transis
Route::get('/transaksi/siswa/{id?}', [TransisController::class, 'main'])->name('transaksi-siswa');
Route::post('/transaksi/siswa/pay', [TransisController::class, 'pay']);
Route::get('/transaksi/siswa/bukti/{transis}/{id}', [TransisController::class, 'Bukti']);
Route::get('/transaksi/siswa/print/{id}', [TransisController::class, 'Print']);
Route::get('/transaksi/siswa/report/{kelas}/{trans_id}', [TransisController::class, 'reportPrint']);
Route::get('/transaksi/siswa/tagihan/{id}/{transis}', [TransisController::class, 'Tagihan']);
Route::get('/transaksi/siswa/tagihan/print/{id}/{kurang}/{master}', [TransisController::class, 'TagihanPrint']);



// Rport
Route::get('/report/{startDate}/{endDate}', [ReportController::class, 'main']);
Route::get('/search/report/', [ReportController::class, 'search']);


// Pembayaran Siswa
Route::get('/pembayaran-siswa/{siswa?}', [PembayaranController::class, 'main'])->name('pembayaran-siswa');
Route::get('/pembayaran-siswa/tagihan/{spp?}/{kegiatan?}/{siswa?}', [PembayaranController::class, 'tagihan'])->name('tagihan');
Route::get('/pembayaran-siswa/pay/getData', [PembayaranController::class, 'getData'])->name('getData');
Route::get('/pembayaran-siswa/pay/prosesBayar', [PembayaranController::class, 'prosesBayar'])->name('prosesBayar');
Route::post('/pembayaran-siswa/paySiswa', [PembayaranController::class, 'PaySiswa'])->name('PaySiswa');
Route::get('/pembayaran-siswa/kwitansi/{spp?}/{kegiatan?}/{siswa?}', [PembayaranController::class, 'kwitansi'])->name('kwitansi');

// Saldo Awal
Route::get('/saldo-awal', [SaldoAwal::class, 'saldoView'])->name('saldoView');
Route::get('/saldo-awal/login', [SaldoAwal::class, 'saldoAwalLogin'])->name('saldoAwalLogin');
Route::get('/saldo-awal/spp-password', [SaldoAwal::class, 'SPPlogin'])->name('SPPlogin');
Route::post('/saldo-awal/input-saldo', [SaldoAwal::class, 'InputSaldo'])->name('InputSaldo');
Route::get('/saldo-awal/tracking', [SaldoAwal::class, 'trackingSaldo'])->name('trackingSaldo');



// Bos
Route::get('/bos', [BosController::class, 'index'])->name('bosIndex');
Route::post('/bos-input', [BosController::class, 'store'])->name('inputDanaBOS');

// Saving
Route::get('/saving', [SavingController::class, 'index'])->name('savingIndex');
Route::post('/saving-post', [SavingController::class, 'store'])->name('savingInput');
