
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Khanh Training Laravel</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{url('backend')}}/plugins/fontawesome-free/css/all.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{url('backend')}}/plugins/select2/css/select2.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{url('backend')}}/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{url('backend')}}/dist/css/adminlte.min.css">
    <!-- Custom css-->
    <link rel="stylesheet" href="{{url('backend')}}/css/custom.css">
    <!--datatables -->
    <link rel="stylesheet" href="{{url('backend')}}/editor/css/editor.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.12.1/datatables.min.css"/>
    {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jqc-1.12.4/dt-1.12.1/b-2.2.3/sl-1.4.0/datatables.min.css"/> --}}
    {{-- <link rel="stylesheet" type="text/css" href="Editor-2.0.10/css/editor.dataTables.css"> --}}


</head>
<body class="hold-transition sidebar-mini layout-fixed">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link sidebar-toggle-btn" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block ">
        <a href="product" class="nav-link " id="link-product">Sản phẩm</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="user" class="nav-link" id="link-user">Người dùng</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="customer" class="nav-link" id="link-customer">Khách hàng</a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                <img src="{{url('backend')}}/dist/img/khanh.jpg" class="user-image img-circle elevation-2" alt="User Image">
                <span class="d-none d-md-inline">Admin</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <!-- User image -->
                <li class="user-header bg-info">
                    <img src="{{url('backend')}}/dist/img/khanh.jpg" class="img-circle elevation-2" alt="User Image">

                    <p>Khanh <small>Admin</small></p>
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                    <a href="https://github.com/HuynhNhatKhanh" class="btn btn-default btn-flat" target="blank">Profile</a>
                    <a href="{{ route('logoutUser') }}" class="btn btn-default btn-flat float-right">Sign out</a>
                </li>
            </ul>
        </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{url('backend')}}/index3.html" class="brand-link">
      <img src="{{url('backend')}}/dist/img/rivercrane.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Rivercrane</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{url('backend')}}/dist/img/khanh.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Khánh</a>
        </div>
      </div>

    </div>
    <!-- /.sidebar -->
  </aside>

@yield('main')
@include('admin.modal.product_modal')
@include('admin.modal.user_modal')
@include('admin.modal.customer_modal')

  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <a href="https://rivercrane.vn/" class="text-danger font-weight-bold" target="blank">Rivercrane</a>
    </div>
    <strong>Copyright &copy; 2022 <a href="https://github.com/HuynhNhatKhanh/khanh_laravel_training" target="blank">Khanh</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{url('backend')}}/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="{{url('backend')}}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Select2 -->
    <script src="{{url('backend')}}/plugins/select2/js/select2.full.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="{{url('backend')}}/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="{{url('backend')}}/dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{url('backend')}}/dist/js/demo.js"></script>
    <!--SweetAlert2 -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!--Custom js -->
    <script src="{{asset("backend/js/myScript.js")}}"></script>
    <script src="{{asset("backend/js/users.js")}}"></script>
    <script src="{{asset("backend/js/products.js")}}"></script>
    <script src="{{asset("backend/js/customers.js")}}"></script>
    <!-- NotifyJS -->
    <script src="{{asset("backend/dist/js/notify.js")}}"></script>
    <!--CkEditor -->
    <script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
    <!--datatables -->
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.12.1/datatables.min.js"></script>
    <script src="{{asset("backend/editor/js/dataTables.editor.min.js")}}"></script>

    {{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script> --}}
    {{-- <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.4.0/js/dataTables.select.min.js"></script>
    <script src="https://cdn.datatables.net/datetime/1.1.2/js/dataTables.dateTime.min.js"></script>
    <script src="https://editor.datatables.net/extensions/Editor/js/dataTables.editor.min.js"></script> --}}
    {{-- <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jqc-1.12.4/dt-1.12.1/b-2.2.3/sl-1.4.0/datatables.min.js"></script> --}}
    {{-- <script type="text/javascript" src="Editor-2.0.10/js/dataTables.editor.js"></script> --}}
    <!--Axios -->
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios@1.1.2/dist/axios.min.js"></script>

    <script>
        $(function () {
            $('.select2').select2()
        });
    </script>
</body>
</html>
