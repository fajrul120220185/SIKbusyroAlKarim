@extends('partial.main')

@section('content')

<div class="container-fluid">
    <div class="card">
        <div class="card-header">
                <button type="button" class="btn btn-outline-info" data-toggle="modal" data-target="#modal-manual">
               Tambah Manual
                </button>
        </div>
        <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th></th>
                    <th>Kelas</th>
                    <th>Wali Kelas</th>
                    <th>Tarif SPP</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($kelas as $kelas)
                 <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$kelas->kelas}}{{$kelas->grade}}</td>
                    <td>{{$kelas->walikelas}}</td>
                    <td>Rp. {{ number_format($kelas->tarif_spp, 2, ',', '.') }}</td>
                    <td>
                        <button type="button" class="btn btn-outline-warning Edit"  data-id="{{$kelas->id}}"> <i class="fas fa-edit"></i></button>
                        <button type="button" class="btn btn-outline-danger Delete"  data-id="{{$kelas->id}}"> <i class="fas fa-trash"></i></button>
                    </td>
                 </tr>
                 @endforeach
                  </tbody>
                  <tfoot>
                  <tr>
                    <th></th>
                    <th>Kelas</th>
                    <th>Wali Kelas</th>
                    <th></th>
                  </tr>
                  </tfoot>
                </table>
        </div>
    </div>
</div>


<div class="modal fade" id="modal-manual">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Tambah Kelas</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">Kelas</label>
                    <input type="text" class="form-control" id="kelas">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Wali Kelas</label>
                    <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" id="id_guru" style="width: 100%;">
                    <option value="" disabled="disabled">Pilih Satu !</option>
                    @foreach($guru as $gur)
                        <option value="{{$gur->id}}">{{$gur->name}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Tarif SPP</label>
                    <input type="number" class="form-control" id="tarif_spp">
                </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary SaveManual">Save</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>


      <!-- Edit -->

      <div class="modal fade" id="EditModal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Edit Kelas</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">Kelas</label>
                    <input type="text" class="form-control" id="kelas_edit">
                    <input type="hidden" class="form-control" id="id">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Wali Kelas</label>
                    <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" id="id_guru_edit" style="width: 100%;">
                    <option value="" disabled="disabled">Pilih Satu !</option>
                    @foreach($guru as $guru)
                        <option value="{{$guru->id}}">{{$guru->name}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Tarif SPP</label>
                    <input type="number" class="form-control" id="tarif_sppEdit">
                </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary Update">Save</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

@endsection

@section('custom_js')
<script>
    $(document).on('click', '.SaveManual', function(e) {
        e.preventDefault();
        var data = {
            'kelas': $('#kelas').val(),
            'id_guru': $('#id_guru').val(),
            'tarif_spp': $('#tarif_spp').val(),
   
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
                    type: 'POST',
                    url: " {{ url('/master/kelas/store')}}",
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
            // Memuat ulang halaman setelah berhasil menyimpan data
            window.location.reload();
        }).then(() => {
            // Buka modal "success" setelah halaman dimuat ulang
            $('#success').modal('show');
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
                                html: errorMessage,
                            });
                        } else {
                            console.log('error:', response);
                        }
                    },
                });

            } else if (result.isDenied) {
                Swal.fire('Changes are not saved', '', 'info')
            }


        })

    });

    

    $(document).on('click', '.Update', function(e) {
        e.preventDefault();
        var data = {
            'id': $('#id').val(),
            'kelas': $('#kelas_edit').val(),
            'id_guru': $('#id_guru_edit').val(),
            'tarif_spp': $('#tarif_sppEdit').val(),
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        Swal.fire({
            title: 'Are you Sure?',
            text: "Data will be update!",
            icon: 'warning',
            showDenyButton: false,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Confirm',
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {

                $.ajax({
                    type: 'POST',
                    url: " {{ url('/master/kelas/update')}}",
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
            // Memuat ulang halaman setelah berhasil menyimpan data
            window.location.reload();
        }).then(() => {
            // Buka modal "success" setelah halaman dimuat ulang
            $('#success').modal('show');
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
                                html: errorMessage,
                            });
                        } else {
                            console.log('error:', response);
                        }
                    },
                });

            } else if (result.isDenied) {
                Swal.fire('Changes are not saved', '', 'info')
            }


        })

    });


    // delete
    $(document).on('click', '.Delete', function(e) {
        e.preventDefault();
        let id = $(this).data('id');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        Swal.fire({
            title: 'Are you Sure?',
            text: "Data will be deleted",
            icon: 'warning',
            showDenyButton: false,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Confirm',
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {

                $.ajax({
                    type: 'POST',
                    url: " {{ url('/master/kelas/delete-/')}}" + id,
                    data: {id:id},
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
            // Memuat ulang halaman setelah berhasil menyimpan data
            window.location.reload();
        }).then(() => {
            // Buka modal "success" setelah halaman dimuat ulang
            $('#success').modal('show');
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
                                html: errorMessage,
                            });
                        } else {
                            console.log('error:', response);
                        }
                    },
                });

            } else if (result.isDenied) {
                Swal.fire('Changes are not saved', '', 'info')
            }


        })

    });

</script>

<script>
     $(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).on('shown.bs.modal', '#EditModal', function() {
    $('#id_guru_edit').select2(); // Inisialisasi ulang Select2
});

   

    $(document).on('click', '.Edit', function() {
        let id = $(this).data('id');
        $.ajax({
            type: 'GET',
            url: " {{ url('/master/kelas/edit-/')}}" + id,
            cache: false,
            data: {
                id: id
            },
            dataType: 'json',
            success: function(response) {
                console.log(response);
                $('#EditModal').modal('show');
                $('#EditModal #id').val(response.data.id);
                $('#EditModal #kelas_edit').val(response.data.kelas + response.data.grade);
                $('#EditModal #id_guru_edit').val(response.data.guru_id);
                $('#EditModal #tarif_sppEdit').val(response.data.tarif_spp);
               
    
            },
            error: function(data) {
                console.log('error:', data);
            }
        });
    });
});
</script>
@endsection