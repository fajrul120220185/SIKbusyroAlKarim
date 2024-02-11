<div class="container-fluid">
    <div class="card">
        <div class="card-header text-center">
            <h4>Transaksi Kegiatan Siswa</h4>
        </div>
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th></th>
                    <th>Nama</th>
                    <th>Sudah Bayar</th>
                    <th>Harus Bayar</th>
                    <th>Kurang</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($TransSiswa as $ts)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$ts->trans_name}}</td>
                        <td>{{$ts->jumlah}}</td>
                        <td>{{$ts->harus_bayar}}</td>
                        @if($ts->lunas == 'Y')
                        <td>Paid</td>
                        <td>
                        <button type="button" class="btn btn-success"  disabled="disabled">Paid</i></button>
                        </td>
                        @else
                        <td>{{$ts->kurang}}</td>
                        <td>
                        <button type="button" class="btn btn-outline-success Bayar">Pay</i></button>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                  </tbody>
            </table>
        </div>
    </div>
</div>