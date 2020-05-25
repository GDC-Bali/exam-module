@extends('exam::layouts.master')

@section('content_exam')
    <style>
        .table-preview tbody>tr>td p{
            margin-bottom: 0px;
        }
    </style>
    <div class="card p-3">        
        <div class="row">            
            <div class="col-sm-12 col-xl-12">
                <form id="form" action="{{route('exam.question-group.update', $data->id)}}" method="POST">                        
                    {{ csrf_field() }}
                    @method('PUT')
                    <div class="form-group row">
                        <label for="group_name" class="col-md-2 col-form-label">Nama Paket Soal</label>
                        <div class="col-md-10">
                            <input type="text" name="group_name" class="form-control" id="group_name" placeholder="Enter group name" value="{{$data->group_name}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="code" class="col-md-2 col-form-label">Kode</label>
                        <div class="col-md-10">
                            <input type="text" name="code" class="form-control" id="code" placeholder="Enter code" value="{{$data->code}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="desc" class="col-md-2 col-form-label">Deskripsi</label>
                        <div class="col-md-10">
                            <textarea name="desc" id="desc" class="form-control" cols="30" rows="3">{!! $data->desc !!}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="category_id" class="col-md-2 col-form-label">Kategori Paket Soal</label>
                        <div class="col-md-10">
                            <select name="category_id" id="category_id" class="form-control">
                                <option hidden value=""></option>
                                @foreach ($category as $item)
                                    <option {{$item->id == $data->category_id ? 'selected' : ''}} value="{{$item->id}}">{{$item->type}}</option>    
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
<<<<<<< HEAD
                        <label for="grade_formula" class="col-md-2 col-form-label">Tipe penilaian</label>
                        <div class="col-md-10">
                            <select name="grade_formula" id="grade_formula" class="form-control">
                                <option hidden value=""></option>
                                <option {{ $data->grade_formula == 1 ? 'selected' : '' }} value="1">Rata = rata</option>
                                <option {{ $data->grade_formula == 2 ? 'selected' : '' }} value="2">Akumulasi</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
=======
>>>>>>> 8ba76e70022cef1a869f10e628614facb6b5eea1
                        <label for="code" class="col-md-2 col-form-label">Banyak Percobaan</label>
                        <div class="col-md-10">
                            <select name="attempt_allowed" id="attempt_allowed" class="form-control">
                                <option value="-1" {{$data->attempt_allowed==-1?'selected':''}}>Tidak terbatas</option>
                                @for ($i = 1; $i <= 10; $i++)
                                <option value="{{$i}}" {{$i==$data->attempt_allowed?'selected':''}}>{{$i}} kali</option>
                                @endfor
                            </select>
                            <small id="availabilityHelp" class="form-text text-muted">Berapa kali user dapat mencoba menjawab ujian/paket soal ini?</small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label" for="randomize_no">Acak No. Soal</label>  
                        <div class="col-md-10">
                            <input {{$data->randomize_no == 1 ? 'checked' : ''  }} type="checkbox" name="randomize_no" data-toggle="toggle" data-size="sm" data-on="Ya" data-off="Tidak" data-onstyle="success" data-offstyle="default">                            
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label" for="question_per_page">Soal per Halaman</label>
                        <div class="col-md-3">                          
                            <input type="number" name="question_per_page" class="form-control" id="question_per_page" placeholder="Enter question per page" min="1" max="10" step="1" value="{{$data->question_per_page}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label" for="randomize_no">Ketersediaan</label>  
                        <div class="col-md-10">
                            <input {{$data->availability == 1 ? 'checked' : ''  }} type="checkbox" name="availability" data-toggle="toggle" data-size="sm" data-on="Ya" data-off="Tidak" data-onstyle="success" data-offstyle="default">
                            <small id="availabilityHelp" class="form-text text-muted">Apakah paket soal ini dapat dilihat juga oleh user lain?</small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="code" class="col-md-2 col-form-label">Kode Akses</label>
                        <div class="col-md-1">
                            <input id="toogle-access-code" {{$data->access_code != null ? 'checked' : ''  }} type="checkbox" data-toggle="toggle" data-size="sm" data-on="Ya" data-off="Tidak" data-onstyle="success" data-offstyle="default">
                        </div>
                        <div class="col-md-9">
                            <input type="text" name="access_code" class="form-control form-control-sm" id="access_code" placeholder="Enter access code" value="{{$data->access_code}}" {{$data->access_code?'':'readonly'}}>
                            <small id="availabilityHelp" class="form-text text-muted">Anda dapat membatasi akses soal dengan memberikan kode akses khusus</small>
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
                                'link' => 'exam.question-group.index',
                                'class' => 'btn-secondary btn-sm'
                            ])
                            @endcomponent
                            {{-- <x-exam-button-icon type="a" text="Kembali" icon="fa-chevron-circle-left" :link="url()->previous()" class="btn-secondary btn-sm"/> --}}
                            @component('exam::components.button-icon', [
                                'type' => 'submit',
                                'id' => 'submit',
                                'text' => 'Simpan',
                                'icon' => 'fa-paper-plane',
                                'link' => 'exam.question-group.index',
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

    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <h5 class="mr-auto">Daftar Soal<br><small class="text-info"><i class="fas fa-info-circle"></i> Geser kolom (<i class="fas fa-arrows-alt"></i>) untuk mengatur ulang urutan soal</small></h5>
                <div class="float-right">
                    <div class="btn-group">
                        <div class="btn-group dropleft" role="group">
<<<<<<< HEAD
                            <button type="button" class="btn btn-primary btn-sm dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="sr-only">Tambah soal</span>
=======
                            <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Tambah soal
>>>>>>> 8ba76e70022cef1a869f10e628614facb6b5eea1
                            </button>
                            <div class="dropdown-menu">
                                {{-- <a class="dropdown-item" data-toggle="modal" data-target="#modalBuatSoal" href="#">Buat soal baru</a> --}}
                                <a class="dropdown-item" href="{{url('exam/questions/create?group_id='.$data->id.'')}}">Buat soal baru</a>
                                <a class="dropdown-item" data-toggle="modal" data-target="#modalPilihSoal" href="#">Pilih dari bank soal</a>
                            </div>
                        </div>
<<<<<<< HEAD
                        <button type="button" class="btn btn-primary btn-sm">
                          Tambah soal
                        </button>
=======
>>>>>>> 8ba76e70022cef1a869f10e628614facb6b5eea1
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">          
            <div class="table-responsive">
                <table id="table-soal" class="table table-hover table-sm">
                    <thead>
                        <tr>
                            <th></th>
                            <th>No.</th>
                            <th>Code</th>
                            <th>Tipe</th>
                            <th>Kategori</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>                        
                </table>
            </div>    
        </div>
    </div>

    {{-- Modal --}}
    <div class="modal fade" id="modalPilihSoal" tabindex="-1" role="dialog" aria-labelledby="modalPilihSoalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Bank Soal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table id="table-all-soal" class="table table-hover table-sm" style="width:100%">
                        <thead>
                            <tr>
                                <th><input id="main-check2" onchange="change(this)" type="checkbox"></th>
                                <th>No.</th>
                                <th>Code</th>
                                <th>Tipe</th>
                                <th>Kategori</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>                        
                    </table>                        
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info btn-sm" id="btn-select-banksoal" disabled><span id="seleted-items">0</span> Soal dipilih</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalBuatSoal" tabindex="-1" role="dialog" aria-labelledby="modalPilihSoalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Buat soal baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                                           
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="previewModal" tabindex="-1" role="dialog" aria-labelledby="previewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="previewModalLabel">Preview Soal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modalBody">
                
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>            
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script_exam')
<link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.2.6/css/rowReorder.dataTables.min.css">
<script src="https://cdn.datatables.net/rowreorder/1.2.6/js/dataTables.rowReorder.min.js"></script>
<script>
    var selectedItems = [];
    $(document).ready(function(){
        $('#category_id').select2({
            allowClear : true,
            placeholder : 'Select Category',
            width: 'resolve',
        });
<<<<<<< HEAD
        $('#grade_formula').select2({
            allowClear : true,
            placeholder : 'Select Grade Formula',
            width: 'resolve',
        });
=======
>>>>>>> 8ba76e70022cef1a869f10e628614facb6b5eea1
        var tableSelectQuestion;
        var tableQuestion;
        showQuestionList();
        CKEDITOR.replace('desc');
        $('#attempt_allowed').select2({
            allowClear : true,
            width: 'resolve',
        });
        $("input[type='number']").inputSpinner();
    });

    showQuestionList = function(){
        tableQuestion = $('#table-soal').DataTable({
            processing: true,
            serverSide: true,   
            rowReorder: true,
            columnDefs: [
                { orderable: true, className: 'reorder', targets: 0 },
                { orderable: false, targets: '_all' }
            ],
            lengthMenu: [[25, 50, 75, 100], [25, 50, 75, 100]],
            ajax: {
                url: '{{ route("exam.question.getdatabygroup", $data->id) }}'
            },
            "order": [],
            columns: [
                {
                    data: null, orderable: false, render: function ( data, type, row ) {
                        return '<i class="fas fa-arrows-alt"></i>';
                    }
                },
                {data: 'DT_RowIndex', name: 'DT_RowIndex', width: "5%", orderable: false},
                {data: 'code', name: 'code'},
                {data: 'type', name: 'type'},
                {data: 'category', name: 'category'},
                {data: 'action', name: 'action', orderable: false, width: "10%"},
            ],
        });

        tableQuestion.on( 'row-reorder', function ( e, diff, edit ) {            
            var group_id =  "{{$data->id}}";
            var new_pos = [];
            var old_pos = [];
            $.each(diff, function(k,v){
                new_pos.push(v.newPosition+1);
                old_pos.push(v.oldPosition+1);
            });
            console.log(diff);
            console.log(edit);
            console.log(e);
            $.ajax({
                url: "{{route('exam.question-group.reorder')}}",
                type: 'POST',
                data: {
                    _token: "{{csrf_token()}}",
                    group_id: group_id,
                    new_pos: new_pos,
                    old_pos: old_pos,
                },
                success: function (res){
                    // $('#table-soal').DataTable().ajax.reload();
                },                
            }); 
            // $('#table-soal').html( 'Event result:<br>'+result );
        });
    }

    $('#modalPilihSoal').on('shown.bs.modal', function (e) {
        if ($.fn.DataTable.isDataTable('#table-all-soal')) {
            tableSelectQuestion.destroy();
        }
        showAllQuestion();
    })
    showAllQuestion = function(){
        tableSelectQuestion = $('#table-all-soal').DataTable({            
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route("exam.questions.getbank") }}',
                data: function ( d ) {
                    d.paket_id = "{{$data->id}}";
                }
            },  
            "drawCallback": function() {
                $("#table-all-soal input[type='checkbox']").iCheck({
                    checkboxClass: 'icheckbox_minimal-blue',
                });
                $("#table-all-soal #main-check2").on("ifChanged", function(){                         
                    $("#main-check2:checked").length > 0 ? check = "check" : check = "uncheck";
                    $.each($("input[name='colom[]']"), function(k,v){
                        $(v).iCheck(check);;
                    });
                    getSelectedSoal();
                });  
                $('.select-bank-soal').on('ifChanged', function(event){
                    getSelectedSoal();
                });
            },
            "order": [],
            columns: [
                {data: 'checkbox', orderable: false, searchable: false, width: "5%"},
                {data: 'DT_RowIndex', name: 'DT_RowIndex', width: "5%", orderable: false},
                {data: 'code', name: 'code'},
                {data: 'type.type', name: 'type.type'},
                {data: 'category.type', name: 'category.type'},
            ],
        });
    }

    $('#form').on('submit', function(e){
        for(var i in CKEDITOR.instances) CKEDITOR.instances[i].updateElement();
        e.preventDefault();
        $('#submit').prop('disabled', true);
<<<<<<< HEAD
        // $('#submit').html("Submiting...");            
=======
        $('#submit').html("Submiting...");            
>>>>>>> 8ba76e70022cef1a869f10e628614facb6b5eea1
        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: $(this).serialize(),
            success: function (res){
                $('#submit').prop('disabled', false);
<<<<<<< HEAD
                // $('#submit').html("Submit");
=======
                $('#submit').html("Submit");
>>>>>>> 8ba76e70022cef1a869f10e628614facb6b5eea1
                if(res.status){                        
                    window.location.href = "{{route('exam.question-group.index')}}";
                }
            },
            error: function(err){
                $('#submit').prop('disabled', false);
                $('#submit').html("Submit");
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

    getSelectedSoal = function() {
        var selectedItemCount = 0;
        selectedItems = [];
        $.each($(".select-bank-soal"), function(k,v){
            let isSelected = $(v).is(':checked');
            if(isSelected){
                selectedItemCount++;
                selectedItems.push($(v).val());
            }
        });
        if(selectedItemCount > 0){
            $('#btn-select-banksoal').attr('disabled', false);
        }
        $('#seleted-items').html(selectedItemCount);
    }

    $('#btn-select-banksoal').click(function(){
        $.ajax({
            url: '{{route("exam.question-group.addfrombank")}}',
            type: "POST",
            data: {
                paket_id: "{{$data->id}}",
                soals: selectedItems,
                _token: "{{csrf_token()}}"
            },
            success: function (res){
                if(res.status){                        
                    Swal.fire({
                        icon: 'success',
                        title: 'Soal telah ditambahkan',                        
                    });
                    $('#table-soal').DataTable().ajax.reload();
                    $('#modalPilihSoal').modal('hide')
                }
            },
            error: function(err){
                $('#submit').prop('disabled', false);
                $('#submit').html("Submit");
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

    $('#table-soal').on('click', 'tbody tr .btn-detach-soal', function() {
        Swal.fire({
            title: 'Konfirmasi',
            text: "Anda yakin ingin menghapus soal dari paket ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "{{route('exam.question-group.detachquestion')}}",
                    type: 'POST',
                    data: {
                        "id": "{{$data->id}}",
                        "soal": $(this).data('id'),
                        "_token": "{{csrf_token()}}",
                    },
                    success: function (res){
                        if(res){
                            if (result.value) {
                                Swal.fire(
                                    'Berhasil!',
                                    'Soal telah dihapus dari paket ini',
                                    'success'
                                )
                            }
                            $('#table-soal').DataTable().ajax.reload(); 
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
        });
    });

    $('#table-soal').on('click', 'tbody tr .btn-preview', function() {
        var id = $(this).data('id');
        $.ajax({
            url: "{{url('exam/getdata-getdetailquestion')}}/"+id,
            type: 'GET',
            data: {                
                "_token": "{{csrf_token()}}",
            },
            success: function (res){
                if(res.status){                        
                    $('#modalBody').empty();
                    $('#modalBody').append("<label>Pertanyaan</label>")
                    $('#modalBody').append("<textarea readonly id='previewSoal'>"+res.data.question_text+"</textarea>");
                    if(typeof(res.data.question_option) != "undefined" && res.data.question_option.length > 0) {
<<<<<<< HEAD
                        table = "<label class='mt-3'>Jawaban</label><table class='table table-bordered table-sm table-preview'><thead><th style='width:1%%'>No</th><th style='width:90%; vertical-align:middle; text-align:center;'>Pilihan</th><th style='vertical-align:middle; text-align:center;'>Jawaban Benar</th></thead><tbody>";
                        $.each(res.data.question_option, function(k,v){
                            if(v.option_value == 100)
                                icon = "<i class='fa fa-check'></i>";
                            else
                                icon = '';
                            table += "<tr><td class='text-center'>"+(k+1)+"</td><td>"+v.option_text+"</td><td style='text-align:center;'>"+icon+"</td></tr>";
=======
                        table = "<label class='mt-3'>Jawaban</label><table class='table table-bordered table-sm table-preview'><thead><th style='width:1%%'>No</th><th style='width:90%; vertical-align:middle; text-align:center;'>Pilihan</th><th style='vertical-align:middle; text-align:center;'>Bobot</th></thead><tbody>";
                        $.each(res.data.question_option, function(k,v){
                            table += "<tr><td class='text-center'>"+(k+1)+"</td><td>"+v.option_text+"</td><td style='text-align:center;'>"+v.option_value+"</td></tr>";
>>>>>>> 8ba76e70022cef1a869f10e628614facb6b5eea1
                            // $('#modalBody').append("<tr><td><textarea readonly id='option_"+k+"'>"+v.option_text+"</textarea></td><td>1</td></tr>")
                            // CKEDITOR.replace('option_'+k+'',{
                            //     toolbar: 'Custom', //makes all editors use this toolbar
                            //     toolbarStartupExpanded : false,
                            //     toolbarCanCollapse  : false,                                
                            //     height: '80px',
                            //     toolbar_Custom: [] //define an empty array or whatever buttons you want.
                            // }); 
                        });
                        table += "</tbody></table>";
                        $('#modalBody').append(table);
                    }
                    $('#modalBody').append("<label>Pembahasan</label>")
                    $('#modalBody').append("<textarea readonly id='pembahasanSoal'>"+res.data.feedback+"</textarea>");
                    CKEDITOR.replace('previewSoal',{
                        // toolbar: 'Custom', //makes all editors use this toolbar
                        toolbarStartupExpanded : false,
                        toolbarCanCollapse  : false,
                        toolbar_Custom: [] //define an empty array or whatever buttons you want.
                    }); 
                    CKEDITOR.replace('pembahasanSoal',{
                        // toolbar: 'Custom', //makes all editors use this toolbar
                        toolbarStartupExpanded : false,
                        toolbarCanCollapse  : false,
                        toolbar_Custom: [] //define an empty array or whatever buttons you want.
                    }); 
                    $('#previewModal').modal('show');
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