<div class="az-content-header">
    <div class="az-content-header-top">
        <div>
            <h2 class="az-content-title mg-b-5 mg-b-lg-8">Hi, welcome back!</h2>
            <p class="mg-b-0">Your campaign monitoring dashboard template.</p>
        </div>
    </div><!-- az-content-body-title -->
    <div class="nav-wrapper">
    <nav class="nav az-nav-line">
        <li class="nav-item dropdown mr-4">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Group Soal</a>
            <div class="dropdown-menu">
            <a class="dropdown-item" href="{{route('exam.question-group.index')}}">Paket Soal</a>
            <a class="dropdown-item" href="{{route('exam.group-category.index')}}">Kategori</a>
            </div>
        </li>
        <li class="nav-item dropdown mr-4">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Bank Soal</a>
            <div class="dropdown-menu">
            <a class="dropdown-item" href="#">Soal-Soal</a>
            <a class="dropdown-item" href="#">Kategori</a>
            <a class="dropdown-item" href="{{route('exam.question-type.index')}}">Tipe Soal</a>
            </div>
        </li>
        <li class="nav-item">
            <a href="{{route('attempt.index')}}" class="nav-link">Percobaan/Attempt</a>
        </li>
    </nav>
    </div><!-- nav-wrapper -->
</div><!-- az-content-header -->