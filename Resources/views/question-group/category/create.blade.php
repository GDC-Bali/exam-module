@extends('exam::layouts.master')

@section('content_exam')
    <div class="card p-3">        
        <div class="row">            
            <div class="col-sm-12 col-xl-12">
                <form id="form" action="{{route('exam.group-category.store')}}" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label" for="type">Kategori</label>  
                        <div class="col-md-10">
                            <input type="text" name="type" class="form-control" id="type" placeholder="Enter type">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-10 offset-md-2">
                            @component('exam::components.button-icon', [
                                'type' => 'a',
                                'id' => '',
                                'text' => 'Kembali',
                                'icon' => 'fa-chevron-circle-left',
                                'link' => 'exam.group-category.index',
                                'class' => 'btn-secondary btn-sm'
                            ])
                            @endcomponent
                            {{-- <x-exam-button-icon type="a" text="Kembali" icon="fa-chevron-circle-left" :link="url()->previous()" class="btn-secondary btn-sm"/> --}}
                            @component('exam::components.button-icon', [
                                'type' => 'submit',
                                'id' => 'submit',
                                'text' => 'Simpan',
                                'icon' => 'fa-paper-plane',
                                'link' => 'exam.group-category.index',
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
        $('#form').on('submit', function(e){
            e.preventDefault();
            $('#submit').prop('disabled', true);
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                data: $(this).serialize(),
                success: function (res){
                    $('#submit').prop('disabled', false);                    
                    if(res.status){
                        window.location.href = "{{route('exam.group-category.index')}}";
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
</script>
@endsection