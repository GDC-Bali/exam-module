<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Meta -->
    <meta name="description" content="Responsive Bootstrap 4 Dashboard Template">
    <meta name="author" content="BootstrapDash">

    <title>Azia Responsive Bootstrap 4 Dashboard Template</title>

    <!-- vendor css -->
    <link href="{{ url('../assets/lib/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ url('../assets/lib/ionicons/css/ionicons.min.css') }}" rel="stylesheet">
    <link href="{{ url('../assets/lib/typicons.font/typicons.css') }}" rel="stylesheet">
    <link href="{{ url('../assets/lib/jqvmap/jqvmap.min.css') }}" rel="stylesheet">

    {{-- Datatable css --}}
    <link href="{{ url('../assets/lib/datatables.net-dt/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{ url('../assets/lib/datatables.net-responsive-dt/css/responsive.dataTables.min.css')}}" rel="stylesheet">

    {{-- Icheck css --}}
    <link href="{{ Module::asset('exam:lib/icheck/skins/minimal/blue.css') }}" rel="stylesheet">

    <!-- azia CSS -->
    <link rel="stylesheet" href="{{ url('../assets/css/azia.css') }}">

  </head>
  <body class="az-body az-body-sidebar az-body-dashboard-nine">

    @include('exam::includes.sidebar')

    <div class="az-content az-content-dashboard-nine">
        @include('exam::includes.header')
        @include('exam::includes.topmenu')
        @yield('content')
        @include('exam::includes.footer')
    </div><!-- az-content -->

    <script src="{{ url('../assets/lib/jquery/jquery.min.js') }}"></script>
    <script src="{{ url('../assets/lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ url('../assets/lib/ionicons/ionicons.js') }}"></script>
    <script src="{{ url('../assets/lib/jquery.flot/jquery.flot.js') }}"></script>
    <script src="{{ url('../assets/lib/jquery.flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ url('../assets/lib/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ url('../assets/lib/jqvmap/maps/jquery.vmap.world.js') }}"></script>
    <script src="{{ url('../assets/lib/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>

    <script src="{{ url ('../assets/lib/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{ url ('../assets/lib/datatables.net-dt/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ url ('../assets/lib/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ url ('../assets/lib/datatables.net-responsive-dt/js/responsive.dataTables.min.js') }}"></script>

    <script src="{{ Module::asset('exam:lib/icheck/icheck.js') }}"></script>

    <script src="{{ url('../assets/js/azia.js') }}"></script>
    <script src="{{ url('../assets/js/dashboard.sampledata.js') }}"></script>
    @yield('script')
    <script>
      $(function(){
        'use strict'

        $('.az-sidebar .with-sub').on('click', function(e){
          e.preventDefault();
          $(this).parent().toggleClass('show');
          $(this).parent().siblings().removeClass('show');
        })

        $(document).on('click touchstart', function(e){
          e.stopPropagation();

          // closing of sidebar menu when clicking outside of it
          if(!$(e.target).closest('.az-header-menu-icon').length) {
            var sidebarTarg = $(e.target).closest('.az-sidebar').length;
            if(!sidebarTarg) {
              $('body').removeClass('az-sidebar-show');
            }
          }
        });


        $('#azSidebarToggle').on('click', function(e){
          e.preventDefault();

          if(window.matchMedia('(min-width: 992px)').matches) {
            $('body').toggleClass('az-sidebar-hide');
          } else {
            $('body').toggleClass('az-sidebar-show');
          }
        });

        new PerfectScrollbar('.az-sidebar-body', {
          suppressScrollX: true
        });

        /* ----------------------------------- */
        /* Dashboard content */


        $.plot('#flotChart1', [{
            data: dashData1,
            color: '#6f42c1'
          }], {
    			series: {
    				shadowSize: 0,
            lines: {
              show: true,
              lineWidth: 2,
              fill: true,
              fillColor: { colors: [ { opacity: 0 }, { opacity: 1 } ] }
            }
    			},
          grid: {
            borderWidth: 0,
            labelMargin: 0
          },
    			yaxis: {
            show: false,
            min: 0,
            max: 100
          },
    			xaxis: { show: false }
    		});

        $.plot('#flotChart2', [{
            data: dashData2,
            color: '#007bff'
          }], {
    			series: {
    				shadowSize: 0,
            lines: {
              show: true,
              lineWidth: 2,
              fill: true,
              fillColor: { colors: [ { opacity: 0 }, { opacity: 1 } ] }
            }
    			},
          grid: {
            borderWidth: 0,
            labelMargin: 0
          },
    			yaxis: {
            show: false,
            min: 0,
            max: 100
          },
    			xaxis: { show: false }
    		});

        $.plot('#flotChart3', [{
            data: dashData3,
            color: '#f10075'
          }], {
    			series: {
    				shadowSize: 0,
            lines: {
              show: true,
              lineWidth: 2,
              fill: true,
              fillColor: { colors: [ { opacity: 0 }, { opacity: 1 } ] }
            }
    			},
          grid: {
            borderWidth: 0,
            labelMargin: 0
          },
    			yaxis: {
            show: false,
            min: 0,
            max: 100
          },
    			xaxis: { show: false }
    		});

        $.plot('#flotChart4', [{
            data: dashData4,
            color: '#00cccc'
          }], {
    			series: {
    				shadowSize: 0,
            lines: {
              show: true,
              lineWidth: 2,
              fill: true,
              fillColor: { colors: [ { opacity: 0 }, { opacity: 1 } ] }
            }
    			},
          grid: {
            borderWidth: 0,
            labelMargin: 0
          },
    			yaxis: {
            show: false,
            min: 0,
            max: 100
          },
    			xaxis: { show: false }
    		});

        $.plot('#flotChart5', [{
            data: dashData2,
            color: '#00cccc'
          },{
            data: dashData3,
            color: '#007bff'
          },{
            data: dashData4,
            color: '#f10075'
          }], {
    			series: {
    				shadowSize: 0,
            lines: {
              show: true,
              lineWidth: 2,
              fill: false,
              fillColor: { colors: [ { opacity: 0 }, { opacity: 1 } ] }
            }
    			},
          grid: {
            borderWidth: 0,
            labelMargin: 20
          },
    			yaxis: {
            show: false,
            min: 0,
            max: 100
          },
    			xaxis: {
            show: true,
            color: 'rgba(0,0,0,.16)',
            ticks: [
              [0, ''],
              [10, '<span>Nov</span><span>05</span>'],
              [20, '<span>Nov</span><span>10</span>'],
              [30, '<span>Nov</span><span>15</span>'],
              [40, '<span>Nov</span><span>18</span>'],
              [50, '<span>Nov</span><span>22</span>'],
              [60, '<span>Nov</span><span>26</span>'],
              [70, '<span>Nov</span><span>30</span>'],
            ]
          }
    		});

        $.plot('#flotChart6', [{
            data: dashData2,
            color: '#6f42c1'
          },{
            data: dashData3,
            color: '#007bff'
          },{
            data: dashData4,
            color: '#00cccc'
          }], {
    			series: {
    				shadowSize: 0,
            stack: true,
            bars: {
              show: true,
              lineWidth: 0,
              fill: 0.85
              //fillColor: { colors: [ { opacity: 0 }, { opacity: 1 } ] }
            }
    			},
          grid: {
            borderWidth: 0,
            labelMargin: 20
          },
    			yaxis: {
            show: false,
            min: 0,
            max: 100
          },
    			xaxis: {
            show: true,
            color: 'rgba(0,0,0,.16)',
            ticks: [
              [0, ''],
              [10, '<span>Nov</span><span>05</span>'],
              [20, '<span>Nov</span><span>10</span>'],
              [30, '<span>Nov</span><span>15</span>'],
              [40, '<span>Nov</span><span>18</span>'],
              [50, '<span>Nov</span><span>22</span>'],
              [60, '<span>Nov</span><span>26</span>'],
              [70, '<span>Nov</span><span>30</span>'],
            ]
          }
    		});

        $('#vmap').vectorMap({
          map: 'world_en',
          showTooltip: true,
          backgroundColor: '#f8f9fa',
          color: '#ced4da',
          colors: {
            us: '#6610f2',
            gb: '#8b4bf3',
            ru: '#aa7df3',
            cn: '#c8aef4',
            au: '#dfd3f2'
          },
          hoverColor: '#222',
          enableZoom: false,
          borderOpacity: .3,
          borderWidth: 3,
          borderColor: '#fff',
          hoverOpacity: .85
        });

      });
    </script>
  </body>
</html>