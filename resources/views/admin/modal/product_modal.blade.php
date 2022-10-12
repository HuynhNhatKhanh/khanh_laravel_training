<!-- Modal -->
<div class="modal fade" id="FormProductModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('product.create') }}">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group row">
                                <label for="product_name_detail" class="col-sm-3 col-form-label" >Tên sản phẩm</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="product_name_detail"
                                        name="product_name_detail" placeholder="Nhập tên sản phẩm" >
                                    @error('product_name_detail')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="product_price_detail" class="col-sm-3 col-form-label">Giá bán</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" id="product_price_detail"
                                        name="product_price_detail" placeholder="Nhập giá bán" >
                                    @error('product_price_detail')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="product_description_detail" class="col-sm-3 col-form-label">Mô tả</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control ckeditor " id="product_description_detail" rows="11" name="product_description_detail"
                                        placeholder="Nhập mô tả"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group row">
                                <label for="product_image_detail" class="col-sm-3 col-form-label">Hình ảnh</label>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <img class="imgPreview" style="width:100%"
                                        src="{{ asset('backend/images/product/image_default.jpg') }}" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group row">
                                <label for="product_status_detail" class="col-sm-3 col-form-label">Trạng thái</label>
                                <div class="col-sm-9">
                                  <select type="number" class="form-control" id="product_status_detail" name="product_status_detail">
                                    <option value="">- Trạng thái -</option>
                                    <option value="">1</option>
                                    <option value="">2</option>
                                    <option value="">3</option>
                                  </select>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group row">
                                <div class="input-group">
                                    <div>
                                        <!-- actual upload which is hidden -->
                                        <input type="file" id="actual-btn" hidden/>

                                        <!-- our custom upload button -->
                                        <label class= "btn lable-upload-file" for="actual-btn">Upload</label>

                                        <button type="button" class="btn btn-danger" id="btn-clear-file" style="margin-bottom: 5px;">Clear</button>

                                        <!-- name of file chosen -->
                                        <span id="file-chosen">Chưa chọn file</span>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit"  class="btn btn-primary">Lưu</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Huỷ</button>
                </div>
            </form>
        </div>
    </div>
</div>
