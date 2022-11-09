<!-- Modal -->
<div class="modal fade" id="popupProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="width:105%">
            <div class="modal-header">
                <h5 class="modal-title" id="popupProductTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="" enctype="multipart/form-data" id="addProductForm">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">

                            <input type="hidden" name="product-id" id="product-id">

                            <div class="form-group row">
                                <label for="addProductName" class="col-sm-3 col-form-label">Tên sản phẩm</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="addProductName" id="addProductName" required placeholder="Nhập tên sản phẩm" onblur="checkName('#addProductName', '#product_name-err')" >
                                    <span id="product_name-err" class="error text-danger d-none"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="addProductPrice" class="col-sm-3 col-form-label">Giá bán</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" name="addProductPrice" id="addProductPrice" required placeholder="Nhập giá bán" onblur="checkPrice('#addProductPrice', '#product_price-err')" >
                                    <span id="product_price-err" class="error text-danger d-none"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="addProductDescription" class="col-sm-3 col-form-label">Mô tả</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" name="addProductDescription" id="addProductDescription" style="min-height: 300px"
                                        placeholder="Nhập mô tả"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group row">
                                <label for="product_image_detail" class="col-sm-3 col-form-label">Hình ảnh</label>
                            </div>
                            <div class="form-group row">
                                <img style="margin-left: 20px; width: 90%;" id="imgPreview" src="{{asset('storage/backend/images/product/image_default.jpg')}}" alt="your image" />
                                <span style="margin-top: 15px; margin-left:10px" id="product_image-err" class="error text-danger d-none"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group row">
                                <label for="addProductStatus" class="col-sm-3 col-form-label">Trạng thái</label>
                                <div class="col-sm-9">
                                    <select type="number" class="form-control" name="addProductStatus" id="addProductStatus" onblur="checkSelect('#addProductStatus', '#is_sales-err', 'Trạng thái')">
                                        <option value="default">- Trạng thái -</option>
                                        <option value="1">Còn bán</option>
                                        <option value="0">Ngừng bán</option>
                                    </select>
                                    <span id="is_sales-err" class="error text-danger d-none"></span>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group row">
                              <div class="col-md-12 col-sm-9 col-xs-12">
                                <div class="file-drop-area">
                                    <button id="removeImage" type="button" class="btn btn-danger mb-2">Xóa
                                        ảnh</button>
                                    <input class="file-input" id="addProductImage" type="file"
                                        accept="image/png, image/jpg, image/jpeg" hidden>
                                    <label class="btn btn-primary" for="addProductImage">Upload</label>
                                    <span id="file-info">Chưa chọn file</span>
                                </div>
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button  class="btn btn-primary" id="addProductButton">Lưu</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Huỷ</button>
                </div>
            </form>
        </div>
    </div>
</div>



