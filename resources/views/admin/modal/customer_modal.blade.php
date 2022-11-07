<!-- modals -->
 <!-- Small modal -->

 <div class="modal fade bs-example-modal-sm popupCustomer" id="popupCustomer" tabindex="-1" role="dialog" aria-hidden="true"
     style="display: none;">
     <div class="modal-dialog modal-sm">
         <div style="width: 550px;" class="modal-content">

             <div class="modal-header">
                 <h4 class="modal-title" id="popupCustomerTitle"></h4>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
             </div>
             <div class="modal-body">
                 <div>
                     <form id="addCustomerForm" method="POST" class="form-horizontal">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="customer-id" id="customer-id">

                         <div class="form-group row">
                             <label for="addCustomerName" class="col-sm-2 control-label">Tên</label>
                             <div style="width: 75%;" class="col-sm-10">
                                 <input type="text" class="form-control " name="addCustomerName" id="addCustomerName"
                                     placeholder="Nhập họ tên">
                                 <span id="customer_name-errors" class="error text-danger d-none"></span>
                             </div>
                         </div>
                         <div class="form-group row">
                             <label for="addCustomerEmail" class="col-sm-2 control-label">Email</label>
                             <div style="width: 75%;" class="col-sm-10">
                                 <input type="email" class="form-control " name="addCustomerEmail" id="addCustomerEmail"
                                     placeholder="Nhập email">
                                 <span id="email-errors" class="error text-danger d-none"></span>
                             </div>
                         </div>
                         <div class="form-group row">
                             <label for="addCustomerTelNum" class="col-sm-2 control-label">Điện thoại</label>
                             <div style="width: 75%;" class="col-sm-10">
                                 <input type="number" class="form-control " name="addCustomerTelNum"
                                     id="addCustomerTelNum" placeholder="Điện thoại">
                                 <span id="tel_num-errors" class="error text-danger d-none"></span>
                             </div>
                         </div>
                         <div class="form-group row">
                             <label for="inputAddress" class="col-sm-2 control-label">Địa chỉ</label>
                             <div style="width: 75%;" class="col-sm-10">
                                 <input type="text" class="form-control " name="addCustomerAddress"
                                     id="addCustomerAddress" placeholder="Địa chỉ">
                                 <span id="address-errors" class="error text-danger d-none"></span>
                             </div>
                         </div>
                         <div class="form-group row">
                             <label class="col-sm-2 control-label">Trạng thái</label>
                             <div style="width: 75%;" class="col-sm-10">
                                <select class="form-control " id="addCustomerStatus" name="addCustomerStatus">
                                    <option value="default">- Trạng thái -</option>
                                    <option value="0">Tạm khoá</option>
                                    <option value="1">Đang hoạt động</option>
                                </select>
                                <span id="is_active-errors" class="error text-danger d-none"></span>
                            </div>
                         </div>
                         <div class="modal-footer">
                            <button  class="btn btn-primary" id="addCustomerButton">Lưu</button>
                             <button type="button" id="closePopupCustomerButton" class="btn btn-danger"
                                 data-dismiss="modal">Hủy</button>
                         </div>
                     </form>
                 </div>
             </div>

         </div>
     </div>
 </div>
 <!-- /modals -->
