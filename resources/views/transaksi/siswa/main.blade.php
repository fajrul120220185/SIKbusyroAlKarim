@extends('partial.main')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
             <div class="card">
                <div class="card-header">
                        <label for="selectTahun">Pilih Transaksi:</label>
                        <select class="form-control select2" data-placeholder = "Pilih Satu !" id="selectTrans" style="width: 100%;">
                        <option value="">Pilih Satu !</option>
                        @foreach ($selectId as $item)
                            <option value="{{ $item->id }}" {{ optional($transaksi)->id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                        @endforeach
                        </select>
                </div>
                <div class="card-body">
                        <table id="example3" class="table table-bordered table-striped">
                          <thead>
                          <tr>
                            <th></th>
                            <th>Nama</th>
                            <th>NIS</th>
                            <th>KELAS</th>
                            <th>Sudah di Bayar</th>
                            <th>Kurang</th>
                            <th>Action</th>
                          </tr>
                          </thead>
                          <tbody>
                           @foreach($siswa_id as $siswa)
                           <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$siswa->siswa_name}}</td>
                            <td>{{$siswa->nis}}</td>
                            <td>{{$siswa->kelas}}</td>
                            <td>{{$siswa->jumlah}}</td>
                            <td>{{$siswa->kurang}}</td>
                            <td>
                                <button type="button" class="btn btn-outline-success Bayar"  data-id="{{$siswa->siswa_id}}">Pay</button>
                                <button type="button" class="btn btn-outline-warning printBukti"  data-transis="{{ $transaksi ? $transaksi->id : ''}}" data-id="{{$siswa->siswa_id}}">Bukti</button>
                                <button type="button" class="btn btn-outline-danger cetakTgihan"  data-transis="{{ $transaksi ? $transaksi->id : ''}}" data-id="{{$siswa->siswa_id}}">Tagih</button>
                              
                            </td>
                           </tr>
                           @endforeach
                          </tbody>
                        </table>
                </div>
                <div class="card-footer">
                    <h4>Report</h4>
                    <br>
                    <div class="row">
                        <div class="col-3">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Transaksi</label>
                                    <input type="text" class="form-control" value="{{ $transaksi ? $transaksi->name : 'Pilih Transaksi Dahulu Dahulu' }}" id="transRep" readonly>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Kelas</label>
                                    <select class="form-control select2" multiple="multiple" data-placeholder="Pilih Kelas !" id="kelasRep" style="width: 100%;">                                     
                                            @foreach ($klz as $kelasItem)
                                                <option value="{{ $kelasItem->id }}">{{ $kelasItem->kelas }}{{ $kelasItem->grade }}</option>
                                            @endforeach                                   
                                    </select>
                                    <input type="hidden" id="idTransRep" value="{{ $transaksi ? $transaksi->id : '' }}">
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
</div>


<div class="modal fade" id="EditModal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Bayar</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">Nama</label>
                    <input type="text" class="form-control" id="name" readonly>
                    <input type="hidden" class="form-control" id="id">
                    <input type="hidden" id="transId" value="{{$transaksi ? $transaksi->id : '' }}">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">NIS</label>
                    <input type="text" class="form-control" id="nis" readonly>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Jumlah</label>
                    <input type="number" class="form-control" id="jumlah">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Bukti Bayar</label>
                    <input type="file" class="form-control" id="bukti">
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tanggal Bayar</label>
                            <input type="datetime-local" class="form-control" id="paid_at" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary Pay">Save</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
     
@endsection
@section('custom_js')
<script>
        $(document).ready(function () {
        $('#selectTrans').select2({
            placeholder: 'Pilih Satu !',
            width: '100%'
        });

        // Tambahkan event listener untuk perubahan nilai pada Select2
        $('#selectTrans').on('change', function () {
            var kelas = $(this).val();
            if (kelas) {
                window.location.href = " {{ url('/transaksi/siswa/')}}" + '/' + kelas;
            }
        });
    });
