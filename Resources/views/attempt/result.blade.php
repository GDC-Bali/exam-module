@extends('exam::layouts.attempt')

@section('content')
<link rel="stylesheet" href="{{Module::asset('exam:lib/circle-progress/circle-progress.css')}}">
<div class="container py-4">
    <div class="row d-flex justify-content-center">
        <div class="col-xl-5 col-lg-10 mb-4">
            <h2 class="h6 font-weight-bold text-center">{{$attempt->title}}</h2>
            <h2 class="h6 text-center mb-4">Total Nilai Anda Adalah</h2>
            <div class="progress mx-auto" data-value='{{$attempt->grade}}'> <span class="progress-left"> <span class="progress-bar border-success"></span> </span> <span class="progress-right"> <span class="progress-bar border-success"></span> </span>
                <div class="progress-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center">
                    @if($type == 'Essay')
                        <div class="h2 font-weight-bold">{{number_format($attempt->grade,0)}}</div>
                    @else
                        @if($attempt->group->grade_formula == 1)
                        <div class="h2 font-weight-bold">{{number_format($attempt->grade,0)}}/100</div>
                        @elseif($attempt->group->grade_formula == 2)
                        <div class="h2 font-weight-bold">{{number_format($attempt->grade,0)}}</div>
                        @endif
                    @endif
                </div>
            </div>
            <div class="card mt-3 p-3 shadow">
                <div class="row text-center">
                    <div class="col">
                        <div class="text-group">
                            <div style="font-size: 14px">
                                <small class="text-secondary">Soal Dijawab</small>                        
                            </div>
                            <span class="text-primary">
                                <i class='fa fa-circle '></i>
                            </span>
                            <span class="font-weight-bold">
                                {{count($attempt->answer)}}/{{$attempt->question_total}}
                            </span>
                        </div>
                    </div>
                    <div class="col">
                        <div class="text-group">
                            <div style="font-size: 14px">
                                <small class="text-secondary">{{$type == 'Essay' ? "Jawaban Dinilai" : "Jawaban Benar"}}</small>
                            </div>
                            <span class="text-success">
                                <i class='fa fa-circle '></i>
                            </span>
                            <span class="font-weight-bold">
                                {{$hasil['benar']}}
                            </span>
                        </div>
                    </div>
                    <div class="col">
                        <div class="text-group">
                            <div style="font-size: 14px">
                                <small class="text-secondary">{{$type == 'Essay' ? "Belum Dinilai" : "Jawaban Salah"}}</small>
                            </div>
                            <span class="text-danger">
                                <i class='fa fa-circle '></i>
                            </span>
                            <span class="font-weight-bold">
                                {{$hasil['salah']}}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-5 mx-auto">
                    <div class="card bg-warning mt-3 p-1 text-center shadow text-white">
                        <div>
                            <small class="font-weight-bold">Waktu Pengerjaan</small>
                        </div>
                        <div>
                            <small class="font-weight-bold">{{$attempt->getWaktu()}}</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-5">
                <div>
                    <center><a href="{{route('exam.attempt.review',$attempt->id)}}"><button class="btn pl-5 pr-5 btn-primary btn-primary-darker">Pembahasan</button></a></center>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{Module::asset('exam:lib/jquery/jquery.min.js')}}"></script>
<script src="{{Module::asset('exam:lib/circle-progress/circle-progress.js')}}"></script>
@endsection