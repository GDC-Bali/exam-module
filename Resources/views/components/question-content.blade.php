<style>
    label {
        display: block;
        padding: 5px;
        position: relative;
    }
    label input {display: none;}
    label:hover {
        cursor: pointer;
    }
    label span {
        background-color: #eeeeee;
        width: 25px; 
        height: 25px; 
        position: absolute; 
        overflow: hidden; 
        line-height: 1; 
        text-align: center; 
        border-radius: 5px; 
        font-size: 11pt; 
        left: 0; 
        top: 50%; 
        margin-top: -11px;
    }
    input + span {
        margin-left: -20px;
        padding: 5px;
        color: #919191;
    }
    input:checked + span {
        background: #5999ff; 
        color: #ffffff; 
        border-color: #ccf;
    }
    #div-scroll-number {
        overflow-y: scroll;
    }
</style>

@foreach ($questions as $key=>$page)
    @if($loop->first)
        @foreach ($page as $key2=>$question)
            <div class="row align-items-center py-3">
                <div class="col-6">
                    <p class="font-weight-bold m-0">Soal Nomor : {{$key2+1}}</p>
                </div>
                <div class="col-6">
                    <a href="#" class="d-block d-md-none text-right font-weight-bold" data-toggle="modal" data-target="#exampleModalLong">Lihat Semua Soal</a>
                </div>
            </div>
            <div class="row text-left mb-5">
                <div class="col-md-8">
                    {!! $question->question_text !!}
                    @if ($question->type->type == "Essay")
                        <x-exam-answer-essay/>
                    @else
                        @php
                            $options = $question->question_option()->get();
                        @endphp
                        <x-exam-answer-option :options="$options"/>
                    @endif
                </div>
            </div>
        @endforeach
    @endif
@endforeach

<div class="row d-none d-md-flex mt-4 mb-5">
    <div class="my-1 mr-2">
        <meta name="_token" content="{{ csrf_token() }}"/>
        <button id="btn-save" class="btn btn-primary font-weight-bold" >
            SIMPAN & LANJUTKAN
        </button>
    </div>
    <div class="my-1">
        <button class="btn btn-secondary font-weight-bold">
            LEWATKAN SOAL
        </button>
    </div>
</div>