</script>

<script>
     $(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
   

    $(document).on('click', '.Bayar', function() {
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
                $('#EditModal #nis').val(response.data.nis);
                $('#EditModal #name').val(response.data.name);
               
    
            },
            error: function(data) {
                console.log('error:', data);
            }
        });
    });
});
</script>

<script>
    $(document).on('click', '.Pay', function(e) {
        e.preventDefault();
        var id = $('#id').val();
        var transId = $('#transId').val();
        var jumlah = $('#jumlah').val();
        var paid_at = $('#paid_at').val();
        var fileInput = document.getElementById('bukti'); // Mengambil elemen input file
        var bukti = fileInput.files[0]; 
        var formData = new FormData();
            formData.append('id', id);
            formData.append('transId', transId);
            formData.append('jumlah', jumlah);
            formData.append('paid_at', paid_at);
            formData.append('bukti', bukti);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        Swal.fire({
            title: 'Are you Sure to pay?',
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
                    url: " {{ url('/transaksi/siswa/pay')}}",
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

</script>



<script>
     $(document).on('click', '.printBukti', function(e) {
        e.preventDefault();
        let id = $(this).data('id');
        let transis = $(this).data('transis');
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        Swal.fire({
          title: 'Are you Sure?',
          text: "Ingin melihat foto?",
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
              url: " {{ url('/transaksi/siswa/bukti/')}}" + '/' + transis + '/' + id,
              data: {
                id: id,
                transis : transis,
                },
              cache: false,
              dataType: 'json',
              success: function(response) {
                console.log(response);
                if (response.success) {
                 
                    window.open("{{ url('/transaksi/siswa/print/') }}/"+response.data.id,"preview barcode","width=600,height=600,menubar=no,status=no,scrollbars=yes"); 
                           
                       
                } else {
                  Swal.fire('Error', response.message, 'error');
                }
              },
              error: function(response) {
               
              },
            });

          } else if (result.isDenied) {
            Swal.fire('Changes are not saved', '', 'info')
          }


        })

      });
</script>

<script>
    $(document).on('click', '.Report', function(e) {
        e.preventDefault();
        var trans_id = $('#idTransRep').val(); // Retrieve from hidden input
        var kelas = Array.isArray($('#kelasRep').val()) ? $('#kelasRep').val() : [$('#kelasRep').val()];
    
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        window.open( " {{ url('/transaksi/siswa/report/')}}" + '/' + kelas + '/' + trans_id, "preview barcode", "width=600,height=600,menubar=no,status=no,scrollbars=yes");
    });
</script>


<script>
     $(document).on('click', '.cetakTgihan', function(e) {
        e.preventDefault();
        let id = $(this).data('id');
        let transis = $(this).data('transis');
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        Swal.fire({
          title: 'Are you Sure?',
          text: "Ingin melihat foto?",
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
              url: " {{ url('/transaksi/siswa/tagihan/')}}" + '/' + id + '/' + transis,
              data: {
                id: id,
                transis : transis,
                },
              cache: false,
              dataType: 'json',
              success: function(response) {
                console.log(response);
                if (response.success) {
                    window.open(" {{ url('/transaksi/siswa/tagihan/print/')}}" + '/' + response.siswa.id + '/' + response.data + '/' + response.master.id, "preview barcode", "width=600,height=600,menubar=no,status=no,scrollbars=yes");
                    // window.open("{{ url('/spp/tagihan/print/') }}/"+response.data.id+"/"+ response.bulan+"/"+response.tahun,"preview barcode","width=600,height=600,menubar=no,status=no,scrollbars=yes"); 
                           
                       
                } else {
                  Swal.fire('Error', response.message, 'error');
                }
              },
              error: function(response) {
               
              },
            });

          } else if (result.isDenied) {
            Swal.fire('Changes are not saved', '', 'info')
          }


        })

      });
</script>
@endsection
