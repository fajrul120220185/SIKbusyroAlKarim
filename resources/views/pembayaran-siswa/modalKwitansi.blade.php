<div class="modal fade" id="modal-kwitansi">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Buat Kwitansi</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">Pilih SPP</label>
                    <select class="select2" multiple="multiple"  id="kwitansiSPP" data-dropdown-css-class="select2-purple" style="width: 100%;">
                    <option value="0" selected>Tidak Ada kwitansi</option>
                     @foreach($kwitansiSPP as $spp)
                        <option value="{{$spp->id}}">{{$spp->bulan}} -- {{$spp->tahun}}</option>
                     @endforeach
                    </select>    
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Pilih Kegiatan</label>
                    <select class="select2" multiple="multiple"  id="kwitansiKegiatan" data-dropdown-css-class="select2-purple" style="width: 100%;">
                    <option value="0" selected>Tidak Ada kwitansi</option>
                     @foreach($kwitansiKegiatan as $tk)
                        <option value="{{$tk->id}}">{{$tk->trans_name}}</option>
                     @endforeach
                    </select>
                </div>
                <input type="hidden" id="kwitansisiswa" value="{{$siswa}}">
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary kwitansiPrint">Save</button>
            </div>
          </div>
        </div>
      </div>