@extends('exam::layouts.master')

@section('content')
    <div class="card p-3">        
        <div class="row">            
            <div class="col-sm-12 col-xl-12">
                <form id="form" action="{{route('exam.question-type.update', $data->id)}}" method="POST">
                    {{ csrf_field() }}
                    @method('PUT')
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label" for="type">Tipe</label>  
                        <div class="col-md-10">
                            <input type="text" name="type" class="form-control" id="type" placeholder="Enter type" value="{{$data->type}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-10 offset-md-2">
<<<<<<< HEAD
                            @component('exam::components.button-icon', [
                                'type' => 'a',
                                'id' => '',
                                'text' => 'Kembali',
                                'icon' => 'fa-chevron-circle-left',
                                'link' => 'exam.question-type.index',
                                'class' => 'btn-secondary btn-sm'
                            ])
                            @endcomponent
                            {{-- <x-exam-button-icon type="a" text="Kembali" icon="fa-chevron-circle-left" :link="url()->previous()" class="btn-secondary btn-sm"/> --}}
                            @component('exam::components.button-icon', [
                                'type' => 'submit',
                                'id' => 'submit',
                                'text' => 'Simpan',
                                'icon' => 'fa-paper-plane',
                                'link' => 'exam.question-type.index',
                                'class' => 'btn-success btn-sm'
                            ])
                            @endcomponent
                            {{-- <x-exam-button-icon type="submit" id="submit" text="Simpan" icon="fa-paper-plane" class="btn-success btn-sm"/> --}}
=======
                            <x-exam-button-icon type="a" text="Kembali" icon="fa-chevron-circle-left" :link="url()->previous()" class="btn-secondary btn-sm"/>
                            <x-exam-button-icon type="submit" id="submit" text="Simpan" icon="fa-paper-plane" class="btn-success btn-sm"/>
>>>>>>> 8ba76e70022cef1a869f10e628614facb6b5eea1
                        </div>
                    </div>
                </form>  
            </div><!-- col -->
        </div><!-- row -->
    </div><!-- az-content-body -->
@endsection
@section('script_exam')
<script>
    $(document).ready(function(){
        $('#form').on('submit', function(e){
            e.preventDefault();
            $('#submit').prop('disabled', true);
            // $('#submit').html("Submiting...");            
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                data: $(this).serialize(),
                success: function (res){
                    if(res.status){
                        $('#submit').prop('disabled', false);
                        // $('#submit').html("Submit");
                        window.location.href = "{{route('exam.question-type.index')}}";
                    }
                },
                error: function(err){
                    $('#submit').prop('disabled', false);
                    // $('#submit').html("Submit");
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
</script>
@endsection