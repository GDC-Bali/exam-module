@extends('exam::layouts.attempt')

@section('content')
<div class="container py-4">
    <div class="row d-flex justify-content-center">
        <div class="col-xl-5 col-lg-10 mb-4">
            <h5 class="h6 font-weight-bold text-center">Jenis Soal: <button class="btn btn-outline-success btn-sm disabled ml-3">{{$group->questions->first()->type->type}}</button></h5>
            <div class="row mt-4">
                @if ($from)   
                <div class="col d-flex justify-content-center">
                    <x-exam-info-item label="Ujian ini dimulai pada" :text="$from" icon="fa-clock" class="text-success my-auto"/>
                </div>
                @endif
                @if ($to)   
                <div class="col d-flex justify-content-center">
                    <x-exam-info-item label="Ujian ini berakhir pada" :text="$from" icon="fa-clock" class="text-danger my-auto"/>
                </div>
                @endif
            </div>
            <div class="row mt-4">
                <div class="col d-flex justify-content-center">
                    <x-exam-info-item label="Durasi" :text="$attempt->duration.' menit'" icon="fa-stopwatch" class="text-warning my-auto"/>
                </div>
                <div class="col d-flex justify-content-center">
                    <x-exam-info-item label="Jumlah soal" :text="$group->questions_no()" icon="fa-pencil-alt" class="text-info my-auto"/>
                </div>
            </div>
            <div class="mt-2">
                <div>
                    <center>
                        <a href="{{ route('exam.attempt.show', $attempt->id) }}" class="btn btn-lg btn-primary-darker btn-sm font-weight-bold px-5">Mulai</a>
                        {{-- <a href="{{route('exam.attempt.review',$attempt->id)}}"><button style="border-radius: 24px;" class="btn pl-5 pr-5 btn-primary">Pembahasan</button></a> --}}
                    </center>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection