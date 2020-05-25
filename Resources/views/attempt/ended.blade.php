@extends('exam::layouts.attempt')

@section('content')
<div class="container py-4">
    <div class="row d-flex justify-content-center">
        <div class="col-md-10 mb-3">
            <div class="row mt-4 align-items-center">
                <div class="col-md-6">
                    <img src="/modules/exam/img/gambar_ujian_berakhir.svg">
                </div>
                <div class="col-md-6 justify-content-center">
                    <h3 class="text-center">Maaf ujian ini telah berakhir</h3>
                    <p class="text-center">{{$ended_at}}</p>
                    @if (count($history)>0)
                    <p class="text-center"><a href="{{route('attempt.history', [$user, $exam])}}" class="btn btn-primary-darker px-5 text-center">Lihat Hasil</a></p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection