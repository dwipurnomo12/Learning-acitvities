<div class="modal fade" tabindex="-1" role="dialog" id="modal_edit_activity">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">edit activity</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form enctype="multipart/form-data">
            <div class="modal-body">

                <input type="hidden" id="activity_id">
                <div class="form-group">
                    <label>Metode <span style="color: red">*</span></label>
                    <select class="form-control" name="metode_id" id="edit_metode_id">
                        <option value="" selected>-- Pilih Metode -- </option>
                        @foreach ($metodes as $metode)
                            @if (old('metode', $metode->metode) == $metode->metode)
                                <option value="{{ $metode->id }}" selected>{{ $metode->metode }}</option>
                            @else
                                <option value="{{ $metode->id }}">{{ $metode->metode }}</option>
                            @endif
                        @endforeach
                    </select>
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-kategori_id"></div>
                </div>

                <div class="form-group">
                    <label>Bulan <span style="color: red">*</span></label>
                    <select class="form-control" name="bulan_id" id="edit_bulan_id">
                        <option value="" selected>-- Pilih Bulan -- </option>
                        @foreach ($bulans as $bulan)
                            @if (old('bulan', $bulan->bulan) == $bulan->bulan)
                                <option value="{{ $bulan->id }}" selected>{{ $bulan->bulan }}</option>
                            @else
                                <option value="{{ $bulan->id }}">{{ $bulan->bulan }}</option>
                            @endif
                        @endforeach
                    </select>
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-kategori_id"></div>
                </div>


                <div class="form-group">
                    <label for="body" class="form-label">Activity <span style="color: red">*</span></label>
                    <textarea class="form-control" id="edit_activity" name="activity" rows="10">{{ old('body') }}</textarea>
                </div>

                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
                    <button type="button" id="update" class="btn btn-primary">edit</button>
                </div>
            </form>
        </div>
    </div>
  </div>
</div>

