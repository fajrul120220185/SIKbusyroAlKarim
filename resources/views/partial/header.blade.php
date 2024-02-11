 <!-- Google Font: Source Sans Pro -->
 <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{asset('layout/main/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- IonIcons -->
  <!-- <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> -->
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('layout/main/dist/css/adminlte.min.css')}}">
  <!-- <link rel="stylesheet" href="{{asset('layout/main/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}"> -->

  <link rel="stylesheet" href="{{asset('layout/main/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('layout/main/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('layout/main/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('layout/main/extensions/sweetalert2/sweetalert2.min.css')}}">

  <link rel="stylesheet" href="{{asset('layout/main/plugins/daterangepicker/daterangepicker.css')}}">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="{{asset('layout/main/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="{{asset('layout/main/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css')}}">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{asset('layout/main/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{asset('layout/main/plugins/select2/css/select2.min.css')}}">
  <link rel="stylesheet" href="{{asset('layout/main/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="{{asset('layout/main/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css')}}">
  <!-- BS Stepper -->
  <link rel="stylesheet" href="{{asset('layout/main/plugins/bs-stepper/css/bs-stepper.min.css')}}">
  <!-- dropzonejs -->
  <link rel="stylesheet" href="{{asset('layout/main/plugins/dropzone/min/dropzone.min.css')}}">

  <style>
      .select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #007bff; /* Warna biru */
    color: #ffffff; /* Warna teks putih */
}

  </style>

@if(View::hasSection('custom_styles'))
@yield('custom_styles')
@endif