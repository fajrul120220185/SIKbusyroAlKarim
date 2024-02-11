
@extends('partial.main')
@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
                
        </div>
        <div class="card-body">
            <div class="card-header">
                <label for="selectTahun">Pilih Tahun:</label>
                <select class="form-control" id="selectTahun" style="width: 100%;">
                    @foreach (range(date('Y') - 5, date('Y') + 5) as $optionTahun)
                        <option value="{{ $optionTahun }}" {{ $optionTahun == $tahun ? 'selected' : '' }}>{{ $optionTahun }}</option>
                    @endforeach
                </select>
            </div>
        <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th></th>
                        <th>Guru</th>
                        @foreach (range(1, 12) as $bulan)
                            <th>{{ DateTime::createFromFormat('!m', $bulan)->format('F') }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($guruData as $rowData)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{ $rowData['guru']->name }}</td>
                            @foreach (range(1, 12) as $bulan)
                                <td>
                                    @if ($rowData['bulan'][$bulan]['isPaid'])
                                        <button type="button" disabled>Paid</button>
                                        @if ($rowData['gaji'] !== null)
                                            <button type="button" class="btn btn-outline-warning printBtn" data-guru="{{ $rowData['guru']->id }}" data-bulan="{{ $bulan }}" data-tahun="{{ $tahun }}"><i class="fa fa-print"></i></button>
                                        @endif
                                    @else
                                        <button type="button" class="btn btn-outline-success bayarBtn" data-guru="{{ $rowData['guru']->id }}" data-bulan="{{ $bulan }}" data-tahun="{{ $tahun }}">Bayar</button>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
                  <tfoot>
                  <tr>
                    <th></th>
                    <th>Guru</th>
                        @foreach (range(1, 12) as $bulan)
                            <th>{{ DateTime::createFromFormat('!m', $bulan)->format('F') }}</th>
                        @endforeach
                  </tr>
                  </tfoot>
                </table>
        </div>
    </div>
</div>




<div class="modal fade" id="EditModal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Gaji Transaksi</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">Nama</label>
                    <input type="text" class="form-control" id="name" readonly>
                    <input type="hidden" id="id">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Gaji</label>
                    <input type="number" class="form-control" id="gaji" readonly>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Keterangan Bonus</label>
                    <textarea class="form-control" rows="3" id="ket_bonus" placeholder="Enter ..."></textarea>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Bonus</label>
                    <input type="number" class="form-control" id="bonus">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Keterangan Pemasukan</label>
                    <textarea class="form-control" rows="3" id="ket_potongan" placeholder="Enter ..."></textarea>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Potongan</label>
                    <input type="number" class="form-control" id="potongan">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Bukti</label>
                    <input type="file" class="form-control" id="bukti">
                </div>
                <br>
                <hr>
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
                            <input type="text" class="form-control" id="bulan" readonly>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tahun</label>
                            <input type="number" class="form-control" id="tahun" readonly>
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
        document.getElementById('selectTahun').addEventListener('change', function () {
            var tahun = this.value;
            window.location.href = " {{ url('/gaji/')}}" + '/' + tahun;
        });
</script>

<script>
     $(document).on('click', '.printBtn', function(e) {
        e.preventDefault();
        var guru = $(this).data('guru');
        var bulanAngka = $(this).data('bulan');
        var tahun = $(this).data('tahun');
        function getMonthName(monthNumber) {
                        var months = [
                            "January", "February", "March",
                            "April", "May", "June", "July",
                            "August", "September", "October",
                            "November", "December"
                        ];
                        return months[monthNumber - 1];
                    }
        var bulan = getMonthName(bulanAngka);
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
              url: " {{ url('/gaji/foto/')}}" + '/' + guru + '/' + bulan + '/' + tahun,
              data: {
                guru: guru,
                tahun : tahun,
                bulan : bulan
                },
              cache: false,
              dataType: 'json',
              success: function(response) {
                console.log(response);
                if (response.success) {
                 
                    window.open("{{ url('/gaji/bukti/') }}/"+response.data.id,"preview barcode","width=600,height=600,menubar=no,status=no,scrollbars=yes"); 
                           
                       
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
     $(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });   

    $(document).on('click', '.bayarBtn', function() {
        let guru = $(this).data('guru');
        let bulan = $(this).data('bulan');
        let tahun = $(this).data('tahun');
        $.ajax({
            type: 'GET',
            url: " {{ url('/gaji/guru/')}}" + '/' + guru + '/' + tahun + '-' + bulan,
            cache: false,
            data: {
                guru: guru,
                tahun : tahun,
                bulan : bulan
            },
            dataType: 'json',
            success: function(response) {
                console.log(response);
                $('#EditModal').modal('show');
                $('#EditModal #id').val(response.data.id);
                $('#EditModal #name').val(response.data.name);
                $('#EditModal #gaji').val(response.data.gaji);
                $('#EditModal #bulan').val(getMonthName(bulan));
                $('#EditModal #tahun').val(tahun);
                function getMonthName(monthNumber) {
                        var months = [
                            "January", "February", "March",
                            "April", "May", "June", "July",
                            "August", "September", "October",
                            "November", "December"
                        ];
                        return months[monthNumber - 1];
                    }
               
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
        var gaji = $('#gaji').val();
        var ket_bonus = $(this).data('ket_bonus');
        var ket_potongan = $(this).data('ket_potongan');
        var potongan = $('#potongan').val();
        var bonus = $('#bonus').val();
        var tahun = $('#tahun').val();
        var total = (parseFloat(gaji) + parseFloat(bonus)) - parseFloat(potongan);
        var bulan = $('#bulan').val();
        var paid_at = $('#paid_at').val();
        var fileInput = document.getElementById('bukti'); // Mengambil elemen input file
        var bukti = fileInput.files[0]; 
        var formData = new FormData();
            formData.append('id', id);
            formData.append('gaji', gaji);
            formData.append('potongan', potongan);
            formData.append('bonus', bonus);
            formData.append('ket_bonus', ket_bonus);
            formData.append('ket_potongan', ket_potongan);
            formData.append('tahun', tahun);
            formData.append('total', total);
            formData.append('bulan', bulan);
            formData.append('paid_at', paid_at);
            formData.append('bukti', bukti);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        Swal.fire({
            title: 'Are you Sure to pay ' + name +  ' with Rp' + total + ' ?',
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
                    url: " {{ url('/gaji/pay')}}",
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
@endsection
