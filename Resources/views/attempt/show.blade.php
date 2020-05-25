@extends('exam::layouts.attempt')

@section('style')
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

        {{-- <x-exam-question-info :totalquestions="$totalquestions"/> --}}
        <div class="row">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-lg-6 col-md-10">
                        <div class="callout">
                            <div class="row">
                                <div class="col-6 text-left">
                                    <small>Sisa Waktu</small>
                                    <h3 id="timer-attempt" class="font-weight-bold text-warning">--:--:--</h3>
                                </div>
                                <div class="col-6 text-right align-self-center">
                                    <button id="btn-finish" type="button" class="btn btn-danger btn-sm px-3 font-weight-bold">Akhiri Ujian</button>
                                </div>
                            </div>
                            <hr class="my-2">
                            <div class="row">  
                                <div class="col-4 text-center">
                                    <small>Jumlah Soal</small>
                                    <h5 id="info-total-questions" class="m-0 font-weight-bold"></h5>
                                </div>
                                <div class="col-4 text-center">
                                    <small>Sudah Dijawab</small>
                                    <h5 id="info-answered-questions" class="m-0 font-weight-bold"></h5>
                                </div>
                                <div class="col-4 text-center">
                                    <small>Belum Dijawab</small>
                                    <h5 id="info-unanswered-questions" class="m-0 font-weight-bold"></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="number-slider" class="d-flex d-md-none flex-row mt-3">
            
                </div>
                        
                <div id="soal-container">
                    
                </div>
                
                <div class="d-none d-md-flex mt-4 mb-5">
                    <div class="my-1 mr-2">
                        <meta name="_token" content="{{ csrf_token() }}"/>
                        <button class="btn-save btn btn-primary font-weight-bold btn-soal" data-number="1">
                            SIMPAN & LANJUTKAN
                        </button>
                    </div>
                    <div class="my-1">
                        <button class="btn-skip btn btn-secondary font-weight-bold btn-soal">
                            LEWATKAN SOAL
                        </button>
                    </div>
                </div>
            </div>

            {{-- <x-exam-question-numbers :totalquestions="$totalquestions"/> --}}
            <div class="col-md-4 d-none d-md-block" id="nomor-soal">
                <p class="font-weight-bold">Nomor Soal</p>
                <div class="row px-2 py-0 questions-number">
                    
                </div>
            </div>
            <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title font-weight-bold" id="exampleModalLongTitle">Nomor Soal</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                    <div class="modal-body">
                        <div class="row px-2 py-0 justify-content-center questions-number">
                            
                        </div>
                    </div>
                  </div>
                </div>
            </div>
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
                    <button class="btn-save btn btn-block btn-sm btn-primary font-weight-bold btn-soal">
                        SIMPAN & LANJUTKAN
                    </button>
                </div>
                <div class="col-6 px-1 px-sm-2">
                    <button class="btn-skip btn btn-block btn-sm btn-secondary font-weight-bold btn-soal">
                        LEWATI SOAL
                    </button>
                </div>
            </div>
        </div>
    </footer>
@endsection

@section('script')
<script>
    var attempt_id = duration = started_at = ended_at = null;
    const zeroPad = (num, places) => String(num).padStart(places, '0')
    // function saveNewAttempt(group_id){
    //     $.ajax({
    //         url: "/attempt",
    //         type: 'POST',
    //         data: {
    //             '_token': "{{ csrf_token() }}",
    //             'question_group_id': group_id
    //         },
    //         success: function (res){
    //             console.log('attempt saved');
    //             attempt_id = res['attempt_id'];
    //         },
    //         error: function(err){
    //             Swal.fire({
    //                 icon: 'error',
    //                 title: 'Oops...',
    //                 text: 'Something went wrong!',                            
    //             })
    //         }
    //     }); 
    // }

    function getQuestion(number){
        $.ajax({
            url: "/get-attempt/"+number,
            type: 'GET',
            success: function (res){
                if(res){
                    if(res['finish']){
                        finishAttempt();
                    } else {
                        showQuestion(res);
                    }
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
        $("#info-total-questions").html(data['total_questions']);
        $("#info-answered-questions").html(data['total_answers']);
        $("#info-unanswered-questions").html(data['total_questions']-data['total_answers']);
        var numbers = '';
        var number_slider = '';
        var soal = '';
        $(".btn-soal").attr('data-number', ( (data['current_page']*data['per_page']) + 1 ) );

        $.each(data['all_questions'], function(i, value) {
            var btn_class = 'btn-light';
            if((value in data['answers'])){
                btn_class = 'btn-success text-white';
            }
            numbers += '<div class="col-2 p-1 div-nomor">'+
                    '<button class="btn btn-block '+btn_class+' d-flex justify-content-center btn-number" data-number="'+(i+1)+'"><small class="m-0 align-self-center font-weight-bold">'+(i+1)+'</small></button>'+
                '</div>';
            number_slider += '<div class="m-1"><a href="#" class="btn btn-sm '+btn_class+' btn-number font-weight-bold px-3" data-number="'+(i+1)+'">'+(i+1)+'</a></div>';
        });
        // for(var i = 0; i < data['total_questions']; i++){
        //     console.log();
        // }
        $('.questions-number').html(numbers);
        $('#number-slider').html(number_slider);
        $.each(data['questions'], function(index, question){
            var user_answer;
            if((question['id'] in data['answers'])){
                user_answer = data['answers'][question['id']];
            }
            // console.log(answer);
            var nomor_soal = parseFloat(index)+1;
            var question_id = question['id'];
            if(question['type']['type'] == "Essay"){
                var answer_value = '';
                if(user_answer !== undefined){
                    answer_value = user_answer.answer;
                }
                var answer = '<p class="font-weight-bold">Jawaban</p>'+
                            '<div class="row">'+
                                '<div class="col-12">'+
                                    '<textarea class="form-control essay-answer" style="min-width: 100%" rows="10" name="answer" data-question="'+question_id+'">'+answer_value+'</textarea>'+
                                '</div>'+
                            '</div>';
            } else {
                var answer = '';
                $.each(question['question_option'], function(i, option){
                    var checked = '';
                    if(user_answer !== undefined && user_answer.question_option_id == option['id']){
                        checked = 'checked';
                    }
                    // if(user_answer !== undefined && )
                    answer += '<label class="pl-3 option-text"><input type="radio" name="answer" value="'+option['id']+'" data-question="'+question_id+'" '+checked+'/>'+
                        '<span class="font-weight-bold">'+String.fromCharCode(65 + i)+'</span>'+
                        option['option_text']+
                    '</label>';
                })
            }
            soal += '<div id="no-'+nomor_soal+'" class="row align-items-center py-3">'+
                    '<div class="col-6">'+
                        '<p id="no-'+nomor_soal+'" class="font-weight-bold m-0">Soal Nomor : '+
                            nomor_soal+
                        '</p>'+
                    '</div>'+
                    '<div class="col-6">'+
                        '<a href="#" class="d-block d-md-none text-right font-weight-bold" data-toggle="modal" data-target="#exampleModalLong">Lihat Semua Soal</a>'+
                    '</div>'+
                '</div>'+
                '<div class="row text-left mb-5">'+
                    '<div class="col-12">'+
                        question['question_text']+
                        '<div class="form-check mt-2">'+
                            '<form action="#" method="POST">'+
                                answer+
                            '</form>'+
                        '</div>'+
                    '</div>'+
                '</div>'; 
        });
        $('#soal-container').html(
            soal
        ); 
    }

    function saveAnswers(){
        var answers = [];
        $('.essay-answer').map(function(){
            answers.push({
                question_id: $(this).attr('data-question'),
                answer_text: $(this).val()
            });
        });
        $('input:checked').map(function(){
            answers.push({
                question_id: $(this).attr('data-question'),
                question_option_id: $(this).val()
            });
        });
        if(answers.length != 0){
            $.ajax({
                url: "/attempt/save-answer",
                type: 'POST',
                data: {
                    '_token': "{{ csrf_token() }}",
                    'attempt_id': attempt_id,
                    'answers': answers
                },
                success: function (res){
                    console.log(res);
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
    }
    $(document).ready(function(){
        var per_page = 1;
        attempt_id = @json($id);
        duration = @json($attempt->duration);
        var started = @json($attempt->start_at);
        
        if(!duration){
            $('#timer-attempt').html('-');
        } else {
            var dateTime = new Date(started);
            var started_at = moment(dateTime).format('YYYY-MM-DD HH:mm:ss');
            var ended_at = moment(dateTime).add(duration, 'minutes').format('YYYY-MM-DD HH:mm:ss');
            var countDownDate = new Date(ended_at).getTime();
            var x = setInterval(function() {
                // Get today's date and time
                var now = new Date().getTime();
                
                // Find the distance between now and the count down date
                var distance = countDownDate - now;
                
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                
                // Output the result in an element with id="demo"
                $("#timer-attempt").html(zeroPad(hours,2) + ":" + zeroPad(minutes,2) + ":" + zeroPad(seconds,2));
                
                // If the count down is over, write some text 
                if (distance < 0) {
                clearInterval(x);
                    $("#timer-attempt").html("Waktu Habis");
                    requestFinish();
                }
            }, 1000);
        }

        var group_id = @json($group->id);

        getQuestion(1);

        $('.btn-save').on('click', function(e){
            saveAnswers();
            var number = $(this).attr('data-number')
            setTimeout(function(){
                getQuestion(number);
            }, 500);
        });

        $('#btn-finish').on( 'click', function () {
            finishAttempt();
        });
    });

    $(document).on('click','.btn-number, .btn-skip',function(){
        var number = $(this).attr('data-number');
        getQuestion(number);
        // setTimeout(function(){
        //     $('html, body, main').animate({
        //         scrollTop: $("#no-"+number).offset().top -50
        //     }, 500);
        // }, 500);
    });

    function requestFinish(){
        $.ajax({
            url: "{{route('attempt.finish')}}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: attempt_id
            },
            success: function(res){
                if(res.status){
                    $(window).unbind('beforeunload');
                    window.location.href = '/attempt/'+attempt_id+'/result';
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

    finishAttempt = function(){
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-default'
            },
            buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: 'Simpan dan akhiri menjawab soal?',
            text: "Semua jawaban anda akan disimpan dan tidak dapat diubah kembali",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, simpan dan selesai',
            cancelButtonText: 'Periksa kembali',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                requestFinish();
            } else(
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            )
        });
    }

    $(window).bind('beforeunload',function(){
        return "";
    });
</script>
@endsection