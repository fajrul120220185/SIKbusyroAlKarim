@extends('partial.main')
@section('custom_styles')
<style>

</style>

@endsection
@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
                <button type="button" class="btn btn-outline-info" data-toggle="modal" data-target="#modal-manual">
               Tambah Siswa
                </button>
                <!-- <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#modal-excel">
                Input Excel
                </button> -->
        </div>
        <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th></th>
                    <th>Nama</th>
                    <th>NIS</th>
                    <th>Angkatan</th>
                    <th></th>
                    <!-- <th>Action</th> -->
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($siswa as $siswa)
                 <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$siswa->name}}</td>
                    <td>{{$siswa->nis}}</td>
                    <td>{{$siswa->angkatan}}</td>
                    <td>
                    <!-- <button type="button" class="btn btn-outline-warning Edit"  data-id="{{$siswa->id}}"> Move</i></button> -->
                    </td>
                 </tr>
                 @endforeach
                  </tbody>
                  <tfoot>
                  <tr>
                    <th></th>
                    <th>Nama</th>
                    <th>NIS</th>
                    <th>Angkatan</th>
                    <!-- <th></th> -->
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
                    <select class="form-control select2" multiple="multiple" data-placeholder="Pilih" id="id" data-dropdown-css-class="select2-purple" style="width: 100%;">
                     @foreach($addSiswa as $siswa)
                        <option value="{{$siswa->id}}">{{$siswa->name}} -- {{$siswa->nis}}</option>
                     @endforeach
                    </select>    
                    <input type="hidden" name="" id="kelas" value="{{$id}}">           
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


      <div class="modal fade" id="EditModal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Pindah Kelas</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">Kelas</label>
                   <select id="kelas_edit" class="form-control" style="width: 100%;">
                    @foreach($kelas as $kel)
                      <option value="{{$kel->kelas}}">{{$kel->kelas}}</option>
                    @endforeach
                    <option value="lulus">Lulus</option>
                   </select>
                   <input type="hidden" id="id_siswa">
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
            'id': $('#id').val(),
            'kelas': $('#kelas').val(),
            
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
                    url: "{{ route('addSiswa') }}",
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
            'id': $('#id_siswa').val(),
            'kelas': $('#kelas_edit').val(),
            
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
                    url: "{{ route('moveSiswa') }}",
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
            url: '/master/siswa/edit-' + id,
            cache: false,
            data: {
                id: id
            },
            dataType: 'json',
            success: function(response) {
                console.log(response);
                $('#EditModal').modal('show');
                $('#EditModal #id_siswa').val(response.data.id);
     
               
    
            },
            error: function(data) {
                console.log('error:', data);
            }
        });
    });
});
</script>

@endsection