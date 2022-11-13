// $('[data-widget="pushmenu"]').PushMenu("collapse");

$(document).ready(function() {
    var path_url = window.location.pathname;

    var linkProduct  = '/' + $('#link-product').attr('href');
    var linkUser     = '/' + $('#link-user').attr('href');
    var linkCustomer = '/' + $('#link-customer').attr('href');
    if (path_url == linkProduct ) {
        $('#link-product').addClass('bg-secondary rounded')
    }
    if (path_url == linkUser ) {
        $('#link-user').addClass('bg-secondary rounded')
    }
    if (path_url == linkCustomer ) {
        $('#link-customer').addClass('bg-secondary rounded')
    }
});

// Check validate frontend name
function checkName(id, id_error) {
    $(id_error).empty();

    let name = $(id).val();
    if( name.trim() === '') {
        $(id_error).html('Tên không được để trống');
    } else if( (name.trim()).length <= 5) {
        $(id_error).html('Tên phải lớn hơn 5 ký tự');
    }
    $(id_error).removeClass('d-none');
}

// Check validate frontend mail
function checkEmail(id, id_error) {
    $(id_error).empty();
    // const vEmail = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    const vEmail = /^(([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5}){1,25})([;.](([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5}){1,25})+)*$/;

    let email = $(id).val();
    if( email.trim() === '') {
        $(id_error).html('Email không được để trống');
    } else if (vEmail.test(email.trim()) === false ) {
        $(id_error).html('Email không đúng định dạng');
    } else if( (email.trim()).length > 255 ) {
        $(id_error).html('Email quá dài');
    }
    $(id_error).removeClass('d-none');
}

// Check validate frontend password
function checkPassword(id, id_error, flag) {
    $(id_error).empty();
    const vPassword = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/;
    let password = $(id).val();
    if (flag === 1) {
        if( password.trim() === '') {
            $(id_error).html('Mật khẩu không được để trống');
        } else if( (password.trim()).length <= 5) {
            $(id_error).html('Mật khẩu phải lớn hơn 5 ký tự');
        } else if (vPassword.test(password.trim()) === false ) {
            $(id_error).html('Mật khẩu phải bao gồm chữ thường, in hoa, số và kí tự đặc biệt ');
        }
    } else {
        if( password.trim() === '') {
            $(id_error).html('Xác nhận mật khẩu không được để trống');
        }
    }
    $(id_error).removeClass('d-none');
}

// Check validate frontend select
function checkSelect(id, id_error, name) {
    $(id_error).empty();
    let item = $(id).val();
    if( item === 'default') {
        $(id_error).html('Vui lòng chọn ' + name + 'khác mặc định');
    }

    $(id_error).removeClass('d-none');
}

// Check validate frontend address
function checkAddress(id, id_error) {
    $(id_error).empty();

    let address = $(id).val();
    if( address.trim() === '') {
        $(id_error).html('Địa chỉ không được để trống');
    } else if( (address.trim()).length > 255) {
        $(id_error).html('Địa chỉ quá dài');
    }
    $(id_error).removeClass('d-none');
}

// Check validate frontend phone number
function checkPhoneNumber(id, id_error) {
    $(id_error).empty();

    let phoneNumber = $(id).val();
    vPhone = /^[0-9]{7,13}$/
    if( phoneNumber.trim() === '') {
        $(id_error).html('Điện thoại không được để trống');
    } else if ( (vPhone.test(phoneNumber.trim()) === false) ) {
        $(id_error).html('Điện thoại không đúng định dạng');
    }
    $(id_error).removeClass('d-none');
}

// Check validate frontend price
function checkPrice(id, id_error) {
    $(id_error).empty();

    let price = $(id).val();
    if( price.trim() === '') {
        $(id_error).html('Giá không được để trống');
    } else if( price < 0 ) {
        $(id_error).html('Giá phải lớn hơn 0');
    }
    $(id_error).removeClass('d-none');
}
