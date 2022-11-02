
$(document).ready(function () {
    var base_url = window.location.origin;
    $('[data-widget="pushmenu"]').PushMenu("collapse");
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var dataSearch = { load: 'index' };
    $.fn.DataTable.ext.pager.numbers_length = 10;
    var numRows = 0;
    // Get all product
    // var $dataTable;

    // var editor = new $.fn.dataTable.Editor( {
    //     ajax: "../php/staff.php",
    //     table: "#customers-table",
    //     fields: [ {
    //             label: "DT_RowIndex:",
    //             name: "DT_RowIndex"
    //         }, {
    //             label: "customer_name:",
    //             name: "customer_name"
    //         }, {
    //             label: "email:",
    //             name: "email"
    //         }, {
    //             label: "address:",
    //             name: "address"
    //         }, {
    //             label: "tel_num:",
    //             name: "tel_num"
    //         }, {
    //             label: "is_active:",
    //             name: "is_active",
    //         }
    //     ]
    // } );

    //  // Activate an inline edit on click of a table cell
    $('#customers-table').on( 'click', 'editbtn-user', function (e) {

    });

    function getCustomer(){
        var $dataTable = $('#customers-table');

        $('#customers-table').DataTable({
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
                // Tailor the settings based on the row count
                if (rows <= page_min) {
                    // Not enough rows for really any features, hide filter/pagination/length
                    $dataTable
                        .next('.dataTables_info').css('display', 'none')
                        .next('.dataTables_paginate').css('display', 'none');

                    $dataTable
                        .prev('.dataTables_filter').css('display', 'none')
                        .prev('.dataTables_length').css('display', 'none')
                } else if (pages === 1) {
                    // With this current length setting, not more than 1 page, hide pagination
                    $dataTable
                        .next('.dataTables_info').css('display', 'none')
                        .next('.dataTables_paginate').css('display', 'none');
                } else {
                    // SHow everything
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
                { data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'text-center' },
                { data: 'customer_name', name: 'customer_name'},
                { data: 'email', name: 'email'},
                { data: 'address', name: 'address' },
                { data: 'tel_num', name: 'tel_num', className: 'text-center' },
                { data: 'is_active', name: 'is_active', className: 'text-center' },
                { data: 'action', name: 'action', className: 'text-center', orderable: false, searchable: false },
                // $xhtml = '<td class="text-center ">';
                // //         $xhtml .= '<button type="button" value="'. $results->customer_id .'" class="rounded-circle btn btn-sm btn-info m-1 editbtn-user " title="Chỉnh sửa" data-id="'. $results->customer_id .'"><i class="fas fa-pencil-alt"></i></button> </td>';
                // {
                //     data: null,
                //     // defaultContent: '<i class="fa fa-pencil"/>',
                //     defaultContent: '<button type="button" value="" class="rounded-circle btn btn-sm btn-info m-1 editbtn-user " title="Chỉnh sửa" data-id=""><i class="fas fa-pencil-alt"></i></button>',
                //     className: 'row-edit dt-center',
                //     orderable: false
                // },
            ],
            language: {
                processing: "Đang tải dữ liệu, chờ tí",
                lengthMenu: "Điều chỉnh số lượng _MENU_ ",
                info: "Hiển thị từ _START_ ~ _END_ trong _TOTAL_ người dùng",
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
            // lengthChange: false,
            // pagingType: "full_numbers",
            destroy: true,
            // ajax: "...",
            dom: '<"d-flex justify-content-between align-items-center"<"col-3"l><"col-6 text-center"p><"col-3"i>><t><"d-flex justify-content-between align-items-center"<"col-3"l><"col-6 text-center"p><"col-3"i>>',
            // "bDestroy": true
            // processing: true,

        });
        // $('div.bottom').attr("width","500");
    };
    getCustomer();



    // var dataTable = $('#products-table').DataTable({
    //     retrieve: true,
    // });
    // $('#rowsPerPage').on('change', function() {
    //     let row = $("#rowsPerPage").val()
    //     dataTable.page.len(row).draw();
    // });

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
    $('#btn-search-customer').click(function (e) {
        e.preventDefault();
        searchCustomer();
    });
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

    // // Click button edit user
    // $('#products-table').on('click', '.editbtn-product', function (e) {
    //     e.preventDefault();
    //     let id = $(this).data('id');
    //     clearCustomerwErrorsMessage();

    //     axios.post( "product/getdata", {
    //         id: id,
    //     })
    //     .then(function (response) {
    //         if (response.data.product_image != null) {
    //             $('#file-info').text(response.data.product_image);
    //             $("#imgPreview").attr("src", base_url + '/storage/backend/images/product/' + response.data.product_image)
    //         } else {
    //             $("#imgPreview").attr("src", defaultImage);
    //             $('#file-info').text('Chưa chọn file');
    //         }
    //         $('#addProductName').val(response.data.product_name);
    //         $('#addProductPrice').val(response.data.product_price);
    //         $('#addProductDescription').val(response.data.description);
    //         $('#addProductStatus').val(response.data.is_sales);
    //         $('#product-id').val(response.data.product_id);
    //         $('#popupProductTitle').html("Chỉnh sửa Sản Phẩm");
    //         $('#popupProduct').modal('show');
    //         // getProduct();
    //     })
    //     .catch(function (error) {
    //         Swal.fire({
    //             icon: 'error',
    //             title: 'Oops...',
    //             text: 'Đã xảy ra lỗi!',
    //         })
    //     });
    // });


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

    //Import
    $('#importCSV').on('change', function () {
        var form = $('#uploadFileCSV')[0];
        var formData = new FormData(form);
        axios.post( "customer/import",formData,{
            headers: { "Content-Type": "multipart/form-data" },
        })
        .then(function (response) {
            console.log(response);
            if(response.data.status == true) {
                Swal.fire({
                    icon: 'success',
                    title: "Thêm sản phẩm thành công",
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
            $('#errors-import').empty();
            let err = '';
            $.each(error.response.data.errors, function (name, message) {
                for( let key in message) {
                    err +=  '<p>'+'Dòng ' + name + ': ' + message[key] +'</p>';
                }
            });
            let xhtml = '';
            xhtml += ' <div class="row h-50" style="width=100%"><div class="col-md-12 col-md-offset-1"><div  class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-ban"></i> Lỗi import!</h4>'+ err +'</div></div></div>'
            $('#errors-import').append(xhtml);
        });
    });

    // Xoá thông báo lỗi modal user
    function clearCustomerwErrorsMessage() {
        $("#customer_name-errors").empty();
        $("#email-errors").empty();
        $("#tel_num-errors").empty();
        $("#address-errors").empty();
        $("#is_active-errors").empty();
    }

});

