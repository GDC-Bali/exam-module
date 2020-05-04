<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Meta -->
        <meta name="description" content="Paket Soal Attemp">
        <meta name="author" content="GanecaDigital">

        <title>Attemp</title>
        <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet">
        <link href="{{ Module::asset('exam:lib/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ Module::asset('exam:lib/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
        <link href="{{ Module::asset('exam:lib/ionicons/css/ionicons.min.css') }}" rel="stylesheet">
        <link href="{{ Module::asset('exam:lib/typicons.font/typicons.css') }}" rel="stylesheet">
        <link href="{{ Module::asset('exam:lib/datatables/DataTables-1.10.20/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
        <link href="{{ Module::asset('exam:lib/datatables/Responsive-2.2.3/css/responsive.bootstrap4.min.css') }}" rel="stylesheet">
        <link href="{{ Module::asset('exam:lib/icheck/skins/minimal/blue.css') }}" rel="stylesheet">
        <link href="{{ Module::asset('exam:lib/bootstrap4-toggle/css/bootstrap4-toggle.min.css') }}" rel="stylesheet">
        <link href="{{ Module::asset('exam:lib/sweetalert/dist/sweetalert2.min.css') }}" rel="stylesheet">
        <link href="{{ Module::asset('exam:lib/select2/css/select2.min.css') }}" rel="stylesheet">
        <link href="{{ Module::asset('exam:lib/select2/css/select2-bootstrap4.css') }}" rel="stylesheet">
        <link href="{{ Module::asset('exam:css/style.css') }}" rel="stylesheet">
        <style>
            body{
                font-family: 'Poppins', sans-serif;
            }
        </style>
        @yield('style')
    </head>
    <body>

        @include('exam::includes.header-attempt')
        <main role="main" class="container-fluid">
            @yield('content')
        </main>
        
        @yield('footer')
        {{-- @include('exam::includes.footer-attempt') --}}

        <script src="{{ Module::asset('exam:lib/jquery/jquery.min.js') }}"></script>
        <script src="{{ Module::asset('exam:lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ Module::asset('exam:lib/ionicons/ionicons.js') }}"></script>
        <script src="{{ Module::asset('exam:lib/jquery.flot/jquery.flot.js') }}"></script>
        <script src="{{ Module::asset('exam:lib/jquery.flot/jquery.flot.resize.js') }}"></script>
        <script src="{{ Module::asset('exam:lib/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
        <script src="{{ Module::asset('exam:lib/datatables/DataTables-1.10.20/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ Module::asset('exam:lib/datatables/DataTables-1.10.20/js/dataTables.bootstrap4.js') }}"></script>
        <script src="{{ Module::asset('exam:lib/datatables/Responsive-2.2.3/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ Module::asset('exam:lib/datatables/Responsive-2.2.3/js/responsive.bootstrap4.min.js') }}"></script>
        <script src="{{ Module::asset('exam:lib/icheck/icheck.js') }}"></script>
        <script src="{{ Module::asset('exam:lib/bootstrap4-toggle/js/bootstrap4-toggle.min.js') }}"></script>
        <script src="{{ Module::asset('exam:lib/sweetalert/dist/sweetalert2.all.min.js') }}"></script>
        <script src="{{ Module::asset('exam:lib/select2/js/select2.full.min.js') }}"></script>
        <script src="{{ Module::asset('exam:lib/moment/moment-with-locales.min.js') }}"></script>
        <script src="{{ Module::asset('exam:lib/ckeditor/ckeditor.js') }}"></script>
        <script src="{{ Module::asset('exam:lib/input-spinner/input-spinner.js') }}"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                //Disable cut copy paste
                $(document).bind('cut copy paste', function (e) {
                    e.preventDefault();
                });
                 
                //Disable mouse right click
                $(document).on("contextmenu",function(e){
                    return false;
                });
            });
        </script>
        
        @yield('script')
    </body>
</html>