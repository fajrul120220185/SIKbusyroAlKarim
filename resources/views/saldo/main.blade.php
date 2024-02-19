@extends('partial.main')
@section('content')

<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h4>Hi {{$user}}, Nice to Meet You</h4>
        </div>
        <div class="card-body">
            <!-- Saving -->
            <div class="row">
                <div class="col-4">
                    <div class="form-group">
                        <label for="">Saldo Saving Bulan Lalu</label>
                        <input type="text" class="form-control" value="Rp. {{number_format ($saldoSavingKemarin),2,0}}" readonly>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="">Saldo Saving Saat Ini</label>
                        <input type="text" class="form-control" value=" Rp. {{number_format ($saldoSaving),2,0}}" readonly>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="">Action</label>
                        <div class="d-flex">
                            <button class="btn btn-outline-success mr-2" data-toggle="modal" data-target="#saldoSaving">Input Saldo</button>
                            <form action="{{ route('trackingSaldo')}}" method="get">
                                <input type="hidden" name="tujuanTracking" value="Saving">
                                <button type="submit" class="btn btn-outline-info">Tracking</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- SPP -->
            <div class="row">
                <div class="col-4">
                    <div class="form-group">
                        <label for="">Saldo SPP Bulan Lalu</label>
                        <input type="text" class="form-control" value=" Rp. {{number_format ($saldoSPPKemarin),2,0}}" readonly>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="">Saldo SPP Saat Ini</label>
                        <input type="text" class="form-control" value=" Rp. {{number_format ($saldoSpp),2,0}}" readonly>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="">Action</label>
                        <div class="d-flex">
                            <button class="btn btn-outline-success mr-2" data-toggle="modal" data-target="#saldoSpp">Input Saldo</button>
                            <form action="{{ route('trackingSaldo')}}" method="get">
                                <input type="hidden" name="tujuanTracking" value="SPP">
                                <button type="submit" class="btn btn-outline-info">Tracking</button>
                            </form>   
                        </div>
                    </div>
                </div>
            </div>
            <!-- BOS -->
            <div class="row">
                <div class="col-4">
                    <div class="form-group">
                        <label for="">Saldo BOS Bulan Lalu</label>
                        <input type="text" class="form-control" value="Rp. {{number_format ($saldoBOSKemarin),2,0}}" readonly>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="">Saldo BOS Saat Ini</label>
                        <input type="text" class="form-control" value=" Rp. {{number_format ($saldoBos),2,0}}" readonly>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="">Action</label>
                        <div class="d-flex">
                            <button class="btn btn-outline-success mr-2" data-toggle="modal" data-target="#saldoBos">Input Saldo</button>
                            <form action="{{ route('trackingSaldo')}}" method="get">
                                <input type="hidden" name="tujuanTracking" value="BOS">
                                <button type="submit" class="btn btn-outline-info">Tracking</button>
                            </form>                       
                         </div>
                    </div>
                </div>
            </div>
            <!-- Ekskul -->
            <div class="row">
                <div class="col-4">
                    <div class="form-group">
                        <label for="">Saldo Ekskul Bulan Lalu</label>
                        <input type="text" class="form-control" value="Rp. {{number_format ($saldoEkskulKemarin),2,0}}" readonly>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="">Saldo Ekskul Saat Ini</label>
                        <input type="text" class="form-control" value=" Rp. {{number_format ($saldoEkskul),2,0}}" readonly>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="">Action</label>
                        <div class="d-flex">
                            <button class="btn btn-outline-success mr-2" data-toggle="modal" data-target="#saldoEkskul">Input Saldo</button>
                            <form action="{{ route('trackingSaldo')}}" method="get">
                                <input type="hidden" name="tujuanTracking" value="Ekskul">
                                <button type="submit" class="btn btn-outline-info">Tracking</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="inputSaldo">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Saldo SPP Modal</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('InputSaldo')}}" method="post">
        @csrf
      <div class="modal-body">
        <div class="card">
          <div class="card-body">
            <div class="form-group">
              <label for="">Input Saldo Awal</label>
              <input type="number"  name="saldo" class="form-control">
              <input type="hiden" name="tujuan" id="tujuan"  class="form-control">
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Accept</button>
      </div>
    </div>
    </form>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
@include('saldo.modal-password')
@endsection

@section('custom_js')

