@extends('exam::layouts.attempt')
@section('style')
<link rel="stylesheet" href="{{Module::asset('exam:lib/circle-progress/circle-progress.css')}}">
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
    #number-slider {
        overflow-y: scroll;
    }
    .callout {
        border-radius: .25rem;
        box-shadow: 0 1px 3px rgba(0,0,0,.12), 0 1px 2px rgba(0,0,0,.24);
        background-color: #fff;
        padding: 1rem;
    }
    .div-nomor {
        margin:1px;
    }
    .option-text > p {
        margin: 0 !important;
    }    
</style>
@endsection
@section('content')
<div class="row mt-3">
    <div class="col-md-12 pt-3 mb-5">
        <div class="row">
            <div class="col-md-8">
<<<<<<< HEAD
                @component('exam::components.attempt-review-info', [
                    'type' => $type,
                    'hasil' => $hasil,
                    'attempt' => $attempt
                ])
                @endcomponent
                @component('exam::components.attempt-review-content', [
                    'group' => $group,
                    'attempt' => $attempt
                ])
                @endcomponent
                {{-- <x-exam-attempt-review-info :type='$type' :hasil='$hasil' :attempt='$attempt'/> --}}
                {{-- <x-exam-attempt-review-content :attempt="$attempt" :group='$group'/> --}}
            </div>    
            @component('exam::components.attempt-review-number', [
                'hasil' => $hasil
            ])
            @endcomponent        
            {{-- <x-exam-attempt-review-number :hasil="$hasil"/> --}}
=======
                <x-exam-attempt-review-info :type='$type' :hasil='$hasil' :attempt='$attempt'/>
                <x-exam-attempt-review-content :attempt="$attempt" :group='$group'/>
            </div>            
            <x-exam-attempt-review-number :hasil="$hasil"/>
>>>>>>> 8ba76e70022cef1a869f10e628614facb6b5eea1
        </div>        
    </div>
</div>
@endsection
@section('footer')
    <style>
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            height: 60px;
            line-height: 60px;
            background-color: #f5f5f5;
        }
    </style>
    <footer class="footer d-block d-md-none">
        <div class="container-fluid">
            <div class="row mt-3">                
                <div class="col-6 px-1 px-sm-2">
                    <a href="{{route('exam.attempt.result', $attempt->id)}}">
                        <button class="btn btn-block btn-sm btn-secondary font-weight-bold btn-soal">
                            KEMBALI
                        </button>
                    </a>
                </div>
                <div class="col-6 px-1 px-sm-2">
                    <button class="btn-skip btn btn-block btn-sm btn-primary font-weight-bold btn-soal">
                        SOAL BERIKUTNYA
                    </button>                
                </div>                
            </div>
        </div>
    </footer>
