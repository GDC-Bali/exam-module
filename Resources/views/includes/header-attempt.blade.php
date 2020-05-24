<style>
    .btn-circle {
        margin-top: .5rem;
        background: #ffffff;
        color: #007bff;
        width: 40px;
        height: 40px;
        text-align: center;
        padding: 6px 0;
        font-size: 16px;
        /* line-height: 1.428571429; */
        border-radius: 20px;
    }
    .page-header { background: url(/modules/exam/img/banner.jpg)no-repeat; position: relative; background-size: cover; }
    .page-caption { padding-top: 100px; padding-bottom: 100px; }
    .page-title { line-height: 1; color: #fff; font-weight: 600; text-align: center; }
</style>
<header>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-transparent" id="navbar-exam">
        <a class="btn btn-circle" href="{{url()->previous()}}"><i class="fas fa-arrow-left"></i></a>
        {{-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button> --}}
        {{-- <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#"></span></a>
                </li>
            </ul>
        </div> --}}
    </nav>
    <div class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="page-caption">
                        <h2 class="page-title">{{$attempt->title}}</h2>
                        <h5 class="page-title">{{$attempt->subtitle}}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>