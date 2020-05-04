@extends('exam::layouts.master')

@section('content_exam')
    <div class="card p-3">        
        <div class="row">
            <div class="col-sm-12 col-xl-12">
                <form id="form" action="{{route('exam.questions.update', $data->id)}}" method="POST">
                    {{ csrf_field() }}
                    @method('PUT')
                    <div id="smartwizard">
                        <ul>
                            <li><a href="#step-1">Tipe Soal<br /><small>Step description</small></a></li>
                            <li><a href="#step-2">Detail Soal<br /><small>Step description</small></a></li>
                            <li><a href="#step-3">Jawaban<br /><small>Step description</small></a></li>
                            <li><a href="#step-4">Pembahasan<br /><small>Step description</small></a></li>
                        </ul>
                    
                        <div>
                            <div id="step-1" class="">
                                <div class="form-group row">
                                    <label for="question_type_id" class="col-md-2 offset-md-2 col-form-label">Tipe Soal</label>
                                    <div class="col-md-4">
                                        <select name="question_type_id" id="question_type_id" class="form-control" style="width:100%">
                                            <option onchange="jawaban(this.value)" hidden value=""></option>
                                            @foreach($tipe as $val)
                                                <option {{$data->question_type_id == $val->id ? 'selected' : ''}} value="{{$val->id}}">{{$val->type}}</option>
                                            @endforeach
                                        </select>
                                        {{-- <small id="questionTypeHelp" class="form-text text-muted"><i class="fas fa-exclamation-circle"></i>&nbsp;Pilih tipe soal untuk melanjutkan</small> --}}
                                    </div>
                                </div>    
                            </div>
                            <div id="step-2" class="">
                                <div class="form-group row">
                                    <label for="code" class="col-md-2 col-form-label">Kode Soal <sup class="text-danger">*</sup></label>
                                    <div class="col-md-10">
                                        <input type="text" name="code" class="form-control" id="code" placeholder="Enter code" value="{{$data->code}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="competencies" class="col-md-2 col-form-label">Kompetensi</label>
                                    <div class="col-md-10">
                                        <input type="text" name="competencies" class="form-control" id="competencies" placeholder="Enter competency" value="{{$data->competencies}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="question_category_id" class="col-md-2 col-form-label">Kategori</label>
                                    <div class="col-md-10">
                                        <select name="question_category_id" id="question_category_id" class="form-control" style="width:100%">
                                            <option hidden value=""></option>
                                            @foreach($category as $val)
                                                <option {{$data->question_category_id == $val->id ? 'selected' : ''}} value="{{$val->id}}">{{$val->type}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="question_text" class="col-md-2 col-form-label">Pertanyaan</label>
                                    <div class="col-md-10">
                                        <textarea name="question_text" id="question_text" class="form-control" cols="30" rows="3">{!! $data->question_text !!}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="additional_note">Catatan Tambahan</label>  
                                    <div class="col-md-10">
                                        <textarea class="form-control" name="additional_note" id="additional_note">{!! $data->additional_note !!}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div id="step-3" class="">                                
                                {{-- tipe pilihan ganda --}}
                                <div id="multiple_choice" style="">
                                    <div class="form-group row">
                                        <label class="col-md-2 col-form-label" for="randomize_option">Acak Pilihan</label>  
                                        <div class="col-md-10">
                                            <input {{$data->randomize_option == 1 ? 'selected' : ''}} type="checkbox" name="randomize_option" data-toggle="toggle" data-size="sm" data-on="Ya" data-off="Tidak" data-onstyle="success" data-offstyle="default">
                                        </div>
                                    </div>
                                    <div class="form-group row" style="display:none">
                                        <label class="col-md-2 col-form-label" for="single_answer">Jawaban Lebih Dari Satu</label>  
                                        <div class="col-md-10">
                                            <input {{$data->single_answer == 1 ? 'selected' : ''}} type="checkbox" name="single_answer" data-toggle="toggle" data-size="sm" data-on="Ya" data-off="Tidak" data-onstyle="success" data-offstyle="default">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-2 col-form-label" for="option">Option</label>  
                                        <div class="col-md-12">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Option Text</th>
                                                        <th>Option Value</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="option_body">
                                                    @foreach($data->question_option as $key => $val)
                                                    <tr>
                                                        <td style="width:90%"><textarea id="option_{{($key+1)}}" name="option_text[]" type="text" class="form-control option">{!! $val->option_text !!}</textarea></td>
                                                        {{-- <td style="width:20%"><input name="option_value" type="text" class="form-control"></td> --}}
                                                        <td style="width:5%"><input name="radio" type="radio" onchange="check_value(this)" class="radio" {{$val->option_value == 100 ? 'checked' : ''}}></td>
                                                        <td class="option_value"><input type="hidden" name="option_value[]" value="{{$val->option_value}}"></td>
                                                        <td style="width:5%"></td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="2"><x-exam-button-icon onclick="addOption()" text="Tambah Option" icon="fa-plus" class="btn btn-xs btn-success"/></td>
                                                    </tr>
                                                </tfoot>
                                            </table>                                        
                                        </div>
                                    </div>
                                    {{-- tipe pilihan ganda --}}
                                </div>

                                <div id="essay" style="">
                                    {{-- essay --}}
                                    <div class="form-group row">
                                        <label class="col-md-2 col-form-label" for="allow_blank">Jawaban Kosong</label>  
                                        <div class="col-md-10">
                                            <input type="checkbox" name="allow_blank" data-toggle="toggle" data-size="sm" data-on="Boleh" data-off="Tidak Boleh" data-onstyle="success" data-offstyle="default">
                                        </div>
                                    </div>
                                    {{-- essay --}}
                                </div>
                            </div>
                            <div id="step-4" class="">
                                <div class="form-group row">
                                    <label for="desc" class="col-md-2 col-form-label">Pembahasan</label>
                                    <div class="col-md-10">
                                        <textarea name="feedback" id="feedback" class="form-control" cols="30" rows="3">{!! $data->feedback !!}</textarea>
                                        <small id="availabilityHelp" class="form-text text-muted">Pembahasan ditampilkan setelah user menyelesaikan ujian</small>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-10 offset-md-2">
                                        {{-- <x-exam-button-icon type="a" text="Kembali" icon="fa-chevron-circle-left" :link="url()->previous()" class="btn-secondary btn-sm"/> --}}
                                        {{-- <x-exam-button-icon type="submit" id="submit" text="Simpan" icon="fa-paper-plane" class="btn-success btn-sm"/> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>            
            <div class="col-sm-12 col-xl-12">
                  
            </div><!-- col -->
        </div><!-- row -->
    </div><!-- az-content-body -->
    <input type="hidden" value="{{count($data->question_option)}}" id="option_count">

    <template>
        <tr>
            <td style="width:90%"><textarea name="option_text[]" type="text" class="form-control" id=""></textarea></td>
            {{-- <td style="width:20%"><input name="option_value" type="text" class="form-control"></td> --}}
            <td style="width:5%"><input name="radio" type="radio" onchange="check_value(this)" class="radio"></td>
            <td class="option_value"><input type="hidden" name="option_value[]" value="0"></td>
            <td style="width:5%"><button onclick="delete_option(this)" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button></td>
        </tr>
    </template>

@endsection
@section('script_exam')
<script>
    function addOption(){
        temp = document.getElementsByTagName("template")[0];
        clon = temp.content.cloneNode(true);        
        count = parseInt($('#option_count').val())+1;
        $('#option_count').val(count);
        $(clon).find('textarea').prop('id','option_'+count);        
        $('#option_body').append(clon);
        CKEDITOR.replace('option_'+count,{
            height: '150px',
        });
    }
    function delete_option(input){
        $(input).closest('tr').remove();
    }    
    function check_value(radio){
        $('td.option_value > input').val(0);
        $(radio).closest('tr').children('td.option_value').children('input').val(100);        
    }
    $(document).ready(function(){
        // $('#step-1').click();
        if($('#question_type_id').val() == 2)
            $('#multiple_choice').hide();
        else if($('#question_type_id').val() == 1)
            $('#essay').hide();
        $(document.body).on("change","#question_type_id",function(){
            val = this.value;            
            $('.sw-btn-next').prop('disabled', false);
            if(val == 1){
                $('#multiple_choice').show();
                $('#essay').hide();
            }else if(val == 2){
                $('#multiple_choice').hide();
                $('#essay').show();
            }
        });
        $('#smartwizard').smartWizard({
            theme: 'dots',
            useURLhash: true,
            lang: {  // Language variables
                next: 'Berikutnya',
                previous: 'Sebelumnya'
            },
            anchorSettings: {
                anchorClickable: true, // Enable/Disable anchor navigation
                enableAllAnchors: true, // Activates all anchors clickable all times
                markDoneStep: true, // add done css
                enableAnchorOnDoneStep: true // Enable/Disable the done steps navigation
            },            
            toolbarSettings: {
                toolbarExtraButtons: [
                    $('<button id="submit"></button>').text('Simpan')
                    .addClass('btn btn-success')
                    .on('click', function(){
                        // $('#form').submit();
                    }),
                ],
            },
        });
        $('#smartwizard li:not(.active)').addClass("done");        
        $('#question_category_id, #question_type_id').select2({
            allowClear : true,
            placeholder : 'Select one',
            width: 'resolve',
        });
        CKEDITOR.replace('question_text',{
            filebrowserUploadMethod   : "form",
            filebrowserUploadUrl      : "{{route('exam.questions.image_upload', ['_token' => csrf_token()])}}",
        });
        CKEDITOR.replace('feedback',{
            filebrowserUploadMethod   : "form",
            filebrowserUploadUrl      : "{{route('exam.questions.image_upload', ['_token' => csrf_token()])}}",
        });
        @foreach($data->question_option as $key => $val)       
        CKEDITOR.replace('option_{{($key+1)}}',{
            height: '150px',
        });
        @endforeach
        $("input[type='number']").inputSpinner();
        $('#form').on('submit', function(e){
            for(var i in CKEDITOR.instances) CKEDITOR.instances[i].updateElement();
            e.preventDefault();
            $('#submit').prop('disabled', true);
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                data: $(this).serialize(),
                success: function (res){
                    $('#submit').prop('disabled', false);
                    if(res.status){                        
                        window.location.href = "{{route('exam.questions.index')}}";
                    }
                },
                error: function(err){
                    $('#submit').prop('disabled', false);
                    var response = JSON.parse(err.responseText);
                    var errorString = '';
                    $.each( response.message, function( key, value) {
                        errorString += value + "<br>";
                    });
                    Swal.fire({
                        icon: 'error',
                        title: errorString,                        
                    })
                }
            }); 
        });
    });

    $("#smartwizard").on("showStep", function(e, anchorObject, stepNumber, stepDirection, stepPosition) {
        if(stepPosition === 'first'){
            $("#prev-btn").addClass('disabled');
            $("#submit").hide();
        }else if(stepPosition === 'final'){
            $("#next-btn").hide();
            $("#submit").show();
        }else{
            $("#submit").show();
            $("#next-btn").show();
            $("#prev-btn").removeClass('disabled');
        }
    }); 
</script>
@endsection