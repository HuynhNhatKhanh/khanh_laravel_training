$(document).ready(function () {
    var base_url = window.location.origin;
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // print list
    function showListUser(list){
        let xhtml = '';
        $('.products-body').empty();
        let i = 0;
        list.forEach(function(element) {
            i++;
            //let group = (element.group_role).charAt(0).toUpperCase() + (element.group_role).slice(1);
            let group = '';
            group = (element.group_role);
            xhtml = '<tr>';
            xhtml += '<td class="text-center">'+ i +'</td>';
            xhtml += '<td class="text-wrap img_hover" style="min-width: 60px">'+ element.name +'</td>';
            xhtml += '<td class="text-wrap" style="min-width: 60px">'+ element.email +'</td>';
            xhtml += '<td class="text-center"><span class="">'+ group +'</span></td>';
            if (element.is_active === 0){
                xhtml += '<td class="text-center"><span class="text-danger">Tạm khoá</span></td>';
            } else if (element.is_active === 1){
                xhtml += '<td class="text-center"><span class="text-success">Đang hoạt động</span></td>';
            }

            xhtml += '<td class="text-center" >';
            xhtml += '<button type="button" value="'+ element.id +'" class="rounded-circle btn btn-sm btn-info editbtn-user" title="Chỉnh sửa" data-id="'+ element.id +'"><i class="fas fa-pencil-alt"></i></button>';
            xhtml += '<button type="button" class="rounded-circle btn btn-sm btn-danger btn-delete-user"title="Xoá" data-id="'+ element.id +'" ><i class="fas fa-trash-alt"></i> </button>'
            xhtml += '<button class="rounded-circle btn btn-sm btn-dark btn-block-user" title="Khoá/Mở thành viên" data-id="'+ element.id +'" data-status="'+element.is_active+'"><i class="fas fa-user-times"></i></button> </td>'
            xhtml += '</tr>';
            $('.products-body').append(xhtml);
        })
    }

    // Get all user
    function getUser(){
        $.ajax({
            // type: "post",
            url: "user",
            // data: "data",
            // dataType: "json",
            success: function (response) {
                //console.log(response);
                showListUser(response.users.data)
            }
        });
    };
    getUser();

    // Get 1 user
    function getUserById(id){
        let user = null;
        $.ajax({
            type: "post",
            url: "user/getdata",
            async: false,
            data: {
                id: id
            },
            //dataType: "json",
            success: function (response) {
                user = response;
            }
        });
        return user;
    }

    //Delete user
    $('#users-table').on('click', '.btn-delete-user', function (e) {
        let id = $(this).data('id');
        let userData = getUserById(id);
        //console.log(userData.is_delete);
        e.preventDefault();
        Swal.fire({
            title: 'Nhắc nhở!',
            text: "Bạn có muốn xoá thành viên "+ userData.name +" không?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'OK!'
          }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'user/delete',
                    type: "post",
                    // type: "delete",
                    // async: false,
                    data: {
                        id: id,
                        delete: userData.is_delete,
                    },
                    success: function (response) {
                        Swal.fire({
                            position: 'center-center',
                            icon: 'success',
                            title: "Xoá thành viên "+ userData.name +" thành công",
                            showConfirmButton: false,
                            timer: 1000
                        }).then(() => {
                                getUser();
                            });
                    }
                });
            }
        })
    });

    // Block/ Unblock user
    $('#users-table').on('click', '.btn-block-user', function (e) {
        let id = $(this).data('id');
        let status = $(this).data('status');
        let nameStatus = 'Mở khoá';
        if (status === 1){
            nameStatus = 'Khoá';
        }
        e.preventDefault();
        Swal.fire({
            title: 'Nhắc nhở!',
            text: "Bạn có muốn "+ nameStatus +" người dùng không?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'OK!'
          }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'user/status',
                    type: "post",
                    // type: "delete",
                    // async: false,
                    data: {
                        id: id,
                        status: status,
                    },
                    success: function (response) {
                        Swal.fire({
                            position: 'center-center',
                            icon: 'success',
                            title: "Đã "+ nameStatus +" người dùng thành công",
                            showConfirmButton: false,
                            timer: 1000
                        }).then(() => {
                                getUser();
                            });
                    }
                });
            }
        })
    });

    // Search
    function searchUser () {
        let name = $('#name-search').val();
        let email = $('#email-search').val();
        let role = $('#filter_role').val();
        let status = $('#filter_status').val();
        if(name != '' || email != '' || role != 'default'|| status != 'default') {
            $.ajax({
                type: "post",
                url: "user/search",
                data: {
                    name: name,
                    email: email,
                    role: role,
                    status: status,
                },
                //dataType: "dataType",
                success: function (response) {
                    showListUser(response.data);
                }
            });
        };
    }
    $('#btn-search-user').click(function () {
        searchUser();
    });
    $('#search-user').on('keydown', function(e) {
        if (e.which == 13) {
            searchUser();
        }
    });

    // Clear search
    $('#btn-clear-search-user').click(function () {
        $('#name-search').val('');
        $('#email-search').val('');
        $('#filter_role').val('default');
        $('#filter_status').val('default');
        getUser();
    });

    //Show button submit
    function showButtonSubmit(idButton) {
        let button = '';
        $('#show-button-submit').empty();
        button = '<button id="'+ idButton +'"  class="btn btn-danger">Lưu</button>';
        $('#show-button-submit').append(button);
    }

    //Add user
    $('#addNewUser').click(function () {
        // $('#addUserButton').val("add-user");
        $('#user-id').val('');
        $('#addUserForm').trigger("reset");
        $('#popupUserTitle').html("Thêm User");
        $('#popupUser').modal('show');

        showButtonSubmit('addUserButton');
    });

    $('#addUserButton').click(function (e) {
        e.preventDefault();
        let name = $('#addUserName').val();
        let email = $('#addUserEmail').val();
        let password = $('#addUserPassword').val();
        let passwordConfirm = $('#addUserPasswordConfirm').val();
        let role = $('#addUserRole').val();
        let status = $('#addUserStatus').val();
        // $(this).html('Sending..');

        $.ajax({
          data: {
            name: name,
            email: email,
            password: password,
            group_role: role,
            is_active: status,
          },
          url: "user/add",
          type: "post",
          dataType: 'json',
          success: function (response) {
            //console.log(response);
            //   $('#addUserForm').trigger("reset");
            $('#popupUser').modal('hide');
            //   table.draw();
            Swal.fire({
                position: 'center-center',
                icon: 'success',
                title: "Thêm người dùng thành công",
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                    getUser();
                });

          },
            //   error: function (data) {
            //       console.log('Error:', data);
            //       $('#saveBtn').html('Save Changes');
            //   }
        });
    });

    $('#users-table').on('click', '.editbtn-user', function (e) {
        let id = $(this).data('id');

        showButtonSubmit('editUserButton');

        $.ajax({
            type: "post",
            url: "user/getdata",
            data:  {
                id: id,
            },
            // dataType: "dataType",
            success: function (response) {
                // console.log(response);
                $('#addUserButton').attr('id', 'editUserButton');

                $('#addUserName').val(response.name);
                $('#addUserEmail').val(response.email);
                // $('#addUserPassword').val(response.password);
                // $('#addUserPasswordConfirm').val(response.password);
                $('#addUserRole').val(response.group_role);
                $('#addUserStatus').val(response.is_active);

                $('#popupUserTitle').html("Chỉnh sửa User");
                $('#addUserButton').val("edit-user");
                $('#user-id').val(response.id);
                $('#popupUser').modal('show');
            }
        });
    });

    $('#addUserForm').on('click','#editUserButton', function (e) {
        e.preventDefault();

        let id = $('#user-id').val();
        let name = $('#addUserName').val();
        let email = $('#addUserEmail').val();
        let password = $('#addUserPassword').val();
        let passwordConfirm = $('#addUserPasswordConfirm').val();
        let role = $('#addUserRole').val();
        let status = $('#addUserStatus').val();
        $.ajax({
            type: "put",
            url: "user/edit/"+id,
            data:  {
                name: name,
                email: email,
                password: password,
                group_role: role,
                is_active: status,
            },
            // dataType: "dataType",
            success: function (response) {

                $('#popupUser').modal('hide');
                Swal.fire({
                    position: 'center-center',
                    icon: 'success',
                    title: "Cập nhật dùng thành công",
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                        getUser();
                    });
            }
        });
    });

 });
