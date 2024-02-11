<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tagihan</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
        }

        .container {
            max-width: 16000px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo {
            width: 100px; /* Adjust the width as needed */
            height: auto;
        }

        .judul {
            font-size: 24px;
            font-weight: bold;
        }

        .content {
    margin: 0 auto; /* Membuat konten berada di tengah */
    width: fit-content; /* Menyesuaikan lebar konten dengan isi tabel */
}

table {
    width: 100%; /* Melebar sepanjang lebar konten */
    border-collapse: collapse; /* Menggabungkan garis tepi sel */
    table-layout: fixed; /* Membuat tabel memiliki lebar tetap */
}

table, th, td {
    border: 1px solid #ddd; /* Tambahkan garis tepi untuk sel */
    text-align: center; /* Pusatkan teks dalam sel */
}

th, td {
    padding: 8px; /* Tambahkan padding untuk isi sel */
    width: 33.33%; /* Atur lebar relatif untuk setiap kolom */
}

    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <img src="{{asset('image/busyro.jpeg')}}" alt="Logo" class="logo">
        <div class="judul">Kwitansi Pembayaran</div>
        <br>
        <hr>
        <span>Diterima dari : {{$siswa->name}} -- {{$siswa->kelas}}{{$siswa->grade}}</span>
        <br>
        <span>{{$siswa->nis}}</span>
        
    </div>

    <hr>
    <br>
    <div class="content">
        <div class="row">
            <div class="col-6">
            @if($kegiatan != null)
            <h4>Jenis Pembayaran</h4>
                <table>
                    <thead>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Sudah Bayar</th>
                        <th>Status</th>
                        <th>Bayar Pada</th>
                    </thead>
                    <tbody>
                        @foreach($kegiatan as $keg)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$keg->trans_name}}</td>
                            <td>{{$keg->jumlah}}</td>
                            @if($keg->lunas === "Y")
                            <td>Lunas</td>
                            @else
                            <td>Belum Lunas</td>
                            @endif
                            <td>{{$keg->paid_at}}</td>

                        </tr>
                        @endforeach
                        <tr>
                            <td></td>
                            <td><h4>Total</h4></td>
                            <td><h4>Rp. {{ number_format($harusBayarKegiatan, 2, ',', '.') }}</h4></td>
                        </tr>
                    </tbody>
                </table>
                @endif
            </div>
            <div class="col-6">
            @if($spp != null)
            <h4>Pembayaran SPP</h4>
                <table>
                    <thead>
                        <th>No</th>
                        <th>Bulan</th>
                        <th>Tahun</th>
                        <th>Jumlah</th>
                    </thead>
                    <tbody>
                        @foreach($spp as $keg)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$keg->bulan}}</td>
                            <td>{{$keg->tahun}}</td>
                            <td>Lunas</td>
                        </tr>
                        @endforeach
                        <tr>
                            <td></td>
                            <td><h4>Total Bayar</h4></td>
                            <td></td>
                            <td><h4>Rp. {{ number_format($harusBayarSpp, 2, ',', '.') }}</h4></td>
                        </tr>
                    </tbody>
                </table>
                @endif
            </div>
        </div>
        <br>
        <hr>
        <h4> Total Bayar : Rp. {{ number_format($harusBayarTotal, 2, ',', '.') }}</h4>
    </div>
</div>

</body>
</html>
