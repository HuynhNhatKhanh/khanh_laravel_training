
$(document).ready(function() {
    var base_url = window.location.origin;
    var path_url = window.location.pathname;
    $('[data-widget="pushmenu"]').PushMenu("collapse");

    var linkProduct  = '/' + $('#link-product').attr('href');
    var linkUser     = '/' + $('#link-user').attr('href');
    var linkCustomer = '/' + $('#link-customer').attr('href');
    if (path_url == linkProduct ) {
        $('#link-product').addClass('bg-secondary')
    }
    if (path_url == linkUser ) {
        $('#link-user').addClass('bg-secondary')
    }
    if (path_url == linkCustomer ) {
        $('#link-customer').addClass('bg-secondary')
    }
});

