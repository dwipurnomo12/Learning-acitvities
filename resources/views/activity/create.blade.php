<div class="modal fade" tabindex="-1" role="dialog" id="modal_tambah_activity">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah activity</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form enctype="multipart/form-data">
            <div class="modal-body">

                <div class="form-group">
                    <label>Metode <span style="color: red">*</span></label>
                    <select class="form-control" name="metode_id" id="metode_id">
                        <option value="" selected>-- Pilih Metode -- </option>
                        @foreach ($metodes as $metode)
                            <option value="{{ $metode->id}}">{{ $metode->metode }}</option>
                        @endforeach
                    </select>
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-kategori_id"></div>
                </div>

                <div class="form-group">
                    <label>Bulan <span style="color: red">*</span></label>
                    <select class="form-control" name="bulan_id" id="bulan_id">
                        <option value="" selected>-- Pilih Bulan -- </option>
                        @foreach ($bulans as $bulan)
                            <option value="{{ $bulan->id }}">{{ $bulan->bulan }}</option>
                        @endforeach
                    </select>
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-kategori_id"></div>
                </div>


                <div class="form-group">
                    <label for="body" class="form-label">Activity <span style="color: red">*</span></label>
                    <textarea class="form-control" id="activity" name="activity" rows="10">{{ old('body') }}</textarea>
                </div>

                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
                    <button type="button" id="store" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
  </div>
</div>

