
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PT Artha Jaya Wisata</title>
 <link rel="icon" type="image/png" href="asset/dist/img/icons.png">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="asset/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<link rel="stylesheet" href="asset/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">

<link rel="stylesheet" href="asset/plugins/icheck-bootstrap/icheck-bootstrap.min.css">

<link rel="stylesheet" href="asset/plugins/jqvmap/jqvmap.min.css">

  <!-- DataTables -->
  <link rel="stylesheet" href="asset/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="asset/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="asset/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
  <!-- ini tambahan -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
  <link rel="stylesheet" type="text/css" href="asset/picker/dist/bootstrap-clockpicker.min.css">
  <!-- Theme style -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
<!-- overlayScrollbars -->
<link rel="stylesheet" href="asset/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
<!-- SweetAlert JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="asset/dist/css/adminlte.min.css">

</head>
<style type="text/css">
    .preloader {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: 9999;
      background-color: transparent; /* Set background color to transparent */
    }

    .preloader .loading {
      position: absolute;
      left: 55%;
      top: 50%;
      transform: translate(-50%, -50%);
      font: 14px Arial;
    }
    .sidebar {
    height: 100vh; /* Set height to full viewport height */
    overflow-y: auto; /* Enable vertical scrollbar */
    overflow-x: hidden; /* Hide horizontal scrollbar */
}
  </style>
<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    
    
    <div class="preloader">
          <div class="loading">
    <div class="spinner-border text-primary" style="width: 6rem; height: 6rem;  border-width: 0.7rem;">
    </div>
          </div>
        </div>
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light" style="background:linear-gradient(to right ,#14657b,#14a4b4); position: sticky; top: 0;">

    <ul class="navbar-nav">
    <li class="nav-item">
    <a class="nav-link" data-widget="pushmenu" href="#" role="button" ><i class="fas fa-bars text-light" style="font-size:30px ;"></i></a>
    </li>
    </ul>
    
    <ul class="navbar-nav ml-auto">
    
    <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
        <div class="d-flex align-items-center">
           <img src="asset/dist/img/avatar.png" class="user-img" alt="user avatar" style=" width: 30px;  /* Atur lebar gambar menjadi ukuran ikon */
                height: 30px; /* Atur tinggi gambar menjadi ukuran ikon */
                border-radius: 50%; /* Membuat gambar menjadi lingkaran */
                object-fit: cover; /* Memastikan gambar terpotong dengan benar */">
            
        </div>
    </a>
    
    
            <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
              <div class="dropdown-divider"></div>
              <a href="profile" class="dropdown-item">
                <i class="fas fa-user mr-2"> Profile</i> 
              
              </a>
              <div class="dropdown-divider"></div>
         <a class="nav-link" href="logout" role="button">
            <i class="fas fa-arrow-alt-circle-right mr-2 text-danger"> Log out</i>
    
               
              </a>
          </li>
    </ul>
    </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar main-sidebar-custom sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('monitor') }}" class="brand-link">
      <img src="asset/dist/img/avatar5.png" alt="AdminLTE Logo" style="height:60px;">
      <span class="brand-text font-weight-bold" style="font-size:20px;">Tools Monitor</span>
      </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
  @if(request()->path() == '/' || explode('.', request()->path())[0] == "voucher_detail")
  <li class="nav-item">          
  <a href="{{ route('monitor') }}" class="nav-link active" style="background: #187ca4;">
           <i class="nav-icon fas fa-tachometer-alt"></i>
           <p>Voucher Usages</p>
       </a>
   </li>
   @else
   <li class="nav-item">
       <a href="{{ route('monitor') }}" class="nav-link">
           <i class="nav-icon fas fa-tachometer-alt"></i>
           <p>Voucher Usages</p>
       </a>
   </li>
   @endif


   @if(request()->path() == 'broad' || explode('.', request()->path())[0] == "showfile")
   <li class="nav-item">           
   <a href="{{ route('broad') }}" class="nav-link active" style="background: #187ca4;">
           <i class="nav-icon fas fa-volume-up"></i>
           <p>Broad Cast</p>
       </a>
   </li>
   @else
   <li class="nav-item">
       <a href="{{ route('showfile') }}" class="nav-link">
           <i class="nav-icon fas fa-volume-up"></i>
           <p>Broad Cast</p>
       </a>
   </li>
   @endif


   @if(request()->path() == 'Reseller')
   <li class="nav-item">    
   <a href="{{ route('Reseller') }}" class="nav-link active" style="background: #187ca4;">
           <i class="nav-icon fab fa-napster"></i>
           <p>Reseller Verification</p>
       </a>
   </li>
   @else
   <li class="nav-item">
       <a href="{{ route('Reseller') }}" class="nav-link">
           <i class="nav-icon		fab fa-napster"></i>
           <p>Reseller Verification</p>
       </a>
   </li>
   @endif
  


          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->

    
    <!-- /.sidebar-custom -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content">

      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- Default box -->
            <div class="card">
              
              <!-- /.card-footer-->
            </div>
            <!-- /.card -->
          </div>
        </div>
      </div>
   