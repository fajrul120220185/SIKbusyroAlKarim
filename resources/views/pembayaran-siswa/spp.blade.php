<div class="container-fluid">
    <div class="card">
        <div class="card-header text-center">
            <h4>SPP</h4>
        </div>
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th></th>
                    <th>Bulan</th>
                    <th>Tahun</th>
                    <th>Kelas</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($SPP as $sp)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$sp->bulan}}</td>
                        <td>{{$sp->tahun}}</td>
                        <td>{{$sp->kelas}}{{$sp->grade}}</td>
                        @if($sp->lunas == 'Y')
                        <td>Paid</td>
                        <td>
                        <button type="button" class="btn btn-success"  disabled="disabled">Paid</i></button>
                        </td>
                        @else
                        <td>Belum Bayar</td>
                        <td>
                        <button type="button" class="btn btn-outline-success Pay">Pay</i></button>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                  </tbody>
            </table>
        </div>
    </div>
</div>