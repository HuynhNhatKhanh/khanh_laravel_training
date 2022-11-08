<!-- Modal -->
<div class="modal fade" id="modalImport" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import Khách hàng</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="import-loading"></div>
            <div class="modal-body">
                <form enctype="multipart/form-data" id="uploadFileCSV">
                    @csrf
                    <div class="input-group mb-3 importInput">
                        <input type="file" name="customersFile" class="form-control" style="height: calc(2.25rem + 8px)" id="importCSV">
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
