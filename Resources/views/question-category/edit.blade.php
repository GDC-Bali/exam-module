@extends('exam::layouts.master')

@section('content_exam')
    <div class="card p-3">        
        <div class="row">            
            <div class="col-sm-12 col-xl-12">
                <form id="form" action="{{route('exam.question-category.update', $data->id)}}" method="POST">
                    {{ csrf_field() }}
                    @method('PUT')
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label" for="type">Tipe</label>  
                        <div class="col-md-10">
                            <input type="text" name="type" class="form-control" id="type" placeholder="Enter type" value="{{$data->type}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="desc" class="col-md-2 col-form-label">Deskripsi</label>
                        <div class="col-md-10">
                            <textarea name="desc" id="desc" class="form-control" cols="30" rows="3">{{$data->desc}}</textarea>
                        </div>
                    </div>                    
                    <div class="form-group row">
                        <div class="col-md-10 offset-md-2">
                            @component('exam::components.button-icon', [
                                'type' => 'a',
                                'id' => '',
                                'text' => 'Kembali',
                                'icon' => 'fa-chevron-circle-left',
                                'link' => 'exam.question-category.index',
                                'class' => 'btn-secondary btn-sm'
                            ])
                            @endcomponent
                            {{-- <x-exam-button-icon type="a" text="Kembali" icon="fa-chevron-circle-left" :link="url()->previous()" class="btn-secondary btn-sm"/> --}}
                            @component('exam::components.button-icon', [
                                'type' => 'submit',
                                'id' => 'submit',
                                'text' => 'Simpan',
                                'icon' => 'fa-paper-plane',
                                'link' => 'exam.question-category.index',
                                'class' => 'btn-success btn-sm'
                            ])
                            @endcomponent
                            {{-- <x-exam-button-icon type="submit" id="submit" text="Simpan" icon="fa-paper-plane" class="btn-success btn-sm"/> --}}
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
        CKEDITOR.replace( 'desc' );
    });
    $('#form').unbind('submit').submit(function(e){
        for(var i in CKEDITOR.instances) CKEDITOR.instances[i].updateElement();
        e.preventDefault();
        $('#submit').prop('disabled', true);            
        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: $(this).serialize(),
            success: function (res){
                if(res.status){
                    $('#submit').prop('disabled', false);                        
                    window.location.href = "{{route('exam.question-category.index')}}";
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
        $('#form').unbind('submit');
        return false;
    });
</script>
@endsection