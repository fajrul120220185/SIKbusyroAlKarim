@extends('partial.main')
@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
                <button type="button" class="btn btn-outline-info" data-toggle="modal" data-target="#modal-manual">
               Create Pengeluaran
                </button>
        </div>
        <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th></th>
                    <th>Transaksi</th>
                    <th>Deskrisi</th>
                    <th>Nominal</th>
                    <th>Bukti</th>
                    <th>Tanggal</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($pemasukan as $pemasukan)
                 <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$pemasukan->transaksi}}</td>
                    <td>                    <textarea class="form-control" rows="3" readonly>{{$pemasukan->desc}}</textarea></td>
                    <td>{{$pemasukan->jumlah}}</td>
                    <td>
                    <img src="{{ asset('/uploads/pemasukan/' . $pemasukan->bukti) }}" alt=""  width="70" height="70"><br>    
                    </td>
                    <td>{{$pemasukan->tanggal}}</td>
                    <td>
                    <button type="button" class="btn btn-outline-warning Edit"  data-id="{{$pemasukan->id}}"> <i class="fas fa-edit"></i></button>
                        <button type="button" class="btn btn-outline-danger Delete"  data-id="{{$pemasukan->id}}"> <i class="fas fa-trash"></i></button>
                    </td>
                 </tr>
                 @endforeach
                  </tbody>
                  <tfoot>
                  <tr>
                    <th></th>
                    <th>Transaksi</th>
                    <th>Deskripsi</th>
                    <th>Nominal</th>
                    <th>Bukti</th>
                    <th>Tanggal</th>
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
              <h4 class="modal-title">Pemasukan Form</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">Transaksi</label>
                    <select class="select2" data-placeholder="Pilih" id="transaksi" data-dropdown-css-class="select2-purple" style="width: 100%;">
                     @foreach($transaksi as $trans)
                        <option value="{{$trans->id}}">{{$trans->nama}}</option>
                     @endforeach
                    </select>             
                 </div>
                 <div class="form-group">
                    <label for="exampleInputEmail1">Deskripsi</label>
                    <textarea class="form-control" rows="3" id="desc" placeholder="Enter ..."></textarea>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Nominal</label>
                    <input type="number" class="form-control" id="jumlah" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Bukti</label>
                    <input type="file" class="form-control" id="bukti">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Tanggal</label>
                    <input type="datetime-local" class="form-control" id="tanggal" required>
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
              <h4 class="modal-title">Edit Transaksi</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">Transaksi</label>
                    <select class="select2" data-placeholder="Pilih" id="transaksiEdit" data-dropdown-css-class="select2-purple" style="width: 100%;">
                     @foreach($transaksi as $trans)
                        <option value="{{$trans->id}}">{{$trans->nama}}</option>
                     @endforeach
                    </select>             
                 </div>
                 <div class="form-group">
                    <label for="exampleInputEmail1">Deskripsi</label>
                    <textarea class="form-control" rows="3" id="descEdit" placeholder="Enter ..."></textarea>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Nominal</label>
                    <input type="number" class="form-control" id="jumlahEdit" required>
                    <input type="hidden" id="id">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Bukti</label>
                    <input type="file" class="form-control" id="buktiEdit">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Tanggal</label>
                    <input type="datetime-local" class="form-control" id="tanggalEdit" required>
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
        var id_transaksi = $('#transaksi').val();
        var jumlah = $('#jumlah').val();
        var tanggal = $('#tanggal').val();
        var desc = $('#desc').val();
        var fileInput = document.getElementById('bukti'); // Mengambil elemen input file
        var bukti = fileInput.files[0]; 
        var formData = new FormData();
            formData.append('id_transaksi', id_transaksi);
            formData.append('jumlah', jumlah);
            formData.append('tanggal', tanggal);
            formData.append('desc', desc);
            formData.append('bukti', bukti);
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
                    url: " {{ url('/transaksi/pemasukan/post')}}",
                    data: formData,
                    cache: false,
                    contentType: false, // Set contentType ke false
                    processData: false, // Set processData ke false
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
        var id = $('#id').val();
        var id_transaksi = $('#transaksiEdit').val();
        var jumlah = $('#jumlahEdit').val();
        var tanggal = $('#tanggalEdit').val();
        var desc = $('#descEdit').val();
        var fileInput = document.getElementById('buktiEdit'); // Mengambil elemen input file
        var bukti = fileInput.files[0]; 
        var formData = new FormData();
            formData.append('id', id);
            formData.append('id_transaksi', id_transaksi);
            formData.append('jumlah', jumlah);
            formData.append('tanggal', tanggal);
            formData.append('desc', desc);
            formData.append('bukti', bukti);
        
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
                    url: " {{ url('/transaksi/pemasukan/update')}}",
                    data: formData,
                    cache: false,
                    contentType: false, // Set contentType ke false
                    processData: false, // Set processData ke false
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
                    url: " {{ url('/transaksi/pemasukan/delete-/')}}" + id,
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
    $('#transaksiEdit').select2(); // Inisialisasi ulang Select2
});

   

    $(document).on('click', '.Edit', function() {
        let id = $(this).data('id');
        $.ajax({
            type: 'GET',
            url: " {{ url('/transaksi/pemasukan/edit-/')}}" + id,
            cache: false,
            data: {
                id: id
            },
            dataType: 'json',
            success: function(response) {
                console.log(response);
                $('#EditModal').modal('show');
                $('#EditModal #id').val(response.data.id);
                $('#EditModal #transaksiEdit').val(response.data.id_transaksi);
                $('#EditModal #jumlahEdit').val(response.data.jumlah);
                $('#EditModal #tanggalEdit').val(response.data.tanggal);
                $('#EditModal #descEdit').val(response.data.desc);
            },
            error: function(data) {
                console.log('error:', data);
            }
        });
    });
});
</script>
@endsection
