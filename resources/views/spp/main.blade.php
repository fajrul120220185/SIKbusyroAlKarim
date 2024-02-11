@extends('partial.main')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
             <div class="card">
                <div class="card-header">
                        <label for="selectTahun">Pilih Kelas:</label>
                        <select class="form-control" id="selectKelas" style="width: 100%;">
                            @foreach ($kelas as $kelas)
                                <option value="{{ $kelas->id }}" {{ $kelas->id == $klz ? 'selected' : '' }}>{{ $kelas->kelas }}{{ $kelas->grade }}</option>
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
                            <td>{{$siswa->kelas}}</td>
                            <td>{{$siswa->angkatan}}</td>
                            <td>
                            <button type="button" class="btn btn-outline-success Bayar"  data-id="{{$siswa->id}}">Pay</button>
                            <button type="button" class="btn btn-outline-warning Bukti"  data-id="{{$siswa->id}}">Bukti</button>
                            <button type="button" class="btn btn-outline-danger Tagihan"  data-id="{{$siswa->id}}">Tagih</button>
                            </td>
                         </tr>
                         @endforeach
                          </tbody>
                        </table>
                </div>
                <div class="card-footer">
                    <h4>Report Bulanan</h4>
                    <br>
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Bulan</label>
                                <select class="form-control" id="bulanReport" style="width: 100%;">
                                    @foreach (range(1, 12) as $optionBulan)
                                        @php
                                            $bulanLabel = date('F', mktime(0, 0, 0, $optionBulan, 1));
                                        @endphp
                                        <option value="{{ $bulanLabel }}" {{ $optionBulan == $bulan ? 'selected' : '' }}>{{ $bulanLabel }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tahun</label>
                                <select class="form-control" id="tahunReport" style="width: 100%;">
                                    @foreach (range(date('Y') - 5, date('Y') + 5) as $optionTahun)
                                        <option value="{{ $optionTahun }}" {{ $optionTahun == $tahun ? 'selected' : '' }}>{{ $optionTahun }}</option>
                                    @endforeach
                                </select>
                                <input type="hidden" id="kelasRep" value="{{$klz}}">
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
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">NIS</label>
                    <input type="text" class="form-control" id="nis" readonly>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Jumlah</label>
                    <input type="number" class="form-control" value="{{$tarif}}" id="jumlah" readonly>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Bukti Bayar</label>
                    <input type="file" class="form-control" id="bukti">
                </div>
                <div class="row">
                    <div class="col-5">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tanggal Bayar</label>
                            <input type="datetime-local" class="form-control" id="paid_at" required>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Bulan</label>
                            <select class="form-control" id="bulan" style="width: 100%;">
                                @foreach (range(1, 12) as $optionBulan)
                                    @php
                                        $bulanLabel = date('F', mktime(0, 0, 0, $optionBulan, 1));
                                    @endphp
                                    <option value="{{ $bulanLabel }}" {{ $optionBulan == $bulan ? 'selected' : '' }}>{{ $bulanLabel }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tahun</label>
                            <select class="form-control" id="tahun" style="width: 100%;">
                                @foreach (range(date('Y') - 5, date('Y') + 5) as $optionTahun)
                                    <option value="{{ $optionTahun }}" {{ $optionTahun == $tahun ? 'selected' : '' }}>{{ $optionTahun }}</option>
                                @endforeach
                            </select>
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

      <div class="modal fade" id="ButkiModal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Bukti</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Bulan</label>
                            <select class="form-control" id="bulanBukti" style="width: 100%;">
                                @foreach (range(1, 12) as $optionBulan)
                                    @php
                                        $bulanLabel = date('F', mktime(0, 0, 0, $optionBulan, 1));
                                    @endphp
                                    <option value="{{ $bulanLabel }}" {{ $optionBulan == $bulan ? 'selected' : '' }}>{{ $bulanLabel }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" class="form-control" id="idBukti">

                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tahun</label>
                            <select class="form-control" id="tahunBukti" style="width: 100%;">
                                @foreach (range(date('Y') - 5, date('Y') + 5) as $optionTahun)
                                    <option value="{{ $optionTahun }}" {{ $optionTahun == $tahun ? 'selected' : '' }}>{{ $optionTahun }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary printBukti">Save</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

      <div class="modal fade" id="TagihModal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header modal-danger">
              <h4 class="modal-title">Tagihan</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Bulan</label>
                            <select class="form-control select2" multiple="multiple" id="bulanTagih" style="width: 100%;">
                                @foreach (range(1, 12) as $optionBulan)
                                    @php
                                        $bulanLabel = date('F', mktime(0, 0, 0, $optionBulan, 1));
                                    @endphp
                                    <option value="{{ $bulanLabel }}" {{ $optionBulan == $bulan ? 'selected' : '' }}>{{ $bulanLabel }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" class="form-control" id="idTagihan">

                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tahun</label>
                            <select class="form-control" id="tahunTagih" style="width: 100%;">
                                @foreach (range(date('Y') - 5, date('Y') + 5) as $optionTahun)
                                    <option value="{{ $optionTahun }}" {{ $optionTahun == $tahun ? 'selected' : '' }}>{{ $optionTahun }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary cetakTagihan">Save</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
@endsection
@section('custom_js')
<script>
        document.getElementById('selectKelas').addEventListener('change', function () {
            var kelas = this.value;
            window.location.href = " {{ url('/spp/')}}" + '/' + kelas;
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

    $(document).on('click', '.Bukti', function() {
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
                $('#ButkiModal').modal('show');
                $('#ButkiModal #idBukti').val(response.data.id);
            },
            error: function(data) {
                console.log('error:', data);
            }
        });
    });
    $(document).on('click', '.Tagihan', function() {
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
                $('#TagihModal').modal('show');
                $('#TagihModal #idTagihan').val(response.data.id);
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
        var name = $('#name').val();
        var jumlah = $('#jumlah').val();
        var tahun = $('#tahun').val();
        var bulan = $('#bulan').val();
        var paid_at = $('#paid_at').val();
        var fileInput = document.getElementById('bukti'); // Mengambil elemen input file
        var bukti = fileInput.files[0]; 
        var formData = new FormData();
            formData.append('id', id);
            formData.append('jumlah', jumlah);
            formData.append('tahun', tahun);
            formData.append('bulan', bulan);
            formData.append('paid_at', paid_at);
            formData.append('bukti', bukti);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        Swal.fire({
            title: 'Are you Sure to pay ' + name +  ' for ' + bulan +  ' ' + tahun + ' ?',
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
                    url: " {{ url('/spp/pay')}}",
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
    $(document).on('click', '.Report', function(e) {
        e.preventDefault();
        var kelas = $('#kelasRep').val(); // Retrieve from hidden input
        var bulan = $('#bulanReport').val();
        var tahun = $('#tahunReport').val();
    
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        window.open(" {{ url('/spp/report/')}}" + '/' + kelas + '/' + bulan + '/' + tahun, "preview barcode", "width=600,height=600,menubar=no,status=no,scrollbars=yes");
    });
</script>

<script>
     $(document).on('click', '.printBukti', function(e) {
        e.preventDefault();
        var id = $('#idBukti').val();
        var bulan = $('#bulanBukti').val();
        var tahun = $('#tahunBukti').val();
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
              url: " {{ url('/spp/bukti/')}}" + '/' + id + '/' + bulan + '/' + tahun,
              data: {
                id: id,
                tahun : tahun,
                bulan : bulan
                },
              cache: false,
              dataType: 'json',
              success: function(response) {
                console.log(response);
                if (response.success) {
                 
                    window.open("{{ url('/spp/foto/') }}/"+response.data.id,"preview barcode","width=600,height=600,menubar=no,status=no,scrollbars=yes"); 
                           
                       
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
     $(document).on('click', '.cetakTagihan', function(e) {
        e.preventDefault();
        var id = $('#idTagihan').val();
        var bulan = $('#bulanTagih').val();
        var tahun = $('#tahunTagih').val();
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
              url: " {{ url('/spp/tagihan/')}}" + '/' + id + '/' + bulan + '/' + tahun,
              data: {
                id: id,
                tahun : tahun,
                bulan : bulan
                },
              cache: false,
              dataType: 'json',
              success: function(response) {
                console.log(response);
                if (response.success) {
                    window.open( " {{ url('/spp/tagihan/print/' )}}" + '/' + response.data.id + '/' + response.bulan + '/' + response.tahun, "preview barcode", "width=600,height=600,menubar=no,status=no,scrollbars=yes");
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
