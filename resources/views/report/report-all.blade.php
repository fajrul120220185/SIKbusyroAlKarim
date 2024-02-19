@extends('partial.main')

@section('custom_style')

@endsection
@section('content')

<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h4 style="text-align: center;">Laporan Keuangan</h4>
        </div>
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th colspan="3" style="text-align: center;">PENERIMAAN</th>
                        <th colspan="3" style="text-align: center;">PENGELUARAN</th>
                    </tr>
                    <tr style="text-align: center;">
                        <th>NO</th>
                        <th>URAIAN</th>
                        <th>JUMLAH</th>
                        <th>NO</th>
                        <th>URAIAN</th>
                        <th>JUMLAH</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Saldo SPP Bulan {{$bulanLalu}}</td>
                        <td>Rp. {{number_format ($saldoSPPKemarin->saldo),2,0}}</td>
                        <td>1</td>
                        <td>SPP</td>
                        <td>Rp. {{number_format ($keluarSPP),2,0}}</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Diterima SPP Bulan {{$bulan}} - {{$tahun}}</td>
                        <td>Rp. {{number_format ($saldoSPP),2,0}}</td>
                        <td>2</td>
                        <td>EKSKUL</td>
                        <td>Rp. {{number_format ($keluarEkskul),2,0}}</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Saldo Ekskul Bulan {{$bulanLalu}}</td>
                        <td>Rp. {{number_format ($saldoEkskulKemarin),2,0}}</td>
                        <td>3</td>
                        <td>BOS</td>
                        <td>Rp. {{number_format ($saldoBosKemarin),2,0}}</td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Diterima Ekskul Bulan {{$bulan}} - {{$tahun}}</td>
                        <td>Rp. {{number_format ($saldoEkskul),2,0}}</td>
                        <td>4</td>
                        <td>Pengeluaran dari Sumber Lain</td>
                        <td>Rp. {{number_format ($saldoPengeluaran),2,0}}</td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>Saldo BOS Bulan {{$bulanLalu}} </td>
                        <td>Rp. {{number_format ($saldoBosKemarin),2,0}}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>6</td>
                        <td>Diterima Alokasi Bos Bulan {{$bulan}} - {{$tahun}}</td>
                        <td>Rp. {{number_format ($saldoBos),2,0}}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>7</td>
                        <td>Pemasukan Lain {{$bulan}} - {{$tahun}}</td>
                        <td>Rp. {{number_format ($saldoPemasukan),2,0}}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>8</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>9</td>
                        <td>Total Pemasukan</td>
                        <td>Rp. {{number_format ($totalPemasukan),2,0}}</td>
                        <td></td>
                        <td>Total Pengeluaran</td>
                        <td>Rp. {{number_format ($totalPengeluaran),2,0}}</td>
                    </tr>
                    <tr>
                        <td>10</td>
                        <td  style="text-align: center;"><strong>{{$terbilangMasuk}}</strong></td>
                        <td></td>
                        <td></td>
                        <td  style="text-align: center;"><strong>{{$terbilangKeluar}}</strong></td>
                        <td></td>
                    </tr>
                    
                </tbody>
            </table>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h4 style="text-align: center;">Laporan Saving</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Masuk -->
                <div class="col-6">
                    <div class="card">
                        <div class="card-header">
                            <h6 style="text-align: center;"><strong>Masuk</strong></h6>
                        </div>
                        <div class="card-body">
                            @include('report.pemasukan')
                        </div>
                    </div>
                </div>

                <!-- Keluar -->
                <div class="col-6">
                    <div class="card">
                        <div class="card-header">
                                <h6 style="text-align: center;"><strong>Keluar</strong></h6>
                        </div>
                        <div class="card-body">
                            @include('report.pengeluaran')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection