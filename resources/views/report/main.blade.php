@extends('partial.main')

@section('custom_style')

@endsection
@section('content')

<div class="container-fluid">
    <div class="card mx-auto">
        <div class="card-header">
            <form action="{{ route('ReportTransaksi')}}" method="get">
                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Bulan</label>
                            <select class="form-control select2" name="bulan" data-placeholder="Wajib Pilih !!" id="bulanReport" style="width: 100%;">
                            <option disabled selected value>Pilih Satu!</option>
                                @foreach (range(1, 12) as $optionBulan)
                                    @php
                                        $bulanLabel = date('F', mktime(0, 0, 0, $optionBulan, 1));
                                    @endphp
                                    <option value="{{ $bulanLabel }}">{{ $bulanLabel }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tahun</label>
                            <select class="form-control select2" id="tahunReport" name="tahun" style="width: 100%;">
                            <option disabled selected value>Pilih Satu!</option>
                                @foreach (range(date('Y') - 5, date('Y') + 5) as $optionTahun)
                                    <option value="{{ $optionTahun }}">{{ $optionTahun }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-3 align-self-end">
                        <div class="form-group">
                            <button type="submit" class="btn btn-outline-info"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body">
           
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="container">
                    <div class="row p-3">
                      <div class="col-xs-12 col-6">
                        <p>Saldo SPP      : </p>
                        <p>Saldo Ekskul : </p>
                        <p>Saldo BOS : </p>
                        <p>Saldo Saving : </p>
                        <p>Saldo Kegiatan : </p>
                        <p>Saldo Pemasukan Lain : </p>
                        <p>Grand Saldo: </p>
                      </div>
                      <div class="col-xs-12 col-6" style="text-align: right;">
                       <p><strong>Rp. {{number_format ($saldoSPP),2,0}}</strong></p> 
                       <p><strong>Rp. {{number_format ($saldoEkskul),2,0}}</strong></p>
                       <p><strong>Rp. {{number_format ($saldoBOS),2,0}}</strong></p>
                       <p><strong>Rp. {{number_format ($saldoSaving),2,0}}</strong></p>
                       <p><strong>Rp. {{number_format ($saldoKegiatan),2,0}}</strong></p>
                       <p><strong>Rp. {{number_format ($saldoPemasukan),2,0}}</strong></p>
                       <p><strong>Rp. {{number_format ($saldoTotal),2,0}}</strong></p>

                      </div>
                      <div class="col-12">
                        <p>Terbilang : <strong> <h6> "{{$terbilang}} Rupiah" </h6> </strong></p>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('custom_js')




@endsection