@endsection
@section('script')
<script src="{{Module::asset('exam:lib/circle-progress/circle-progress.js')}}"></script>
<script>    
    function getQuestion(number){
        $.ajax({
            url: "/exam/get-review/"+number+'/{{$attempt->id}}',
            type: 'GET',
            success: function (res){
                if(res.status){
                    showQuestion(res);
                }
            },
            error: function(err){
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!',                            
                })
            }
        }); 
    }

    function showQuestion(data){
        
        var user_answer;
        var soal = '';
        
        var nomor_soal = parseFloat(data.index);        
        if(data.data.type.type == "Essay"){
            if(data.ans !== null)
                ans = data.ans.answer;
            else
                ans = '';
            if({{$attempt->status}} != 3){
                    button_save = '<div class="row ml-1">'+
                                    '<div class="col-6">'+
                                        '<button id="btn-save-ans" class="btn btn-sm btn-success font-weight-bold" style="width:100%">SIMPAN NILAI</button>'+
                                    '</div>'+
                                    '<div class="col-6">'+
                                        '<button id="btn-final" type="button" class="btn btn-sm btn-primary font-weight-bold" style="width:100%">FINALISASI</button>'+
                                    '</div>'+
                                '</div>';
            }
            else
                button_save = '';
            var answer = '<p class="font-weight-bold">Jawaban</p>'+
                        '<div class="row">'+
                            '<div class="col-12" id="ans-user">'+
                                
                            '</div>'+
                            '<form action="{{url("exam/attempt/save-essay")}}/'+data.ans.id+'" id="save-ans" method="post" class="form-horizontal">'+
                                '{{csrf_field()}}'+
                                '<div class="form-group row ml-1 mt-5">'+
                                    '<label class="col-form-label col-sm-2">Nilai</label>'+                                    
                                    '<div class="col-sm-10">'+
                                        '<input name="point" type="number" min="0" max="100" step="1" value="'+data.ans.point+'">'+
                                    '</div>'+
                                '</div>'+
                                button_save+
                            '</form>'+
                        '</div>';
        } else {
            var answer = '<div class="form-check mt-2">';            
            $.each(data.option, function(i, option){                
                var value = ''                
                if(data.ans !== null){
                    if(data.ans !== undefined && data.ans.question_option_id == option.id){                    
                        value = 'bg-danger text-white';
                    }
                }
                if(option.option_value == 100)                
                    value = "bg-success text-white";
                answer += '<label class="pl-3 option-text"><input disabled type="radio" name="answer"/>'+
                    '<span class="'+value+' font-weight-bold">'+String.fromCharCode(65 + i)+'</span>'+
                    option.option_text+
                '</label>';
            })
            answer+='</div>';
        }
        soal += '<div data-number='+nomor_soal+' id="numbers" class="row align-items-center py-3">'+
                '<div class="col-6">'+
                    '<p class="font-weight-bold m-0">Soal Nomor : '+
                        nomor_soal+
                    '</p>'+
                '</div>'+
                '<div class="col-6">'+
                    '<a href="#" class="d-block d-md-none text-right font-weight-bold" data-toggle="modal" data-target="#exampleModalLong">Lihat Semua Soal</a>'+
                '</div>'+
            '</div>'+
            '<div class="row text-left mb-5">'+
                '<div class="col-12">'+
                    data.data.question_text+
                    answer+
                '</div>'+                
            '</div>'+
            '<div class="row text-left mb-5">'+                
                '<div id="feedback" class="col-12">'+
                    '<p class="mb-3 mt-5 font-weight-bold m-0">Pembahasan : '+
                    '</p>'+
                    data.data.feedback+
                '</div>'+                
            '</div>';        
        $('#soal-container').html(soal);
        $('#soal-container #feedback img').addClass('img-thumbnail');
        $('#soal-container #ans-user img').addClass('img-thumbnail');
        if(data.data.type.type == 'Essay'){
            if({{$attempt->status}} == 3)
            $("input[type='number']").attr('disabled', true);
            $('#ans-user').html(ans);
            $("input[type='number']").inputSpinner();
        }
    }

    $(document).ready(function(){
        getQuestion(1);        
    });

    $(document).on('click','.btn-number',function(){
        var number = $(this).attr('data-number');
        getQuestion(number);
    });

    $(document).on('click', '.btn-skip',function(){
        var number = $('#numbers').attr('data-number');
        number++;        
        getQuestion(number);
        $("html, body").animate({ scrollTop: 200 }, "slow");
    });

    $(document).on('submit','#soal-container #save-ans', function(e){
        e.preventDefault();        
        $('#soal-container #save-ans #btn-save-ans').attr('disabled', true);
        $('#soal-container #save-ans #btn-save-ans').text('MENYIMPAN...');
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            success: function (res){
                $('#soal-container #save-ans #btn-save-ans').attr('disabled', false);
                $('#soal-container #save-ans #btn-save-ans').text('SIMPAN NILAI');
                if(res.status){
                    $('#nilai_salah').text(res.hasil['salah']);
                    $('#nilai_benar').text(res.hasil['benar']);
                    $('#essayValue').text(res.hasil['nilai']);
                    var number = $('#numbers').attr('data-number');
                    $('a[data-number="'+number+'"]').removeClass("btn-danger");
                    $('a[data-number="'+number+'"]').removeClass("btn-light");
                    $('a[data-number="'+number+'"]').addClass("btn-success");
                    Swal.fire({
                        icon: 'success',
                        text: 'Nilai berhasil disimpan',
                    })
                }
            },
            error: function(err){
                $('#soal-container #save-ans #btn-save-ans').attr('disabled', false);
                $('#soal-container #save-ans #btn-save-ans').text('SIMPAN NILAI');
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!',                            
                })
            }
        });                 
    })

    $(document).on('click','#soal-container #save-ans #btn-final', function(e){
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-default'
            },
            buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: 'Ubah status menjadi sudah diperiksa?',
            text: "Semua nilai akan disimpan dan tidak dapat diubah kembali",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, simpan dan selesai',
            cancelButtonText: 'Periksa kembali',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "{{route('exam.attempt.finalisasiessay', $attempt->id)}}",
                    type: "GET",
                    data: {
                        _token: "{{ csrf_token() }}",                        
                    },
                    success: function(res){
                        if(res.status){
                            window.location.href = '/exam/attempt/{{$attempt->id}}/result';
                        }else{
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: res.message,
                            })
                        }
                    },
                    error: function(err){
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!',
                        })
                    }
                });
            } else(
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            )
        });
    });
</script>
@endsection