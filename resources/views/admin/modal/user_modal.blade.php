<!-- modals -->
 <!-- Small modal -->

 <div class="modal fade bs-example-modal-sm popupUser" id="popupUser" tabindex="-1" role="dialog" aria-hidden="true"
     style="display: none;">
     <div class="modal-dialog modal-sm">
         <div style="width: 550px;" class="modal-content">

             <div class="modal-header">
                 <h4 class="modal-title" id="popupUserTitle"></h4>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
             </div>
             <div class="modal-body">
                 <div>
                     <form id="addUserForm" method="POST" class="form-horizontal">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="user-id" id="user-id">

                         <div class="form-group row">
                             <label for="inputEmail3" class="col-sm-2 control-label" >Tên</label>
                             <div style="width: 75%;" class="col-sm-10">
                                 <input type="text" class="form-control " name="addUserName" id="addUserName"
                                     placeholder="Nhập họ tên" required>
                                 <span id="name-err" class="error text-danger d-none"></span>
                             </div>
                         </div>
                         <div class="form-group row">
                             <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
                             <div style="width: 75%;" class="col-sm-10">
                                 <input type="email" class="form-control " name="addUserEmail" id="addUserEmail"
                                     placeholder="Nhập email">
                                 <span id="email-err" class="error text-danger d-none"></span>
                             </div>
                         </div>
                         <div class="form-group row">
                             <label for="inputPassword3" class="col-sm-2 control-label">Mật khẩu</label>
                             <div style="width: 75%;" class="col-sm-10">
                                 <input type="password" class="form-control " name="addUserPassword"
                                     id="addUserPassword" placeholder="Mật khẩu">
                                 <span id="password-err" class="error text-danger d-none"></span>
                             </div>
                         </div>
                         <div class="form-group row">
                             <label for="inputPassword3" class="col-sm-2 control-label">Xác nhận</label>
                             <div style="width: 75%;" class="col-sm-10">
                                 <input type="password" class="form-control " name="addUserPassword"
                                     id="addUserPasswordConfirm" placeholder="Xác nhận mật khẩu">
                                 <span id="password_confirm-err" class="error text-danger d-none"></span>
                             </div>
                         </div>
                         <div class="form-group row">
                             <label for="addUserRole" class="col-sm-2 control-label">Nhóm</label>
                             <div style="width: 75%;" class="col-sm-10">
                                 <select class="form-control" id="addUserRole" name="addUserRole">
                                     <option value="default">- Nhóm -</option>
                                     <option value="admin">Admin</option>
                                     <option value="reviewer">Reviewer</option>
                                     <option value="editor">Editor</option>
                                 </select>
                                 <span id="group_role-err" class="error text-danger d-none"></span>
                             </div>
                         </div>
                         <div class="form-group row">
                             <label for="addUserStatus" class="col-sm-2 control-label">Trạng thái</label>
                             <div style="width: 75%;" class="col-sm-10">
                                <select class="form-control" id="addUserStatus" name="addUserStatus">
                                    <option value="default">- Trạng thái -</option>
                                    <option value="0">Tạm khoá</option>
                                    <option value="1">Đang hoạt động</option>
                                </select>
                                <span id="is_active-err" class="error text-danger d-none"></span>
                            </div>
                         </div>
                         <div class="modal-footer">
                            <div id="show-button-submit"></div>
                             <button type="button" id="closePopupUserButton" class="btn btn-danger"
                                 data-dismiss="modal">Hủy</button>
                         </div>
                     </form>
                 </div>
             </div>

         </div>
     </div>
 </div>
 <!-- /modals -->
