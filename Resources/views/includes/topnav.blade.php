<div class="row mb-2">
    <div class="col">
        <div class="nav-wrapper">
            <nav class="navbar navbar-expand-lg navbar-dark {{config('exam.navbar-class', 'bg-dark')}}">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
              
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                  <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a href="{{route('exam.dashboard')}}" class="nav-link">Dashboard</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Paket Soal</a>
                        <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{route('exam.question-group.index')}}">List Paket Soal</a>
                        <a class="dropdown-item" href="{{route('exam.group-category.index')}}">Kategori</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Bank Soal</a>
                        <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{route('exam.questions.index')}}">Soal-Soal</a>
                        <a class="dropdown-item" href="{{route('exam.question-category.index')}}">Kategori</a>
                        <a class="dropdown-item" href="{{route('exam.question-type.index')}}">Tipe Soal</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('attempt.index')}}" class="nav-link">Percobaan/Attempt</a>
                    </li>
                  </ul>
                </div>
            </nav>
        </div>
    </div>
</div>