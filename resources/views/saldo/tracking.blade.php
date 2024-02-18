@extends('partial.main')
@section('content')

<div class="container-fluid">
    <div class="card">
        <div class="card-header">

        </div>
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th></th>
                        <th>Keluar/Masuk</th>
                        <th>Keterangan</th>
                        <th>Jumlah</th>
                        <th>Bulan</th>
                        <th>Tahun</th>
                        <th>Input By</th>
                        <th>Input At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($saldo as $sal)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        @if($sal->keluar_masuk == 'M')
                        <td>Masuk</td>
                        @else
                        <td>Keluar</td>
                        @endif
                        <td>{{$sal->desc}}</th>
                        <td>{{$sal->jumlah_km}}</th>
                        <td>{{$sal->bulan}}</th>
                        <td>{{$sal->tahun}}</th>
                        <td>{{$sal->user}}</th>
                        <td>{{$sal->created_at}}</th>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection