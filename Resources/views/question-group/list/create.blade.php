@extends('exam::layouts.master')

@section('content_exam')
    <div class="card p-3">        
        <div class="row">            
            <div class="col-sm-12 col-xl-12">
                <form id="form" action="{{route('exam.question-group.store')}}" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group row">
                        <label for="group_name" class="col-md-2 col-form-label">Nama Paket Soal</label>
                        <div class="col-md-10">
                            <input type="text" name="group_name" class="form-control" id="group_name" placeholder="Enter group name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="code" class="col-md-2 col-form-label">Kode</label>
                        <div class="col-md-10">
                            <input type="text" name="code" class="form-control" id="code" placeholder="Enter code">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="desc" class="col-md-2 col-form-label">Deskripsi</label>
                        <div class="col-md-10">
                            <textarea name="desc" id="desc" class="form-control" cols="30" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="category_id" class="col-md-2 col-form-label">Kategori Paket Soal</label>
                        <div class="col-md-10">
                            <select name="category_id" id="category_id" class="form-control">
                                <option hidden value=""></option>
                                @foreach ($category as $item)
                                    <option value="{{$item->id}}">{{$item->type}}</option>    
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="grade_formula" class="col-md-2 col-form-label">Tipe penilaian</label>
                        <div class="col-md-10">
                            <select name="grade_formula" id="grade_formula" class="form-control">
                                <option hidden value=""></option>
                                <option value="1">Rata - rata</option>
                                <option value="2">Akumulasi</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="code" class="col-md-2 col-form-label">Banyak Percobaan</label>
                        <div class="col-md-10">
                            <select name="attempt_allowed" id="attempt_allowed" class="form-control">
                                <option value="-1">Tidak terbatas</option>
                                @for ($i = 1; $i <= 10; $i++)
                                <option value="{{$i}}">{{$i}} kali</option>
                                @endfor
                            </select>
                            <small id="availabilityHelp" class="form-text text-muted">Berapa kali user dapat mencoba menjawab ujian/paket soal ini?</small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label" for="randomize_no">Acak No. Soal</label>  
                        <div class="col-md-10">
                            <input type="checkbox" name="randomize_no" data-toggle="toggle" data-size="sm" data-on="Ya" data-off="Tidak" data-onstyle="success" data-offstyle="default">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label" for="question_per_page">Soal per Halaman</label>
                        <div class="col-md-3">
                            <input type="number" name="question_per_page" class="form-control" id="question_per_page" placeholder="Enter question per page" min="1" max="10" step="1" value="1">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label" for="randomize_no">Ketersediaan</label>  
                        <div class="col-md-10">
                            <input type="checkbox" name="availability" data-toggle="toggle" data-size="sm" data-on="Ya" data-off="Tidak" data-onstyle="success" data-offstyle="default">
                            <small id="availabilityHelp" class="form-text text-muted">Apakah paket soal ini dapat dilihat juga oleh user lain?</small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="code" class="col-md-2 col-form-label">Kode Akses</label>
                        <div class="col-md-1">
                            <input id="toogle-access-code" type="checkbox" data-toggle="toggle" data-size="sm" data-on="Ya" data-off="Tidak" data-onstyle="success" data-offstyle="default">
                        </div>
                        <div class="col-md-9">
                            <input type="text" name="access_code" class="form-control form-control-sm" id="access_code" placeholder="Enter access code">
                            <small id="availabilityHelp" class="form-text text-muted">Anda dapat membatasi akses soal dengan memberikan kode akses khusus</small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-10 offset-md-2">
                            <x-exam-button-icon type="a" text="Kembali" icon="fa-chevron-circle-left" :link="url()->previous()" class="btn-secondary btn-sm"/>
                            <x-exam-button-icon type="submit" id="submit" text="Simpan" icon="fa-paper-plane" class="btn-success btn-sm"/>
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
        $('#category_id').select2({
            allowClear : true,
            placeholder : 'Select Category',
            width: 'resolve',
        });
        $('#attempt_allowed').select2({
            allowClear : true,
            width: 'resolve',
        });
        $('#grade_formula').select2({
            allowClear : true,
            placeholder : 'Select Grade Formula',
            width: 'resolve',
        });
        $('#access_code').prop( "readonly", true);
        CKEDITOR.replace( 'desc' );
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
                    // $('#submit').html("Submit");
                    if(res.status){                        
                        window.location.href = "{{route('exam.question-group.index')}}";
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

    $('#toogle-access-code').change(function() {
        if($(this).is(':checked')){
            $('#access_code').prop( "readonly", false);
        } else {
            $('#access_code').prop( "readonly", true);
            $('#access_code').val('');
        }
    });
</script>
@endsection