$(document).ready(function () {
    var base_url = window.location.origin;
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    //Login
    $('#form-login').submit( function(e) {
        e.preventDefault();
        let formInput = $(this).serialize();

        axios.post('user/login', formInput)
          .then(function (response) {
            if (response.data.status == true) {
                window.location.href = 'product';
            }
            if (response.data.status == false) {
                $("#password-error").html(response.data.message);
                $("#password-error").removeClass('d-none');
            }
          })
          .catch(function (error) {
            let arrError = error.response.data.errors;
            $.each(arrError, function (name, message){
                $("#" + name + '-error').html(message[0]);
                $("#" + name + '-error').removeClass('d-none');
            });

        });

        // $.ajax({
        //     type: 'post',
        //     url: "user/login",
        //     data: formInput.serialize(),
        //     beforeSend: function () {
        //         clearErrorsMessageLogin();
        //     },
        //     success: function (response) {
        //         if (response.status == true) {
        //             window.location.href = 'product';
        //         }
        //         if (response.status == false) {
        //             $("#password-error").html(response.message);
        //             $("#password-error").removeClass('d-none');
        //         }
        //     },
        //     error: function (responseError) {
        //         $.each(responseError.responseJSON.errors, function (name, message) {
        //             $("#" + name + '-error').html(message[0]);
        //             $("#" + name + '-error').removeClass('d-none');
        //         });
        //     },
        // });
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
            type: "get",
            url: "user",
            async: false,
            success: function (response) {
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
                success: function (response) {
                    showListUser(response.data);
                }
            });
        };
    }
    $('#btn-search-user').click(function () {
        searchUser();
    });
    $('#search-user').on('keyup', function(e) {
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

    //Click button Thêm mới
    $('#addNewUser').click(function () {
        // $('#user-id').val('');
        $('#addUserForm').trigger("reset");
        $('#popupUserTitle').html("Thêm User");
        $('#popupUser').modal('show');

        showButtonSubmit('addUserButton');
        clearErrorsMessage();
    });

    //Click button Lưu
    $('#addUserForm').on('click','#addUserButton',function (e) {
        e.preventDefault();
        let name = $('#addUserName').val();
        let email = $('#addUserEmail').val();
        let password = $('#addUserPassword').val();
        let passwordConfirm = $('#addUserPasswordConfirm').val();
        let role = $('#addUserRole').val();
        let status = $('#addUserStatus').val();
        $.ajax({
            data: {
                name: name,
                email: email,
                password: password,
                password_confirm: passwordConfirm,
                group_role: role,
                is_active: status,
            },
            url: "user/add",
            type: "post",
            dataType: 'json',
            success: function (response) {
                if(response.status == true) {
                    $('#popupUser').modal('hide');
                    Swal.fire({
                        position: 'center-center',
                        icon: 'success',
                        title: "Thêm người dùng thành công",
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                            getUser();
                        });
                }
            },
            error: function (responseError) {
                console.log(responseError);
                $.each(responseError.responseJSON.errors, function (name, message) {
                    $("#" + name + '-err').html(message[0]);
                    $("#" + name + '-err').removeClass('d-none');
                });
            },
            beforeSend: function () {
                clearErrorsMessage();
            },
        });
    });

    function clearErrorsMessage() {
        $("#name-err").empty();
        $("#email-err").empty();
        $("#password-err").empty();
        $("#password_confirm-err").empty();
        $("#is_active-err").empty();
        $("#group_role-err").empty();
    }

    function clearErrorsMessageLogin() {
        $("#email-error").empty();
        $("#password-error").empty();
    }

    // Click button edit user
    $('#users-table').on('click', '.editbtn-user', function () {
        let id = $(this).data('id');
        showButtonSubmit('editUserButton');
        clearErrorsMessage();
        $.ajax({
            type: "post",
            url: "user/getdata",
            data:  {
                id: id,
            },
            success: function (response) {
                $('#addUserName').val(response.name);
                $('#addUserEmail').val(response.email);
                $('#addUserRole').val(response.group_role);
                $('#addUserStatus').val(response.is_active);

                $('#popupUserTitle').html("Chỉnh sửa User");
                $('#user-id').val(response.id);
                $('#popupUser').modal('show');
            }
        });
    });

    // Click button Lưu trong modal edit
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
                password_confirm: passwordConfirm,
                group_role: role,
                is_active: status,
            },
            success: function (response) {
                console.log(response);
                if(response.status == true) {
                    $('#popupUser').modal('hide');
                    Swal.fire({
                        position: 'center-center',
                        icon: 'success',
                        title: "Cập nhật người dùng thành công",
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                            getUser();
                        });
                }

            },
            error: function (responseError) {
                $.each(responseError.responseJSON.errors, function (name, message) {
                    console.log(name);
                    console.log(message);
                    $("#" + name + '-err').html(message[0]);
                    $("#" + name + '-err').removeClass('d-none');
                });
            },
            beforeSend: function () {
                clearErrorsMessage();
            },
        });
    });

 });
