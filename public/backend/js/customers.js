var editor; // use a global for the submit and return data rendering in the examples
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var dataSearch = { load: 'index' };
    $.fn.DataTable.ext.pager.numbers_length = 10;
    var numRows = 0;

    // Edit inline
    editor = new $.fn.dataTable.Editor( {
        ajax: {
            edit:{
                type: 'PUT',
                url:  'customer/edit',
                data: function(data) {
                    data.customer_id = editor.ids()[0];
                    data.dataEdit = data.data[(editor.ids())];
                },
                success: function (response) {
                    console.log(response);
                    if(response.data == 1) {
                        Swal.fire({
                            icon: 'success',
                            title: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            editor.show();
                        });
                    }
                    else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Dữ liệu trùng với dữ liệu cũ!',
                            showConfirmButton: false,
                            timer: 1000
                        })
                    }
                },
                error: function (error) {
                    console.log(error);
                    var mess = '';
                    $.each(error.responseJSON.errors, function (name, message) {
                        // mess += message;
                        // let mess = '<span class="error text-danger d-block">'+message+'</span>';
                        // $("#DTE_Field_"+ name ).parent("div").append(mess);
                        // $("#DTE_Field_"+ name ).parent("div").html(message);
                        $("#DTE_Field_"+ message[0][0] ).parent("div").notify(message[0][1], {className: 'error small', position: 'bot-center',})
                    });
                }
            }
        },
        table: "#customers-table",
        idSrc: 'customer_id',
        fields: [  {
                label: "customer_name:",
                name: "customer_name",
                attr: {
                    type: "text"
                }
            }, {
                label: "email:",
                name: "email",
                attr: {
                    type: "email"
                }
            }, {
                label: "address:",
                name: "address",
                attr: {
                    type: "text"
                }
            }, {
                label: "tel_num:",
                name: "tel_num",
                attr: {
                    type: "number"
                }
            },
        ]
    } );

    // Get all customer
    function getCustomer(){
        var $dataTable = $('#customers-table');

        var table = $('#customers-table').DataTable({
            createdRow: function (row, data) {
                if (data['is_active'] == 'Đang hoạt động') {
                    $('td', row).eq(5).addClass('text-success');
                } else {
                    $('td', row).eq(5).addClass('text-danger');
                }
            },
            drawCallback: function () {
                var page_min = 1;
                var $api = this.api();
                var pages = $api.page.info().pages;
                var rows = $api.data().length;
                numRows = rows;
                if (rows <= page_min) {
                    $dataTable
                        .next('.dataTables_info').css('display', 'none')
                        .next('.dataTables_paginate').css('display', 'none');

                    $dataTable
                        .prev('.dataTables_filter').css('display', 'none')
                        .prev('.dataTables_length').css('display', 'none')
                } else if (pages === 1) {
                    $dataTable
                        .next('.dataTables_info').css('display', 'none')
                        .next('.dataTables_paginate').css('display', 'none');
                } else {
                    $dataTable
                        .next('.dataTables_info').css('display', 'block')
                        .next('.dataTables_paginate').css('display', 'block');
                }
            },
            ajax: {
                url: 'customer',
                type: "GET",
                data: dataSearch,
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'text-center', "width": "1%" },
                { data: 'customer_name', name: 'customer_name', "width": "20%"},
                { data: 'email', name: 'email', "width": "20%"},
                { data: 'address', name: 'address', "width": "26%" },
                { data: 'tel_num', name: 'tel_num', className: 'text-center', "width": "15%"},
                {
                    data: null,
                    defaultContent: '<button type="button" class="rounded-circle btn btn-sm btn-info m-1" title="Chỉnh sửa" "><i class="fas fa-pencil-alt"/></button>',
                    className: 'row-edit dt-center',
                    orderable: false,
                    "width": "9%"
                },
                { data: 'action', name: 'action', className: 'text-center', orderable: false, searchable: false, "width": "9%" },
            ],
            // responsive: true,
            language: {
                processing: "Đang tải dữ liệu, chờ tí",
                lengthMenu: "Điều chỉnh số lượng _MENU_ ",
                info: "Hiển thị _START_ ~ _END_ trong _TOTAL_ khách hàng",
                infoEmpty: "Không có dữ liệu",
                emptyTable: "Không có dữ liệu",
                paginate: {
                    first: "<<",
                    previous: "<",
                    next: ">",
                    last: ">>"
                },
            },
            ordering:  false,
            searching: false,
            serverSide: true,
            destroy: true,
            scrollY: false,
            dom: '<"d-flex justify-content-between align-items-center"<"col-3"l><"col-6 text-center"p><"col-3"i>><t><"d-flex justify-content-between align-items-center"<"col-3"l><"col-6 text-center"p><"col-3"i>>',
            // select: true,
            select: {
                style: 'os',
                selector: 'td:first-child'
            },
            buttons: [
                { extend: "edit",   editor: editor },
            ]
        });

        $('#customers-table tbody').on( 'click', 'td.row-edit', function (e) {
            editor.inline(table.cells(this.parentNode, '*').nodes(), {
                submitTrigger: -1,
                submitHtml: '<button type="button" class="rounded-circle btn btn-sm btn-success m-1" title="Chỉnh sửa">Lưu</button>',
                submit: 'all',
            })
        });

    };
    getCustomer();

    // Delete customer
    $('.btn-delete-product').on('click', function (e) {
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

    // Search Customer
    function searchCustomer () {
        let name = $('#customer-name-search').val();
        let status = $('#customer-filte-status').val();
        let email = $('#customer-email-search').val();
        let address = $('#customer-address-search').val();

        if(name != '' || status != 'default'|| email != '' || address != '') {
            dataSearch = {
                name: name,
                status: status,
                email: email,
                address: address,
                load: 'search'
            };
            getCustomer();

        } else {
            Swal.fire(
                'Hình như bạn đã quên gì đó?',
                'Vui lòng nhập hoặc chọn thông tin để tìm kiếm!',
                'warning'
            );
        }
    }

    // Click search
    $('#btn-search-customer').click(function (e) {
        e.preventDefault();
        searchCustomer();
    });

    // Enter search
    $('#search-customer').on('keyup', function(e) {
        e.preventDefault();
        if (e.which == 13) {
            searchCustomer();
        }
    });

    // Clear search
    $('#btn-clear-search-customer').click(function (e) {
        e.preventDefault();
        dataSearch = { load: 'index' };
        $('#customer-name-search').val('');
        $('#customer-email-search').val('');
        $('#customer-address-search').val('');
        $('#customer-filte-status').val('default');
        getCustomer();
    });

    // //Show button submit
    // function showButtonSubmit(idButton) {
    //     let button = '';
    //     $('#show-button-submit').empty();
    //     button = '<button id="'+ idButton +'"  class="btn btn-danger">Lưu</button>';
    //     $('#show-button-submit').append(button);
    // }

    //Click button Thêm mới
    $('#addNewCustomer').click(function () {
        // $('#product-id').val('');
        clearCustomerwErrorsMessage();
        // showButtonSubmit('addProductButton');
        // $("#imgPreview").attr("src", defaultImage);
        // $('#file-info').text('Chưa chọn file');
        $('#addCustomerForm').trigger("reset");
        $('#popupCustomerTitle').html("Thêm Khách hàng");
        $('#popupCustomer').modal('show');
    });

    // Click button Lưu trong modal add
    $('#addCustomerForm').on('click','#addCustomerButton',function (e) {
        e.preventDefault();
        let customer_name = $('#addCustomerName').val();
        let email = $('#addCustomerEmail').val();
        let tel_num = $('#addCustomerTelNum').val();
        let address = $('#addCustomerAddress').val();
        let status = $('#addCustomerStatus').val();

        axios.post( "customer/add",{
            customer_name: customer_name,
            email: email,
            tel_num: tel_num,
            address: address,
            is_active: status,
        })
        .then(function (response) {
            if(response.data.status == true) {
                $('#popupCustomer').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: "Thêm người dùng thành công",
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                        getCustomer();
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
            clearCustomerwErrorsMessage();
            $.each(error.response.data.errors, function (name, message) {
                $("#" + name + '-errors').html(message[0]);
                $("#" + name + '-errors').removeClass('d-none');
            });
        });
    });

    //Export
    $('#exportCSV').click(function () {
        let name = $('#customer-name-search').val();
        let status = $('#customer-filte-status').val();
        let email = $('#customer-email-search').val();
        let address = $('#customer-address-search').val();

        if(name != '' || status != 'default'|| email != '' || address != '') {
            dataSearch = {
                name: name,
                status: status,
                email: email,
                address: address,
                numRows: numRows,
                load: 'search'
            };
        } else {
            dataSearch = {
                load: 'index',
                numRows: numRows
            };
        }
        Swal.fire({
            title: 'Bạn có muốn xuất file khách hàng không?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Có, Xuất file '
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = 'customer/export?'+ $.param(dataSearch);
            }
        })
    });

    //Click button import
    $('#buttonImport').click( function () {
        $('#import-loading').empty();
        $('#modalImport').modal('show');
    });

    //Import
    $('#uploadFileCSV').on('submit', function (e) {
        e.preventDefault();

        var fileUpload = $("#importCSV").val();
        // console.log(fileUpload);
        if (typeof fileUpload !== 'undefined' && fileUpload !== '') {
            var extension = fileUpload.split('.').pop().toLowerCase();
            var filename = fileUpload.split('\\').pop();
            if ($.inArray(extension, ['xlsx', 'csv', 'xls']) !== -1) {
                showIconLoading();
                var form = $('#uploadFileCSV')[0];
                var formData = new FormData(form);
                console.log(filename);
                axios.post( "customer/import",formData,{
                    headers: { "Content-Type": "multipart/form-data" },
                })
                .then(function (response) {
                    console.log(response);
                    let errors = response.data.data.errors;
                    if(response.data.data.rowsInsert != '') {
                        $('.importInput input[type=file]').val('');
                        $('#modalImport').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: "Thêm khách hàng thành công",
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            getCustomer();
                            showErrorsImportCustomers(errors, filename);
                        });
                    }
                    else {
                        $('.importInput input[type=file]').val('');
                        $('#modalImport').modal('hide');

                        Swal.fire({
                            icon: 'error',
                            title: 'Không có dòng nào được IMPORT!',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            showErrorsImportCustomers(errors, filename);
                        });
                    }
                })
                .catch(function (error) {
                    $('.importInput input[type=file]').val('');
                    $('#modalImport').modal('hide');
                    $('#import-loading').empty();
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: error.response.data.message,
                    })
                });

            } else {
                Swal.fire({
                    icon: 'error',
                    title: "Phải là file 'xlsx', 'csv', 'xls'",
                })
            }
        } else{
            Swal.fire({
                icon: 'error',
                title: 'Không có tệp',
            })
        }
    });

    //Show icon loading
    function showIconLoading() {
        $('#import-loading').empty();
        var loading = '<div class="d-flex justify-content-center mt-2"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>';
        $('#import-loading').append(loading);
    }

    //Show error import
    function showErrorsImportCustomers( errors, filename ) {

        $('#errorsImport').modal('show');
        // $('#errors-import').empty();
        $('#fails-import').empty();
        let err = '';
        let xhtml = '';
        errors.forEach((message, key) => {
            let row = key + 2;
            err +=  '<p>'+'Dòng ' + row + ': ' + message +'</p>';
        });

        if(errors != '') {
            xhtml += '<span class="text-danger">'+err+'</span>';
            $('#fails-import').append(xhtml);
            $('#file-name-import').text(filename);
        }
    }

    // Xoá thông báo lỗi modal user
    function clearCustomerwErrorsMessage() {
        $("#customer_name-errors").empty();
        $("#email-errors").empty();
        $("#tel_num-errors").empty();
        $("#address-errors").empty();
        $("#is_active-errors").empty();
    }

});

