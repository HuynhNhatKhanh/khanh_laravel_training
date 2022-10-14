const actualBtn = document.getElementById('actual-btn');

const fileChosen = document.getElementById('file-chosen');

actualBtn.addEventListener('change', function(){
  fileChosen.textContent = this.files[0].name
})

$(document).ready(function() {
    var base_url = window.location.origin;
    $('.btn-delete').click(function (e) {
        e.preventDefault();
        Swal.fire({
            title: 'Nhắc nhở!',
            text: "Bạn có muốn xoá sản phẩm không?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'OK!'
          }).then((result) => {
            if (result.isConfirmed) {
               Swal.fire({
                    position: 'center-center',
                    icon: 'success',
                    title: 'Xoá sản phẩm thành công',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                            window.location.href = $(this).attr('href');
                    });
            }
          })
    });

    $('#actual-btn').change(function(event){
        var x = URL.createObjectURL(event.target.files[0]);
        $('.imgPreview').attr('src', x);
        console.log(event);
    });

    $('#btn-clear-file').on('click', function() {
        $('.imgPreview').attr('src', 'backend/images/product/image_default.jpg');
        $('#file-chosen').text('Chưa chọn file');
    });

    $(document).on('click','.editbtn', function () {
        var prod_id = $(this).val();
        $('#editModal').modal('show');
        // if (response.product['0'].is_sales == 0)
        $.ajax({
            type: "GET",
            url: "/product/edit/"+prod_id,
            success: function (response) {
                console.log(response.product['0']);
                $('#edit_product_name').val(response.product['0'].product_name);
                $('#edit_product_price').val(response.product['0'].product_price);
                $('#edit_product_ordering').val(response.product['0'].ordering);
                $('#edit_product_status').val(response.product['0'].is_sales);
                $('#edit_product_description').val(response.product['0'].description);
                $('#prod_id').val(response.product['0'].product_id);
            }
        });
    });
});

