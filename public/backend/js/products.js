// const { default: axios } = require("axios");

$(document).ready(function () {
    var base_url = window.location.origin;
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var dataSearch = { load: 'index' };

    // Get all product
    function getProduct(){
        $('#products-table').DataTable({
            createdRow: function (row, data, dataIndex) {
                if (data['is_sales'] == 'Đang bán') {
                    $('td', row).eq(4).addClass('text-success');
                } else {
                    $('td', row).eq(4).addClass('text-danger');

                }
            },
            ajax: {
                url: 'product',
                type: "GET",
                data: dataSearch,
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'text-center' },
                { data: 'product_name', name: 'product_name', orderable: false, searchable: false },
                { data: 'description', name: 'description'},
                { data: 'product_price', name: 'product_price', className: 'text-center text-success' },
                { data: 'is_sales', name: 'is_sales', className: 'text-center' },
                { data: 'action', name: 'action', className: 'text-center', orderable: false, searchable: false },
            ],
            language: {
                processing: "Đang tải dữ liệu, chờ tí",
                lengthMenu: "Điều chỉnh số lượng bản ghi trên 1 trang ~ _MENU_ ",
                info: "Hiển thị từ _START_ ~ _END_ trong tổng số _TOTAL_ user",
                infoEmpty: "Không có dữ liệu",
                emptyTable: "Không có dữ liệu",
                paginate: {
                    first: "Trang đầu",
                    previous: "Trang trước",
                    next: "Trang sau",
                    last: "Trang cuối"
                },
            },
            ordering:  false,
            searching: false,
            paging: false,
            info: false,
            destroy: true,
            // "processing": true,
            // "serverSide": true,
        });
    };
    getProduct();
    // Get 1 user
    // async function getUserById1(id){
    //     var user = null;
    //     await axios.post('user/getdata', {
    //             id: id
    //         })
    //         .then(function (response) {
    //             user = response;
    //         })
    //         .catch(function (error) {
    //             console.log(error);
    //         });
    //         return Promise.resolve(user);
    //     }
    function getProductById(id){
        let product = null;
        $.ajax({
            type: "post",
            url: "product/getdata",
            async: false,
            data: {
                id: id
            },
            //dataType: "json",
            success: function (response) {
                product = response;
            }
        });
        return product;
    }

    //Delete user
    $('#products-table').on('click', '.btn-delete-product', function (e) {
        e.preventDefault();
        let id = $(this).data('id');
        let productData = getProductById(id);
        Swal.fire({
            title: 'Nhắc nhở!',
            text: "Bạn có muốn xoá sản phẩm [ "+ productData.product_name +" ] không?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'OK!'
          }).then((result) => {
            if (result.isConfirmed) {
                axios.post('product/delete',{
                    id: id,
                })
                .then(function (response) {
                    console.log(response);
                    if(response.data.data === 1) {
                        Swal.fire({
                            icon: 'success',
                            title: "Xoá sản phẩm [ "+ productData.product_name +" ] thành công",
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            getProduct();
                        });
                    } else {
                        Swal.fire({
                            title: 'Lỗi!',
                            text: "Hành động không thành công?",
                            icon: 'warning',
                            confirmButtonColor: '#d33',
                            confirmButtonText: 'OK!'
                        }).then(() => {
                            getUser();
                        });
                    }
                })
                .catch(function (error) {
                    Swal.fire({
                        title: 'Lỗi!',
                        icon: 'warning',
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'OK!'
                    })
                })
            }
        })
    });

    // Search Product
    function searchProduct () {
        let name = $('#product-name-search').val();
        let status = $('#product-filte-status').val();
        let priceFrom = $('#price-from-search').val();
        let priceTo = $('#price-to-search').val();

        if(name != '' || status != 'default'|| priceFrom != '' || priceTo != '') {
            dataSearch = {
                name: name,
                status: status,
                priceFrom: priceFrom,
                priceTo: priceTo,
                load: 'search'
            };
            getProduct();
        } else {
            Swal.fire(
                'Hình như bạn đã quên gì đó?',
                'Vui lòng nhập hoặc chọn thông tin để tìm kiếm!',
                'warning'
            )
        }
    }
    $('#btn-search-product').click(function (e) {
        e.preventDefault();
        searchProduct();
    });
    $('#search-product').on('keyup', function(e) {
        e.preventDefault();
        if (e.which == 13) {
            searchProduct();
        }
    });

    // Clear search
    $('#btn-clear-search-product').click(function (e) {
        e.preventDefault();
        dataSearch = { load: 'index' };
        $('#product-name-search').val('');
        $('#price-from-search').val('');
        $('#price-to-search').val('');
        $('#product-filte-status').val('default');
        getProduct();
    });

    // //Show button submit
    // function showButtonSubmit(idButton) {
    //     let button = '';
    //     $('#show-button-submit').empty();
    //     button = '<button id="'+ idButton +'"  class="btn btn-danger">Lưu</button>';
    //     $('#show-button-submit').append(button);
    // }

    // //Click button Thêm mới
    // $('#addNewUser').click(function () {
    //     // $('#user-id').val('');
    //     clearErrorsMessage();
    //     showButtonSubmit('addUserButton');
    //     $('#addUserForm').trigger("reset");
    //     $('#popupUserTitle').html("Thêm User");
    //     $('#popupUser').modal('show');
    // });

    // //Click button Lưu trong modal add
    // $('#addUserForm').on('click','#addUserButton',function (e) {
    //     e.preventDefault();
    //     let name = $('#addUserName').val();
    //     let email = $('#addUserEmail').val();
    //     let password = $('#addUserPassword').val();
    //     let passwordConfirm = $('#addUserPasswordConfirm').val();
    //     let role = $('#addUserRole').val();
    //     let status = $('#addUserStatus').val();

    //     axios.post( "user/add",{
    //         name: name,
    //         email: email,
    //         password: password,
    //         password_confirm: passwordConfirm,
    //         group_role: role,
    //         is_active: status,
    //     })
    //     .then(function (response) {
    //         if(response.data.status == true) {
    //             $('#popupUser').modal('hide');
    //             Swal.fire({
    //                 icon: 'success',
    //                 title: "Thêm người dùng thành công",
    //                 showConfirmButton: false,
    //                 timer: 1500
    //             }).then(() => {
    //                     getUser();
    //             });
    //         }
    //         else {
    //             Swal.fire({
    //                 icon: 'error',
    //                 title: 'Oops...',
    //                 text: 'Đã xảy ra lỗi!',
    //             })
    //         }
    //     })
    //     .catch(function (error) {
    //         clearErrorsMessage();
    //         $.each(error.response.data.errors, function (name, message) {
    //             $("#" + name + '-err').html(message[0]);
    //             $("#" + name + '-err').removeClass('d-none');
    //         });
    //     });
    // });

    // // Click button edit user
    // $('#users-table').on('click', '.editbtn-user', function (e) {
    //     e.preventDefault();
    //     let id = $(this).data('id');
    //     showButtonSubmit('editUserButton');
    //     clearErrorsMessage();
    //     $('#addUserPassword').val('');
    //     $('#addUserPasswordConfirm').val('');

    //     axios.post( "user/getdata", {
    //         id: id,
    //     })
    //     .then(function (response) {
    //         $('#addUserName').val(response.data.name);
    //         $('#addUserEmail').val(response.data.email);
    //         $('#addUserRole').val(response.data.group_role);
    //         $('#addUserStatus').val(response.data.is_active);
    //         $('#user-id').val(response.data.id);
    //         $('#popupUserTitle').html("Chỉnh sửa User");
    //         $('#popupUser').modal('show');
    //     })
    //     .catch(function (error) {
    //         Swal.fire({
    //             icon: 'error',
    //             title: 'Oops...',
    //             text: 'Đã xảy ra lỗi!',
    //         })
    //     });
    // });

    // // Click button Lưu trong modal edit
    // $('#addUserForm').on('click','#editUserButton', function (e) {
    //     e.preventDefault();
    //     let id = $('#user-id').val();
    //     let name = $('#addUserName').val();
    //     let email = $('#addUserEmail').val();
    //     let password = $('#addUserPassword').val();
    //     let passwordConfirm = $('#addUserPasswordConfirm').val();
    //     let role = $('#addUserRole').val();
    //     let status = $('#addUserStatus').val();

    //     axios.put( "user/edit/"+id,{
    //         name: name,
    //         email: email,
    //         password: password,
    //         password_confirm: passwordConfirm,
    //         group_role: role,
    //         is_active: status,
    //     })
    //     .then(function (response) {
    //         if(response.data.status == true) {
    //             $('#popupUser').modal('hide');
    //             Swal.fire({
    //                 icon: 'success',
    //                 title: "Cập nhật người dùng thành công",
    //                 showConfirmButton: false,
    //                 timer: 1500
    //             }).then(() => {
    //                 getUser();
    //             });
    //         } else {
    //             Swal.fire({
    //                 icon: 'error',
    //                 title: 'Oops...',
    //                 text: 'Đã xảy ra lỗi!',
    //             })
    //         }
    //     })
    //     .catch(function (error) {
    //         clearErrorsMessage();
    //         $.each(error.response.data.errors, function (name, message) {
    //             $("#" + name + '-err').html(message[0]);
    //             $("#" + name + '-err').removeClass('d-none');
    //         });
    //     });
    // });

    // // Xoá thông báo lỗi modal user
    // function clearErrorsMessage() {
    //     $("#name-err").empty();
    //     $("#email-err").empty();
    //     $("#password-err").empty();
    //     $("#password_confirm-err").empty();
    //     $("#is_active-err").empty();
    //     $("#group_role-err").empty();
    // }

    // // Print list old, use append html
    // function showListUser(list){
    //     let xhtml = '';
    //     $('.products-body').empty();
    //     let i = 0;
    //     list.forEach(function(element) {
    //         i++;
    //         //let group = (element.group_role).charAt(0).toUpperCase() + (element.group_role).slice(1);
    //         let group = '';
    //         group = (element.group_role);
    //         xhtml = '<tr>';
    //         xhtml += '<td class="text-center">'+ i +'</td>';
    //         xhtml += '<td class="text-wrap img_hover" style="min-width: 60px">'+ element.name +'</td>';
    //         xhtml += '<td class="text-wrap" style="min-width: 60px">'+ element.email +'</td>';
    //         xhtml += '<td class="text-center"><span class="">'+ group +'</span></td>';
    //         if (element.is_active === 0){
    //             xhtml += '<td class="text-center"><span class="text-danger">Tạm khoá</span></td>';
    //         } else if (element.is_active === 1){
    //             xhtml += '<td class="text-center"><span class="text-success">Đang hoạt động</span></td>';
    //         }

    //         xhtml += '<td class="text-center" >';
    //         xhtml += '<button type="button" value="'+ element.id +'" class="rounded-circle btn btn-sm btn-info editbtn-user" title="Chỉnh sửa" data-id="'+ element.id +'"><i class="fas fa-pencil-alt"></i></button>';
    //         xhtml += '<button type="button" class="rounded-circle btn btn-sm btn-danger btn-delete-user"title="Xoá" data-id="'+ element.id +'" ><i class="fas fa-trash-alt"></i> </button>'
    //         xhtml += '<button class="rounded-circle btn btn-sm btn-dark btn-block-user" title="Khoá/Mở thành viên" data-id="'+ element.id +'" data-status="'+element.is_active+'"><i class="fas fa-user-times"></i></button> </td>'
    //         xhtml += '</tr>';
    //         $('.products-body').append(xhtml);
    //     })
    // }
 });
