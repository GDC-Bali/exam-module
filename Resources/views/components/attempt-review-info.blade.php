<style>
    .progress{
        width: 100px !important;
        height: 100px !important;
    }
</style>
<div class="row">
    <div class="col-lg-6 col-md-10">
        <div class="callout">
            <div class="row">                
                <div class="progress mx-auto" data-value='{{$attempt->grade}}'> <span class="progress-left"> <span class="progress-bar border-success"></span> </span> <span class="progress-right"> <span class="progress-bar border-success"></span> </span>
                    <div class="progress-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center">
                        @if($type == 'Essay')
                        <div id="essayValue" class="h6 font-weight-bold">{{number_format($attempt->grade,0)}}</div>
                        @else
                        <div class="h6 font-weight-bold">{{number_format($attempt->grade,0)}}/100</div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-4 text-center">                    
                    <small>{{$type == 'Essay' ? "Sudah Dinilai" : "Jawaban Benar"}}</small>
                    <div>
                        <span class="text-success"><i class='fa fa-circle '></i></span>
                        <span id="nilai_benar" class="m-0 font-weight-bold">{{$hasil['benar']}}</span>
                    </div>
                </div>
                <div class="col-4 text-center">
                    <small>{{$type == 'Essay' ? "Belum Dinilai" : "Jawaban Salah"}}</small>
                    <div>
                        <span class="text-danger"><i class='fa fa-circle '></i></span>            
                        <span id="nilai_salah" class="m-0 font-weight-bold">{{$hasil['salah']}}</span>
                    </div>
                </div>
                <div class="col-4 text-center">
                    <small>Belum Dijawab</small>
                    <div>
                        <span class="text-secondary"><i class='fa fa-circle '></i></span>
                        <span class="m-0 font-weight-bold">{{$hasil['belum_dijawab']}}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>                    
</div>
<div id="number-slider" class="d-flex d-md-none flex-row mt-3">
    @foreach($hasil['no'] as $key => $val)
        @if($val == 1)
            <div class="m-1"><a href="javascript:void(0);" class="btn btn-success btn-sm btn-number font-weight-bold px-3" data-number="{{$key}}">{{$key}}</a></div>    
        @elseif($val == -1)
            <div class="m-1"><a href="javascript:void(0);" class="btn btn-danger btn-sm btn-number font-weight-bold px-3" data-number="{{$key}}">{{$key}}</a></div>            
        @elseif($val == 0)
            <div class="m-1"><a href="javascript:void(0);" class="btn btn-light btn-sm btn-number font-weight-bold px-3" data-number="{{$key}}">{{$key}}</a></div>    
        @endif
    @endforeach
</div>