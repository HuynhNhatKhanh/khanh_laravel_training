// const { default: axios } = require("axios");

$(document).ready(function () {
    var base_url = window.location.origin;
    $('[data-widget="pushmenu"]').PushMenu("collapse");
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
            );
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

    //Click button Thêm mới
    $('#addNewProduct').click(function () {
        $('#product-id').val('');
        clearErrorsMessage();
        $("#imgPreview").attr("src", defaultImage);
        $('#file-info').text('Chưa chọn file');
        $('#addProductForm').trigger("reset");
        $('#popupProductTitle').html("Thêm Sản Phẩm");
        $('#popupProduct').modal('show');
    });

    //Click add image product
    $("#addProductImage").change(function () {
        let file = this.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = function (event) {
                $("#imgPreview")
                  .attr("src", event.target.result);
            };
            reader.readAsDataURL(file);
        }
        $('#file-info').text($(this).val().split('\\').pop());
        $("#product_image-err").empty();
    });

    // Click xoá ảnh
    var defaultImage = $("#imgPreview").attr("src");
    $('#removeImage').click(function () {
        $("#imgPreview").attr("src", defaultImage);
        $("#addProductImage").val("");
        $('#file-info').text('Chưa chọn file');
        $("#product_image-err").empty();
      });

    // Click button edit user
    $('#products-table').on('click', '.editbtn-product', function (e) {
        e.preventDefault();
        let id = $(this).data('id');
        clearErrorsMessage();

        axios.post( "product/getdata", {
            id: id,
        })
        .then(function (response) {
            if (response.data.product_image != null) {
                $('#file-info').text(response.data.product_image);
                $("#imgPreview").attr("src", base_url + '/storage/backend/images/product/' + response.data.product_image)
            } else {
                $("#imgPreview").attr("src", defaultImage);
                $('#file-info').text('Chưa chọn file');
            }
            $('#addProductName').val(response.data.product_name);
            $('#addProductPrice').val(response.data.product_price);
            $('#addProductDescription').val(response.data.description);
            $('#addProductStatus').val(response.data.is_sales);
            $('#product-id').val(response.data.product_id);
            $('#popupProductTitle').html("Chỉnh sửa Sản Phẩm");
            $('#popupProduct').modal('show');
        })
        .catch(function (error) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Đã xảy ra lỗi!',
            })
        });
    });

    // Click button Lưu trong modal add
    $('#addProductForm').on('click','#addProductButton',function (e) {

        if ($('#product-id').val() == '' || $('#product-id').val() == null ) {
            e.preventDefault();
            var formData = new FormData();
            formData.append('product_image', $('#addProductImage')[0].files[0] );
            formData.append('product_name', $('#addProductName').val() );
            formData.append('product_price', $('#addProductPrice').val() );
            formData.append('description', $('#addProductDescription').val() );
            formData.append('is_sales', $('#addProductStatus').val());
            axios.post( "product/add",formData,{
                headers: { "Content-Type": "multipart/form-data" },
            })
            .then(function (response) {
                if(response.data.status == true) {
                    $('#popupProduct').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: "Thêm sản phẩm thành công",
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                            getProduct();
                    });
                }
                else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Đã xảy ra lỗi!',
                    })
                }
            })
            .catch(function (error) {
                console.log(error);
                clearErrorsMessage();
                $.each(error.response.data.errors, function (name, message) {
                    $("#" + name + '-err').html(message[0]);
                    $("#" + name + '-err').removeClass('d-none');
                });
            });
        }
        else {
            e.preventDefault();
            let id = $('#product-id').val();
            var formData = new FormData();
            formData.append('product_image', $('#addProductImage')[0].files[0] );
            formData.append('product_name', $('#addProductName').val() );
            formData.append('product_price', $('#addProductPrice').val() );
            formData.append('description', $('#addProductDescription').val() );
            formData.append('is_sales', $('#addProductStatus').val());
            // formData.append('product_id', $('#product-id').val());
            axios.post( "product/edit/"+id,formData,{
                headers: { "Content-Type": "multipart/form-data" },
            })
            .then(function (response) {
                if(response.data.status == true) {
                    $('#popupProduct').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: "Chỉnh sửa sản phẩm thành công",
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                            getProduct();
                    });
                }
                else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Đã xảy ra lỗi!',
                    })
                }
            })
            .catch(function (error) {
                console.log(error);
                clearErrorsMessage();
                $.each(error.response.data.errors, function (name, message) {
                    $("#" + name + '-err').html(message[0]);
                    $("#" + name + '-err').removeClass('d-none');
                });
            });
        }
    });

    // Xoá thông báo lỗi modal user
    function clearErrorsMessage() {
        $("#product_name-err").empty();
        $("#product_price-err").empty();
        $("#is_sales-err").empty();
        $("#product_image-err").empty();
    };
 });
