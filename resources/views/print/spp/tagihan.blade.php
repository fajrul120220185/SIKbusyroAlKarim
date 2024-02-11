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
            max-width: 800px;
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
            /* Add your tagihan content styles here */
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <img src="{{asset('image/busyro.jpeg')}}" alt="Logo" class="logo">
        <div class="judul">Tagihan Pembayaran</div>
    </div>

    <div class="content">
        <!-- Add your tagihan content here -->
        <!-- For example, you can loop through items and display details -->
        <table>
            <thead>
                <tr>
                    <th>Keterangan :</th>
                    <th>Tagihan SPP Bulan {{$bulan}} {{$tahun}}</th>
                </tr>
                <tr>
                    <th>Untuk Siswa</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Nama</td>
                    <td>: {{$siswa->name}}</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Kelas</td>
                    <td>: {{$siswa->kelas}}</td>
                    <td></td>
                </tr>
                <tr>
                    <td>NIS</td>
                    <td>: {{$siswa->nis}}</td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
