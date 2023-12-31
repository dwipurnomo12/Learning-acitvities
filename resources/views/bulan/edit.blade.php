<div class="modal fade" tabindex="-1" role="dialog" id="modal_edit_bulan">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Bulan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form enctype="multipart/form-data">
          <div class="modal-body">

            <input type="hidden" id="bulan_id">
            <div class="form-group">
                <label>Bulan</label>
                <input type="text" class="form-control" name="bulan" id="edit_bulan">
                <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-bulan"></div>
            </div>

        </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
          <button type="button" class="btn btn-primary" id="update">Update</button>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>