// const { default: axios } = require("axios");
$(document).ready(function () {
    var base_url = window.location.origin;
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var dataSearch = { load: 'index' };
    $.fn.DataTable.ext.pager.numbers_length = 10;

    // Get all product
    function getProduct(){
        var $dataTable = $('#products-table');

        $('#products-table').DataTable({
            createdRow: function (row, data, dataIndex) {
                if (data['is_sales'] == 'Đang bán') {
                    $('td', row).eq(4).addClass('text-success');
                } else {
                    $('td', row).eq(4).addClass('text-danger');

                }
            },
            drawCallback: function () {
                var page_min = 1;
                var $api = this.api();
                var pages = $api.page.info().pages;
                var rows = $api.data().length;
                if (pages <= page_min) {
                    $('.dataTables_paginate ').hide();
                } else {
                    $('.dataTables_paginate ').show();
                }
            },
            ajax: {
                url: 'product',
                type: "GET",
                data: dataSearch,
            },
            // autoWidth: false, // might need this
            columnDefs: [
                { "width": "2%" },
                { "width": "20%" },
                { "width": "30%" },
                { "width": "14%" },
                { "width": "20%" },
                { "width": "14%" },
              ],
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'text-center' },
                { data: 'product_name', name: 'product_name', orderable: false, searchable: false },
                { data: 'description', name: 'description',
                    render: function ( data, type, row ) {
                        let dataShow = '';
                        if( data !== null ) {
                            dataShow = data;
                        }
                        return '<span class="ellipsis">'
                            + dataShow + '</span>';
                    }
                },
                { data: 'product_price', name: 'product_price', className: ' text-success' },
                { data: 'is_sales', name: 'is_sales', className: 'text-center' },
                { data: 'action', name: 'action', className: 'text-center', orderable: false, searchable: false },
            ],
            language: {
                processing: "Đang tải dữ liệu, chờ tí",
                lengthMenu: "Điều chỉnh số lượng _MENU_ ",
                info: "Hiển thị _START_ ~ _END_ trong _TOTAL_ sản phẩm",
                infoEmpty: "Không có dữ liệu",
                emptyTable: "Không có dữ liệu",
                paginate: {
                    first: "<<",
                    previous: "<",
                    next: ">",
                    last: ">>"
                },
            },
            // responsive: true,
            ordering:  false,
            searching: false,
            serverSide: true,
            scrollY: false,
            destroy: true,
            dom: '<"d-flex justify-content-between align-items-center info-datatables"<"col-3"l><"col-6 text-center"p><"col-3"i>><t><"d-flex justify-content-between align-items-center info-datatables"<"col-3"l><"col-6 text-center"p><"col-3"i>>',

        });
    };
    getProduct();

    // Get product by id
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

    //Delete product
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
        }
        getProduct();
    }

    // Click search
    $('#btn-search-product').click(function (e) {
        e.preventDefault();
        searchProduct();
    });

    // Enter search
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
        getFile(file);
        // $("#addProductImage").val() = file;
        $('#file-info').text($(this).val().split('\\').pop());
        $("#product_image-err").empty();

    });

    // Get file image
    function getFile(file) {
        if (file) {
            let reader = new FileReader();
            reader.onload = function (event) {
                $("#imgPreview").attr("src", event.target.result);
            };
            reader.readAsDataURL(file);
        }
    }

    // Click xoá ảnh
    var defaultImage = $("#imgPreview").attr("src");
    $('#removeImage').click(function () {
        $("#imgPreview").attr("src", defaultImage);
        $("#addProductImage").val("");
        $('#file-info').text('Chưa chọn file');
        $("#product_image-err").empty();
      });

    // Click button edit product
    $('#products-table').on('click', '.editbtn-product', function (e) {
        e.preventDefault();
        let id = $(this).data('id');
        clearErrorsMessage();

        axios.post( "product/getdata", {
            id: id,
        })
        .then(function (response) {
            if (response.data.product_image != undefined) {
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
            // getProduct();
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
            formData.append('product_name', $('#addProductName').val() );
            formData.append('product_price', $('#addProductPrice').val() );
            formData.append('description', $('#addProductDescription').val() );
            formData.append('is_sales', $('#addProductStatus').val());
            formData.append('product_image', $('#addProductImage')[0].files[0] );
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
            formData.append('product_name', $('#addProductName').val() );
            formData.append('product_price', $('#addProductPrice').val() );
            formData.append('description', $('#addProductDescription').val() );
            formData.append('is_sales', $('#addProductStatus').val());
            if ($('#addProductImage')[0].files[0] || $("#imgPreview").attr("src") == defaultImage) {
                formData.append('product_image', $('#addProductImage')[0].files[0] );
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
                    clearErrorsMessage();
                    $.each(error.response.data.errors, function (name, message) {
                        $("#" + name + '-err').html(message[0]);
                        $("#" + name + '-err').removeClass('d-none');
                    });
                });
            } else {
                axios.post( "product/edit_no_img/"+id,formData,{
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
                    clearErrorsMessage();
                    $.each(error.response.data.errors, function (name, message) {
                        $("#" + name + '-err').html(message[0]);
                        $("#" + name + '-err').removeClass('d-none');
                    });
                });
            }
        }
    });

    // Xoá thông báo lỗi modal user
    function clearErrorsMessage() {
        $("#product_name-err").empty();
        $("#product_price-err").empty();
        $("#is_sales-err").empty();
        $("#product_image-err").empty();
    }

 });
