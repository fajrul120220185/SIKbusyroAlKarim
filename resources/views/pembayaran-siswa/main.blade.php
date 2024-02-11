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
                        <h4>Pilih Siswa</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-9">
                                <div class="input-group align-center">
                                <select class="form-control select2" data-placeholder = "Pilih Satu !" id="siswa" style="width: 100%;">
                                    <option value="">Pilih Satu !</option>
                                    @foreach ($siswaPilih as $siswaP)
                                        <option value="{{ $siswaP->id }}" {{ $siswaP->id == $siswa ? 'selected' : '' }}>{{ $siswaP->name }}--{{ $siswaP->kelas }}{{ $siswaP->grade }}--{{ $siswaP->nis }}</option>
                                    @endforeach
                                </select>
                                </div>
                            </div>
                            <div class="col-3 align-self-end">
                                <div class="form-group">
                                    <button type="button" class="btn btn-outline-info Cari"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if($siswa == null)
            <h4>Pilih Siswa Terlebih Dahulu</h4>
            @else
            <div class="card-header">
                <div class="row">
                    <div class="col-6">
                    <button class="btn btn-outline-warning Tagihan"  data-toggle="modal" data-target="#modal-tagihan">Buat Tagihan</button>
                    @include('pembayaran-siswa.modalTagihan')
                   <button class="btn btn-outline-success Pembayaran"  data-toggle="modal" data-target="#modal-pembayaran">Bayar</button>
                   @include('pembayaran-siswa.modalBayar')
                   <button class="btn btn-outline-info Kwitansi"  data-toggle="modal" data-target="#modal-kwitansi">Cetak Kwitansi</button>
                   @include('pembayaran-siswa.modalKwitansi')
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    @include('pembayaran-siswa.spp')
                </div>
                <div class="col-6">
                    @include('pembayaran-siswa.transaksi')
                </div>
            </div>
            @endif
        </div>
    </div>
</div>


@endsection
@section('custom_js')
<script>
    $(document).ready(function () {
        $('.Cari').click(function () {
            var siswa = $('#siswa').val();
      

            // Now you can use startDate and endDate in your logic or navigation
            window.location.href = "{{ url('/pembayaran-siswa/') }}" + '/' + siswa;
        });

    });

</script>
<script>
    $(document).on('click', '.TagihanPrint', function(e) {
        e.preventDefault();
        var spp = $('#tagihanSPP').val(); // Retrieve from hidden input
        var kegiatan = $('#tagihanKegiatan').val();
        var siswa = $('#tagihansiswa').val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        window.open('{{url("/pembayaran-siswa/tagihan")}}/' + spp + '/' + kegiatan + '/' + siswa, "preview barcode", "width=600,height=600,menubar=no,status=no,scrollbars=yes");
    });
</script>

<script>
    $(document).on('click', '.kwitansiPrint', function(e) {
        e.preventDefault();
        var spp = $('#kwitansiSPP').val(); // Retrieve from hidden input
        var kegiatan = $('#kwitansiKegiatan').val();
        var siswa = $('#kwitansisiswa').val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        window.open('{{url("/pembayaran-siswa/kwitansi")}}/' + spp + '/' + kegiatan + '/' + siswa, "preview barcode", "width=600,height=600,menubar=no,status=no,scrollbars=yes");
    });
</script>

<script>
    $(document).ready(function() {
    // Menetapkan opsi default yang dipilih pada saat halaman dimuat
    $('#tagihanSPP').val('0').trigger('change'); // Mengatur nilai dan memicu event change
    $('#tagihanKegiatan').val('0').trigger('change'); // Mengatur nilai dan memicu event change

    // Aktifkan plugin select2
    $('.select2').select2({
        placeholder: "Pilih",
        // Konfigurasi lainnya...
    });
});
</script>



@endsection