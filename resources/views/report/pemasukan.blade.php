<div class="container-fluid">
    <div class="card">
        <div class="card-header text-center">
            <h4>Laporan Pemasukan</h4>
        </div>
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
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

                @foreach($pemasukan as $pemasukan)
                 <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$pemasukan->transaksi}}</td>
                    <td>{{$pemasukan->jumlah}}</td>
                    <td>{{$pemasukan->tanggal}}</td>
                 </tr>
                 @endforeach
                 @foreach($transaksi_siswa as $index => $trans)
                    <tr>
                        <td>{{$loop->iteration + count($pemasukanArray)}}</td>
                        <td>{{ $trans->trans_name }}</td>
                        <td>
                            @if($index === count($transaksi_siswa) - 1)
                                {{ $totalJumlahSemuaTransaksi }}
                            @else
                                {{ $trans->jumlah }}
                            @endif
                        </td>
                        <td></td>
                    </tr>
                @endforeach
                    <tr class="yellow-row">
                       <td></td>
                       <td>SPP</td>
                       <td>{{$totalSPP}}</td>
                       <td></td>
                    </tr>
                  </tbody>
            </table>
        </div>
        <div class="card-footer">
            <div class="form-group">
                <label for=""><h4>Total :</h4></label>
                <h4>Rp. {{ number_format($totalPemasukan, 2, ',', '.') }}</h4>
            </div>
        </div>
    </div>
</div>