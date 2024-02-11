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
                    <th>NIS</th>
                    <th>KELAS</th>
                    <th>Angkatan</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($siswa as $siswa)
                 <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$siswa->name}}</td>
                    <td>{{$siswa->nis}}</td>
                    <td>{{$siswa->kelas}}{{$siswa->grade}}</td>
                    <td>{{$siswa->angkatan}}</td>
                    <td>
                    <button type="button" class="btn btn-outline-warning Edit"  data-id="{{$siswa->id}}"> <i class="fas fa-edit"></i></button>
                        <button type="button" class="btn btn-outline-danger Delete"  data-id="{{$siswa->id}}"> <i class="fas fa-trash"></i></button>
                    </td>
                 </tr>
                 @endforeach
                  </tbody>
                  <tfoot>
                  <tr>
                    <th></th>
                    <th>Nama</th>
                    <th>NIS</th>
                    <th>KELAS</th>
                    <th>Angkatan</th>
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
              <h4 class="modal-title">Tambah Siswa</h4>
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
                    <label for="exampleInputEmail1">NIS</label>
                    <input type="text" class="form-control" id="nis">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Alamat</label>
                    <input type="text" class="form-control" id="alamat">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Nama Orang Tua</label>
                    <input type="text" class="form-control" id="name_ortu">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Nomor HP Orang Tua</label>
                    <input type="text" class="form-control" id="no_ortu">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Angkatan</label>
                    <input type="number" class="form-control" id="angkatan">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Kelas</label>
                   <select id="kelas" class="form-control" style="width: 100%;">
                    @foreach($kelas as $kel)
                      <option value="{{$kel->id}}">{{$kel->kelas}}{{$kel->grade}}</option>
                    @endforeach
                   </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Yatim</label>
                   <select id="yatim" class="form-control" style="width: 100%;">
                    <option value="Y">Y</option>
                    <option value="N">N</option>
                   </select>
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
              <h4 class="modal-title">Upload Data Siswa</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="{{ url('/master/siswa/excel')}}" method="post" enctype="multipart/form-data">
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


      <!-- edit -->
      <div class="modal fade" id="EditModal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Edit Data Siswa</h4>
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
                    <label for="exampleInputEmail1">NIS</label>
                    <input type="text" class="form-control" id="nis_edit">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Alamat</label>
                    <input type="text" class="form-control" id="alamat_edit">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Nama Orang Tua</label>
                    <input type="text" class="form-control" id="name_ortu_edit">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Nomor HP Orang Tua</label>
                    <input type="text" class="form-control" id="no_ortu_edit">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Angkatan</label>
                    <input type="number" class="form-control" id="angkatan_edit">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Kelas</label>
                   <select id="kelas_edit" class="form-control" style="width: 100%;">
                    @foreach($kelas as $kel)
                      <option value="{{$kel->id}}">{{$kel->kelas}}{{$kel->grade}}</option>
                    @endforeach
                   </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Yatim</label>
                   <select id="yatim_edit" class="form-control" style="width: 100%;">
                    <option value="Y">Y</option>
                    <option value="N">N</option>
                   </select>
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
            'nis': $('#nis').val(),
            'name': $('#name').val(),
            'alamat': $('#alamat').val(),
            'name_ortu': $('#name_ortu').val(),
            'no_ortu': $('#no_ortu').val(),
            'angkatan': $('#angkatan').val(),
            'kelas': $('#kelas').val(),
            'yatim': $('#yatim').val(),
            
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
                    url: " {{ url('/master/siswa/store')}}",
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
            'nis': $('#nis_edit').val(),
            'name': $('#name_edit').val(),
            'alamat': $('#alamat_edit').val(),
            'name_ortu': $('#name_ortu_edit').val(),
            'no_ortu': $('#no_ortu_edit').val(),
            'angkatan': $('#angkatan_edit').val(),
            'kelas': $('#kelas_edit').val(),
            'yatim': $('#yatim_edit').val(),
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
                    url: " {{ url('/master/siswa/update')}}",
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
                    url: " {{ url('/master/siswa/delete-/')}}" + id,
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
            url: " {{ url('/master/siswa/edit-/')}}" + id,
            cache: false,
            data: {
                id: id
            },
            dataType: 'json',
            success: function(response) {
                console.log(response);
                $('#EditModal').modal('show');
                $('#EditModal #id').val(response.data.id);
                $('#EditModal #nis_edit').val(response.data.nis);
                $('#EditModal #name_edit').val(response.data.name);
                $('#EditModal #alamat_edit').val(response.data.alamat);
                $('#EditModal #name_ortu_edit').val(response.data.name_ortu);
                $('#EditModal #no_ortu_edit').val(response.data.no_ortu);
                $('#EditModal #angkatan_edit').val(response.data.angkatan);
                $('#EditModal #kelas_edit').val(response.data.kelas_id);
                $('#EditModal #yatim_edit').val(response.data.yatim);
               
    
            },
            error: function(data) {
                console.log('error:', data);
            }
        });
    });
});
</script>
@endsection