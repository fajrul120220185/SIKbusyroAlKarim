@extends('partial.main')
@section('content')

<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <div class="col-12">
               <h4>Saldo Saving : <strong>Rp. {{number_format ($saldoSaving),2,0}}</strong></h4>
            </div>
            <div class="col-12">
                <button class="btn btn-outline-success" data-toggle="modal" data-target="#modalBos"> <i class="fas fa-plus"></i>|| Input Saving</button>
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
                    <th>Sumber</th>
                    <th>Tanggal Input</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($laporanSaving as $saving)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$saving->bulan}}</td>
                        <td>{{$saving->tahun}}</td>
                        <td>Rp. {{number_format ($saving->jumlah),2,0}}</td>
                        <td>{{$saving->sumber}}</td>
                        <td>{{$saving->tgl_masuk}}</td>
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
      <form action="{{ route('savingInput')}}" method="post">
        @csrf
      <div class="modal-body">
            <div class="form-group">
                <label for="">Sumber</label>
                <select name="sumberInput" class="form-control select2" data-placeholder="Pilih Satu!" id="sumberInput" required>
                    <option value="SPP">SPP</option>
                    <option value="BOS">BOS</option>
                    <option value="Ekskul">Ekskul</option>
                    <option value="KegiatanSiswa">Kegiatan Siswa</option>
                    <option value="PemasukanLain">Pemasukan Lain</option>
                </select>
            </div>
            <div class="form-group">
              <label for="">Jumlah</label>
              <input type="number"  name="jumlah" class="form-control" required>
            </div>
            <div id="kegSiswa" style="display: none !important;">
                <div class="form-group">
                    <label for="">Kegiatan Siswa</label>
                    <select name="idKegiatan" id="dariSiswa" class="form-control select2" data-placeholder="Pilih Satu!">
                        @foreach($kegiatanSiswa as $siswa)
                        <option value="{{$siswa->id}}">{{$siswa->name}} -- <strong>{{number_format ($siswa->saldo),2,0}}</strong></option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div id="pemasukan" style="display: none !important;">
                <div class="form-group">
                    <label for="">Pemasukan</label>
                    <select name="idPemasukan" id="pemasukanLain" class="form-control select2" data-placeholder="Pilih Satu!">
                        @foreach($pemasukan as $pem)
                        <option value="{{$pem->id}}">{{$pem->transaksi}} -- <strong>{{number_format ($pem->jumlah),2,0}}</strong></option>
                        @endforeach
                    </select>
                </div>
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

<script>
$('#modalBos').on('shown.bs.modal', function () {
    $('#sumberInput').on('change', function() {
        var sumberInput = $(this).val();
        var kegSiswa = $('#kegSiswa');
        var dariSiswa = $('#dariSiswa');
        var pemasukan = $('#pemasukan');
        
        if (sumberInput == "KegiatanSiswa") {
            kegSiswa.show();
            dariSiswa.attr('required', 'required');
        } else {
            kegSiswa.hide();
            dariSiswa.removeAttr('required');
        }
        if (sumberInput == "PemasukanLain") {
            pemasukan.show();
        } else {
            pemasukan.hide();
        }
    });
});
</script>
@endsection