<style>
      body {
        color: #000;
        background: #fff;
        font-size: 11px;
    }

    h3 {
        margin: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th, td {
        border: 1px solid #000;
        padding: 10px;
        text-align: center;
    }

    th {
        background-color: #f2f2f2;
    }

    span {
        font-size: 20px;
    }

    p {
        font-size: 13px;
    }
 
</style>
<div style="margin: 20px 0">
        <div style="text-align: center;margin: 0 auto;">
            
      
        <span style="font-size:20;">Pembayaran  {{$transaksiMaster->trans_name}} Kelas  </span>
        @foreach($klls as $kls)
        <span>{{$kls->kelas}}{{$kls->grade}}</span>
        @endforeach
        <br>
        <span style="font-size:22;">Rp. {{ number_format($duit, 2, ',', '.') }}</span>
                <h3 style="margin: 20px;">Laporan Pembayaran Siswa</h3>

                    <table>
                        <thead>
                            <th>No</th>
                            <th>Siswa</th>
                            <th>Status</th>
                            <th>Paid At</th>
                            <th>Lunas Pada</th>
                            <th>Jumlah</th>
                            <th>Kurang</th>
                        </thead>
                        <tbody>
                        @foreach($siswa as $sis)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$sis->siswa_name}}</td>
            @if($sis->lunas == 'Y')
            <td>Lunas</td>
            @else
            <td>Belum Lunas</td>
            @endif
            <td>{{$sis->paid_at}}</td>
            @if($sis->lunas == 'Y')
            <td>{{$sis->lunas_at}}</td>
            @else
            <td>Belum Lunas</td>
            @endif
            <td>{{$sis->jumlah}}</td>
            <td>{{$sis->kurang}}</td>

        </tr>
    @endforeach
                        </tbody>
                    </table>
              
              
               
            
          
            
        
            <p style="font-size: 13px;font-weight: bold">
                                  
            </p>
            <p style="font-size: 13px;">
                
                </p>
            

        </div>
    </div>
    <div style="display:block; page-break-before:always;"></div>
