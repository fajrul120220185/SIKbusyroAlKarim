<div class="modal fade" id="modal-pembayaran">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Buat Pembayaran</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form action="{{route ('getData') }}" method="get">
                    @csrf
                <div class="form-group">
                    <label for="exampleInputEmail1">Pilih SPP</label>
                    <select class="select2" multiple="multiple"  name="spp[]" data-dropdown-css-class="select2-purple" style="width: 100%;">
                    <option value="0" selected>Tidak Ada Tagihan</option>
                     @foreach($tagihanSPP as $spp)
                        <option value="{{$spp->id}}">{{$spp->bulan}} -- {{$spp->tahun}}</option>
                     @endforeach
                    </select>    
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Pilih Kegiatan</label>
                    <select class="select2" multiple="multiple"  name="transis[]" data-dropdown-css-class="select2-purple" style="width: 100%;">
                    <option value="0" selected>Tidak Ada Tagihan</option>
                     @foreach($tagihanKegiatan as $tk)
                        <option value="{{$tk->id}}">{{$tk->trans_name}}</option>
                     @endforeach
                    </select>
                </div>
                <input type="hidden" name="siswa" value="{{$siswa}}">
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Pay</button>
            </div>
            </form>
          </div>
        </div>
      </div>