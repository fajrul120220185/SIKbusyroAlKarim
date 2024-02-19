<table id="example3" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Uraian</th>
            <th>Jumlah</th>
        </tr>
    </thead>
    <tbody>
        @php
            $counter = 1;
        @endphp
        <tr>
            <td>{{$counter}}</td>
            <td>-</td>
            <td>Saldo Bulan Lalu ({{$bulanLalu}})</td>
            <td>Rp. {{number_format ($saldoAwalSaving),2,0}}</td>
        </tr>
        @foreach($savingMasuk as $saving)
        <tr>
            <td>{{$counter + 1}}</td>
            <td>{{$saving->created_at}}</td>
            <td>{{$saving->desc}}</td>
            <td>Rp. {{number_format ($saving->jumlah_km),2,0}}</td>
        </tr>
        @php
            $counter++;
        @endphp
        @endforeach
        <tr>
            <td>{{$counter +1}}</td>
            <td>-</td>
            <td>Jumlah Masuk</td>
            <td>Rp. {{number_format ($saldoSavingMasuk),2,0}}</td>
        </tr>
    </tbody>
</table>