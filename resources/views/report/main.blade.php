@extends('partial.main')

@section('custom_style')

@endsection
@section('content')

<div class="container-fluid">
    <div class="card mx-auto">
        <div class="card-header">
            <div class="col-12">
                <div class="card mx-auto">
                    <div class="card-header">
                        <h4>Pilih Tanggal</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-9">
                                <div class="input-group align-center">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text">
                                      <i class="far fa-calendar-alt"></i>
                                    </span>
                                  </div>
                                  <input type="text" class="form-control float-right" value="{{ $formattedStartDate }} - {{ $formattedEndDate }}" id="reservation">
                                </div>
                            </div>
                            <div class="col-3 align-self-end">
                                <div class="form-group">
                                    <button type="button" class="btn btn-outline-info Report"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    @include('report.pemasukan')
                </div>
                <div class="col-6">
                    @include('report.pengeluaran')
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="container">
                    <div class="row p-3">
                      <div class="col-xs-12 col-6">
                        <p>Total      : </p>
                        <p>Saldo Sebelumnya  : </p>
                        <p>Grand Saldo: </p>
                      </div>
                      <div class="col-xs-12 col-6" style="text-align: right;">
                        <p><strong>Rp.  {{ number_format($totalTrans, 0, ',', '.') }},00 ~</strong></p>
                        <p><strong>Rp. {{ number_format($totalSebelumnya, 0, ',', '.') }},00 ~</strong></p>
                            <p><strong>Rp.  {{ number_format($GS->saldo, 0, ',', '.') }} ,00 ~</strong></p>

                      </div>
                      <div class="col-12">
                        <p>Terbilang <strong> "{{$terbilang}} Rupiah"</strong></p>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('custom_js')
<script>
    $(document).ready(function () {
        $('.Report').click(function () {
            var dateRange = $('#reservation').val();
            var dates = dateRange.split(' - ');

            var startDate = formatDate(dates[0]);
            var endDate = formatDate(dates[1]);

            // Now you can use startDate and endDate in your logic or navigation
            window.location.href = "{{ url('/report/') }}" + '/' + startDate + '/' + endDate;
        });

        function formatDate(dateString) {
            // Convert date from MM/DD/YYYY to YYYY-MM-DD
            var parts = dateString.split('/');
            return parts[2] + '-' + parts[0] + '-' + parts[1];
        }
    });

</script>



@endsection