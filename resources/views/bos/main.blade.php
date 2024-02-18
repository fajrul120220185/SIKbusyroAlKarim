@extends('partial.main')
@section('content')

<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <div class="col-12">
               <h4>Saldo BOS : <strong>Rp. {{number_format ($saldoBos),2,0}}</strong></h4>
            </div>
            <div class="col-12">
                <button class="btn btn-outline-success" data-toggle="modal" data-target="#modalBos"> <i class="fas fa-plus"></i>|| Input Penerimaan Dana BOS</button>
            </div>  
        </div>
        <div class="card-body">
                <table id="example3" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Bulan</th>
                    <th>Tahun</th>
                    <th>Jumlah</th>
                    <th>Tanggal Input</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($laporanBos as $bos)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$bos->bulan}}</td>
                        <td>{{$bos->tahun}}</td>
                        <td>Rp. {{number_format ($bos->jumlah),2,0}}</td>
                        <td>{{$bos->tgl_masuk}}</td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalBos">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Tambah Data Penerimaan BOS</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('inputDanaBOS')}}" method="post">
        @csrf
      <div class="modal-body">
            <div class="form-group">
              <label for="">Jumlah</label>
              <input type="number"  name="jumlah" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Bulan</label>
                <select class="form-control select2" id="bulan" name="bulan" style="width: 100%;" required>
                    @foreach (range(1, 12) as $optionBulan)
                        @php
                            $bulanLabel = date('F', mktime(0, 0, 0, $optionBulan, 1));
                        @endphp
                        <option value="{{ $bulanLabel }}">{{ $bulanLabel }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Tahun</label>
                <select class="form-control select2" id="tahun" name="tahun" style="width: 100%;" required>
                    @foreach (range(date('Y') - 5, date('Y') + 5) as $optionTahun)
                        <option value="{{ $optionTahun }}">{{ $optionTahun }}</option>
                    @endforeach
                </select>
            </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Accept</button>
      </div>
    </div>
    </form>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
@include('saldo.modal-password')
@endsection

@section('custom_js')


@endsection