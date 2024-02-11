<div class="container-fluid">
    <div class="card">
        <div class="card-header text-center">
            <h4>Laporan Pengeluaran</h4>
        </div>
        <div class="card-body">
            <table id="example3" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th></th>
                    <th>Transaksi</th>
                    <th>Nominal</th>
                    <th>Tanggal</th>
                  </tr>
                  </thead>
                  <tbody>
                  @php
                      $pemasukanArray = $pemasukan->toArray();
                      $transaksi_siswaArray = $transaksi_siswa->toArray();
                  @endphp

                @foreach($pengeluaran as $pengeluaran)
                 <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$pengeluaran->transaksi}}</td>
                    <td>{{$pengeluaran->jumlah}}</td>
                    <td>{{$pengeluaran->tanggal}}</td>
                 </tr>
                 @endforeach
                    <tr class="yellow-row">
                       <td></td>
                       <td>Gaji</td>
                       <td>{{$totalGaji}}</td>
                       <td></td>
                    </tr>
                  </tbody>
            </table>
        </div>
        <div class="card-footer">
            <div class="form-group">
                <label for=""><h4>Total :</h4></label>
                <h4>Rp. {{ number_format($totalPengeluaran, 2, ',', '.') }}</h4>
            </div>
        </div>
    </div>
</div>