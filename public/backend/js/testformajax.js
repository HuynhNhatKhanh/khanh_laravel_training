$(document).ready(function() {
    var base_url = window.location.origin;
    $('#number').change(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var price = $('#price').text();
        var number = $('#number').val();
        // console.log(number);
        // console.log(price);
        $.ajax({
            url : base_url +'/news/update',
            type : "post",
            dataType:"html",
            data : {
                price: price,
                number: number
            },
            success : function (data){
                // $('#total').text(data);
                 $('#total').html("<strong>"+data+"</strong>");
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });

    });
});
