@extends(config('exam.layout.master'), [config('exam.route.key') => config('exam.route.name')])    
@section(config('exam.layout.content', 'content'))
    <div class="m-3">
        @include('exam::includes.topnav')
        @yield('content_exam')
    </div>
@endsection
@section(config('exam.layout.style'))
    <link href="{{ Module::asset('exam:lib/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ Module::asset('exam:lib/typicons.font/typicons.css') }}" rel="stylesheet">

    @if (config('exam.plugins.ionicons'))
    <link href="{{ Module::asset('exam:lib/ionicons/css/ionicons.min.css') }}" rel="stylesheet">
    @endif

    @if (config('exam.plugins.datatables'))
    <link href="{{ Module::asset('exam:lib/datatables/DataTables-1.10.20/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ Module::asset('exam:lib/datatables/Responsive-2.2.3/css/responsive.bootstrap4.min.css') }}" rel="stylesheet">
    @endif

    @if (config('exam.plugins.icheck'))
    <link href="{{ Module::asset('exam:lib/icheck/skins/minimal/blue.css') }}" rel="stylesheet">
    @endif

    @if (config('exam.plugins.bootstrap4-toggle'))
    <link href="{{ Module::asset('exam:lib/bootstrap4-toggle/css/bootstrap4-toggle.min.css') }}" rel="stylesheet">
    @endif

    @if (config('exam.plugins.sweetalert2'))
    <link href="{{ Module::asset('exam:lib/sweetalert/dist/sweetalert2.min.css') }}" rel="stylesheet">
    @endif

    @if (config('exam.plugins.select2'))
    <link href="{{ Module::asset('exam:lib/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ Module::asset('exam:lib/select2/css/select2-bootstrap4.css') }}" rel="stylesheet">
    @endif

    @if (config('exam.plugins.smartwizard'))
    <link href="{{ Module::asset('exam:lib/smartwizard/css/smart_wizard.min.css') }}" rel="stylesheet">
    <link href="{{ Module::asset('exam:lib/smartwizard/css/smart_wizard_theme_dots.min.css') }}" rel="stylesheet">
    @endif

    <link href="{{ Module::asset('exam:css/style.css') }}" rel="stylesheet">
@stop
@section(config('exam.layout.script'))
    {{-- <script src="{{ Module::asset('exam:lib/jquery/jquery.min.js') }}"></script> --}}
    {{-- <script src="{{ Module::asset('exam:lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script> --}}
    @if (config('exam.plugins.ionicons'))
    <script src="{{ Module::asset('exam:lib/ionicons/ionicons.js') }}"></script>
    @endif


    <script src="{{ Module::asset('exam:lib/jquery.flot/jquery.flot.js') }}"></script>
    <script src="{{ Module::asset('exam:lib/jquery.flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ Module::asset('exam:lib/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>

    @if (config('exam.plugins.datatables'))
    <script src="{{ Module::asset('exam:lib/datatables/DataTables-1.10.20/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ Module::asset('exam:lib/datatables/DataTables-1.10.20/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ Module::asset('exam:lib/datatables/Responsive-2.2.3/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ Module::asset('exam:lib/datatables/Responsive-2.2.3/js/responsive.bootstrap4.min.js') }}"></script>
    @endif

    @if (config('exam.plugins.icheck'))
    <script src="{{ Module::asset('exam:lib/icheck/icheck.js') }}"></script>
    @endif

    @if (config('exam.plugins.bootstrap4-toggle'))
    <script src="{{ Module::asset('exam:lib/bootstrap4-toggle/js/bootstrap4-toggle.min.js') }}"></script>
    @endif

    @if (config('exam.plugins.sweetalert2'))
    <script src="{{ Module::asset('exam:lib/sweetalert/dist/sweetalert2.all.min.js') }}"></script>
    @endif

    @if (config('exam.plugins.select2'))
    <script src="{{ Module::asset('exam:lib/select2/js/select2.full.min.js') }}"></script>
    @endif

    @if (config('exam.plugins.smartwizard'))
    <script src="{{ Module::asset('exam:lib/smartwizard/js/jquery.smartWizard.min.js') }}"></script>
    @endif
    
    <script src="{{ Module::asset('exam:lib/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ Module::asset('exam:lib/input-spinner/input-spinner.js') }}"></script>
    @yield('script_exam')
@stop
