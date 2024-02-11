<div class="modal fade" id="modal-tagihan">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Buat Tagihan</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">Pilih SPP</label>
                    <select class="select2" multiple="multiple"  id="tagihanSPP" data-dropdown-css-class="select2-purple" style="width: 100%;">
                    <option value="0" selected>Tidak Ada Tagihan</option>
                     @foreach($tagihanSPP as $spp)
                        <option value="{{$spp->id}}">{{$spp->bulan}} -- {{$spp->tahun}}</option>
                     @endforeach
                    </select>    
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Pilih Kegiatan</label>
                    <select class="select2" multiple="multiple"  id="tagihanKegiatan" data-dropdown-css-class="select2-purple" style="width: 100%;">
                    <option value="0" selected>Tidak Ada Tagihan</option>
                     @foreach($tagihanKegiatan as $tk)
                        <option value="{{$tk->id}}">{{$tk->trans_name}}</option>
                     @endforeach
                    </select>
                </div>
                <input type="hidden" id="tagihansiswa" value="{{$siswa}}">
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary TagihanPrint">Save</button>
            </div>
          </div>
        </div>
      </div>