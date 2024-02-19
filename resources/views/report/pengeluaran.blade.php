<table id="example4" class="table table-bordered table-striped">
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
        @foreach($savingKeluar as $saving)
        <tr>
            <td>{{$counter}}</td>
            <td>{{$saving->created_at}}</td>
            <td>{{$saving->desc}}</td>
            <td>{{$saving->jumlah_km}}</td>
        </tr>
        @php
            $counter++;
        @endphp
        @endforeach
        <tr>
            <td>{{$counter}}</td>
            <td>-</td>
            <td>Jumlah Keluar</td>
            <td>Rp. {{number_format ($saldoSavingKeluar),2,0}}</td>
        </tr>
    </tbody>
</table>