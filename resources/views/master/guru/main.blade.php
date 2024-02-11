@extends('partial.main')
@section('content')

<div class="container-fluid">
    <div class="card">
        <div class="card-header">
                <button type="button" class="btn btn-outline-info" data-toggle="modal" data-target="#modal-manual">
               Tambah Manual
                </button>
                <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#modal-excel">
                Input Excel
                </button>
        </div>
        <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th></th>
                    <th>Nama</th>
                    <th>No Hp</th>
                    <th>Gaji</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($guru as $guru)
                 <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$guru->name}}</td>
                    <td>{{$guru->no_hp}}</td>
                    <td>{{$guru->gaji}}</td>
                    <td>
                        <button type="button" class="btn btn-outline-warning Edit"  data-id="{{$guru->id}}"> <i class="fas fa-edit"></i></button>
                        <button type="button" class="btn btn-outline-danger Delete"  data-id="{{$guru->id}}"> <i class="fas fa-trash"></i></button>
                    </td>
                 </tr>
                 @endforeach
                  </tbody>
                  <tfoot>
                  <tr>
                    <th></th>
                    <th>Nama</th>
                    <th>No Hp</th>
                    <th>Gaji</th>
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
              <h4 class="modal-title">Tambah Guru</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">Nama</label>
                    <input type="text" class="form-control" id="name">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">No Handphone</label>
                    <input type="text" class="form-control" id="no_hp">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Gaji</label>
                    <div class="input-group">
                    <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fas fa-dollar-sign"></i>
                    </span>
                  </div>
                        <input type="number" class="form-control" id="Gaji">
                    </div>
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


      <!-- Excel -->
      <div class="modal fade" id="modal-excel">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Upload Data Guru</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="{{ url('/master/guru/excel')}}" method="post" enctype="multipart/form-data">
                @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">File</label>
                    <div class="input-group">
                    <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fas fa-file"></i>
                    </span>
                  </div>
                        <input type="file" class="form-control" name="file">
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
            </form>
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
              <h4 class="modal-title">Edit Guru</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">Nama</label>
                    <input type="text" class="form-control" id="name_edit">
                    <input type="hidden" class="form-control" id="id">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">No Handphone</label>
                    <input type="text" class="form-control" id="no_hp_edit">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Gaji</label>
                    <div class="input-group">
                    <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fas fa-dollar-sign"></i>
                    </span>
                  </div>
                        <input type="number" class="form-control" id="gaji_edit">
                    </div>
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
            'name': $('#name').val(),
            'no_hp': $('#no_hp').val(),
            'gaji': $('#gaji').val(),
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
                    url: "{{url('/master/guru/store')}}",
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
            'name': $('#name_edit').val(),
            'no_hp': $('#no_hp_edit').val(),
            'gaji': $('#gaji_edit').val(),
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
                    url: " {{ url('/master/guru/update') }}",
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
                    url: "{{ url('/master/guru/delete-/') }}" + id,
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
   

    $(document).on('click', '.Edit', function() {
        let id = $(this).data('id');
        $.ajax({
            type: 'GET',
            url: " {{ url('/master/guru/edit-/')}}" + id,
            cache: false,
            data: {
                id: id
            },
            dataType: 'json',
            success: function(response) {
                console.log(response);
                $('#EditModal').modal('show');
                $('#EditModal #id').val(response.data.id);
                $('#EditModal #name_edit').val(response.data.name);
                $('#EditModal #no_hp_edit').val(response.data.no_hp);
                $('#EditModal #gaji_edit').val(response.data.gaji);
               
    
            },
            error: function(data) {
                console.log('error:', data);
            }
        });
    });
});
</script>
@endsection