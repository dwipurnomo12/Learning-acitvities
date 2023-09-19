<div class="modal fade" tabindex="-1" role="dialog" id="modal_edit_metode">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit metode</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form enctype="multipart/form-data">
          <div class="modal-body">

            <input type="hidden" id="metode_id">
            <div class="form-group">
                <label>Metode</label>
                <input type="text" class="form-control" name="metode" id="edit_metode">
                <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-metode"></div>
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