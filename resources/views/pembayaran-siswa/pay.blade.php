@extends('partial.main')
@section('content')


<div class="container-fluid">
    <div class="card">
        <div class="card-header">

        </div>
        <form action="{{ route('PaySiswa')}}" method="post">
            @csrf
            <div class="card-body">
                @if($bayarSPP != null)
                <h4>SPP</h4>
                <div class="row">
                    @foreach ($bayarSPP as $spp)
                    <div class="col-4">
                        <div class="form-gorup">
                            <label for="">Bulan</label>
                            <input type="text" class="form-control" readonly value="{{$spp->bulan}}">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-gorup">
                            <label for="">Tahun</label>
                            <input type="text" class="form-control" readonly value="{{$spp->tahun}}">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-gorup">
                            <label for="">Jumlah</label>
                            <input type="number" class="form-control" readonly value="{{$spp->harus_bayar}}">
                            <input type="hidden" name="spp_id[]" value="{{$spp->id}}">
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
                <hr>
               @if($kegiatan != null)
               <h4>Kegiatan Siswa</h4>
                <div class="row">
                    @foreach($kegiatan as $keg)
                    <div class="col-3">
                             <label for="">Nama</label>
                            <input type="text" class="form-control" readonly value="{{$keg->trans_name}}">
                    </div>
                    <div class="col-3">
                             <label for="">Total Lunas</label>
                            <input type="text" class="form-control" readonly value="{{$keg->harus_bayar}}">
                    </div>
                    <div class="col-3">
                             <label for="">Kurang</label>
                            <input type="text" class="form-control" readonly value="{{$keg->kurang}}">
                    </div>
                    <div class="col-3">
                             <label for="">Ingin Bayar</label>
                            <input type="text" class="form-control" name="jumlah{{$keg->id}}" >
                            <input type="hidden" class="form-control" name="trans_id[]" value="{{$keg->id}}" readonly>
                    </div>
                    @endforeach
                </div>
                @endif
                <input type="hidden" name="siswa_id" value="{{$siswa_id}}">
            </div>
            
            <div class="card-footer">
                <button type="submit" class="btn btn-outline-success">Pay</button>
                <button type="button" class="btn btn-outline-danger" onclick="window.history.back()">Back</button>
            </div>
        </form>
    </div>
</div>
@endsection