<script>
    $(document).on('click', '.loginSPP', function(e) {
        e.preventDefault();
        var data = {
            'password': $('#pass-SPP').val(),   
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        Swal.fire({
            title: 'Are you Sure?',
            text: "Data will be store",
            icon: 'warning',
            showDenyButton: false,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Confirm',
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {

                $.ajax({
                    type: 'GET',
                    url: " {{ url('/saldo-awal/spp-password')}}",
                    data: data,
                    cache: false,
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                            if (response.success) {
                              Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                              })
                              .then(() => {
                                 $('#saldoSpp').modal('hide');
                                 $('#inputSaldo').modal('show');
                                 $('#inputSaldo #tujuan').val('SPP');
                                });
                            } else {
                              Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message,
                              });
                            }

                    },
                    error: function(response) {
                        var errors = response.responseJSON.errors;
                        if (errors) {
                            var errorMessage = '';
                            $.each(errors, function(key, value) {
                                errorMessage += value[0] + '<br>';
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Validation Error',
                                text: response.message,
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message,
                              });
                        }
                    },
                });

            } else if (result.isDenied) {
                Swal.fire('Changes are not saved', '', 'info')
            }


        })

    });


    // Bos
    $(document).on('click', '.loginBOS', function(e) {
        e.preventDefault();
        var data = {
            'password': $('#pass-BOS').val(),   
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        Swal.fire({
            title: 'Are you Sure?',
            text: "Data will be store",
            icon: 'warning',
            showDenyButton: false,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Confirm',
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {

                $.ajax({
                    type: 'GET',
                    url: " {{ url('/saldo-awal/spp-password')}}",
                    data: data,
                    cache: false,
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                            if (response.success) {
                              Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                              })
                              .then(() => {
                                 $('#saldoBos').modal('hide');
                                 $('#inputSaldo').modal('show');
                                 $('#inputSaldo #tujuan').val('BOS');
                                });
                            } else {
                              Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message,
                              });
                            }

                    },
                    error: function(response) {
                        var errors = response.responseJSON.errors;
                        if (errors) {
                            var errorMessage = '';
                            $.each(errors, function(key, value) {
                                errorMessage += value[0] + '<br>';
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Validation Error',
                                text: response.message,
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message,
                              });
                        }
                    },
                });

            } else if (result.isDenied) {
                Swal.fire('Changes are not saved', '', 'info')
            }


        })

    });



    // Ekskul
    $(document).on('click', '.loginEkskul', function(e) {
        e.preventDefault();
        var data = {
            'password': $('#pass-Ekskul').val(),   
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        Swal.fire({
            title: 'Are you Sure?',
            text: "Data will be store",
            icon: 'warning',
            showDenyButton: false,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Confirm',
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {

                $.ajax({
                    type: 'GET',
                    url: " {{ url('/saldo-awal/spp-password')}}",
                    data: data,
                    cache: false,
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                            if (response.success) {
                              Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                              })
                              .then(() => {
                                 $('#saldoEkskul').modal('hide');
                                 $('#inputSaldo').modal('show');
                                 $('#inputSaldo #tujuan').val('Ekskul');
                                });
                            } else {
                              Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message,
                              });
                            }

                    },
                    error: function(response) {
                        var errors = response.responseJSON.errors;
                        if (errors) {
                            var errorMessage = '';
                            $.each(errors, function(key, value) {
                                errorMessage += value[0] + '<br>';
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Validation Error',
                                text: response.message,
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message,
                              });
                        }
                    },
                });

            } else if (result.isDenied) {
                Swal.fire('Changes are not saved', '', 'info')
            }


        })

    });

    // Saving

    $(document).on('click', '.loginSaving', function(e) {
        e.preventDefault();
        var data = {
            'password': $('#pass-Saving').val(),   
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        Swal.fire({
            title: 'Are you Sure?',
            text: "Data will be store",
            icon: 'warning',
            showDenyButton: false,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Confirm',
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {

                $.ajax({
                    type: 'GET',
                    url: " {{ url('/saldo-awal/spp-password')}}",
                    data: data,
                    cache: false,
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                            if (response.success) {
                              Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                              })
                              .then(() => {
                                 $('#saldoSaving').modal('hide');
                                 $('#inputSaldo').modal('show');
                                 $('#inputSaldo #tujuan').val('Saving');
                                });
                            } else {
                              Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message,
                              });
                            }

                    },
                    error: function(response) {
                        var errors = response.responseJSON.errors;
                        if (errors) {
                            var errorMessage = '';
                            $.each(errors, function(key, value) {
                                errorMessage += value[0] + '<br>';
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Validation Error',
                                text: response.message,
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message,
                              });
                        }
                    },
                });

            } else if (result.isDenied) {
                Swal.fire('Changes are not saved', '', 'info')
            }


        })

    });
</script>
@endsection