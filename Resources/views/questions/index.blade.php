@extends('exam::layouts.master')

@section('content_exam')
    <style>
        .table-preview tbody>tr>td p{
            margin-bottom: 0px;
        }
    </style>
    <div class="card p-3">        
        <div class="row">
            <div class="col-12">
                <div class="card mb-3 p-3">
                    <h6>Filter</h6>
                    <div class="row">
                        <div class="col">
                            <label for="filter-keyword"><small>Kode</small></label>
                            <input type="text" class="form-control form-control-sm" id="filter-keyword" placeholder="Masukan kode">
                        </div>
                        <div class="col">
                            <label for="filter-kategori"><small>Kategori</small></label>
                            <select class="form-control form-control-sm" id="filter-kategori">
                                <option value="" selected>Semua kategori</option>
                                @foreach($category as $val)
                                    <option value="{{$val->id}}">{{$val->type}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <label for="filter-tipe"><small>Tipe</small></label>
                            <select class="form-control form-control-sm" id="filter-tipe">
                                <option value="" selected>Semua Tipe</option>
                                @foreach($tipe as $val)
                                    <option value="{{$val->id}}">{{$val->type}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="float-left">                    
                    <x-exam-button-icon type="button" id="delete" text="Hapus" icon="fa-trash" link="" class="btn-danger mg-5 btn-sm"/>                  
                </div>
                <div class="float-right">
                    <x-exam-button-icon type="a" id="delete" text="Tambah" icon="fa-plus" :link="route('exam.questions.create')" class="btn-primary mg-5 btn-sm"/>
                </div>
            </div>
            <div class="col-sm-12 col-xl-12 mt-3">
                <div class="table-responsive">
                    <table id="table-bank-soal" class="table table-hover table-sm">
                        <thead>
                            <tr>
                                <th><input id="main-check" onchange="change(this)" type="checkbox"></th>
                                <th>No.</th>
                                <th>Kode</th>
                                <th>Kategori</th>
                                <th>Tipe</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>                        
                    </table>
                </div>     
            </div><!-- col -->
        </div><!-- row -->
    </div>

    <!-- Modal -->
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
    <script>
    $(document).ready(function(){        
        var table;
        showData();
    });

    $('#table-bank-soal tbody').on( 'click', 'tr td:not(:first-child, :last-child)', function () {                  
        window.location.href = "{{route('exam.questions.index')}}/"+table.row($(this).parent()).data().id+"/edit/";
    });

    showData = function(){
        table = $('#table-bank-soal').DataTable({            
            processing: true,
            serverSide: true,
            lengthMenu: [[25, 50, 75, 100], [25, 50, 75, 100]],
            ajax: {
                url: '{{ route("exam.questions.getdata") }}',
                data: function ( d ) {
                    d.keyword = $('#filter-keyword').val();
                    d.kategori = $('#filter-kategori').val();
                    d.tipe = $('#filter-tipe').val();
                }
            },  
            "drawCallback": function() {
                $("#table-bank-soal input[type='checkbox']").iCheck({
                    checkboxClass: 'icheckbox_minimal-blue',
                });
                $("#table-bank-soal #main-check").on("ifChanged", function(){                         
                    $("#main-check:checked").length > 0 ? check = "check" : check = "uncheck";
                    $.each($("input[name='colom[]']"), function(k,v){
                        $(v).iCheck(check);;
                    });
                });  
            },
            "order": [],
            columns: [
                {data: 'checkbox', orderable: false, searchable: false, width: "5%"},
                {data: 'DT_RowIndex', name: 'DT_RowIndex', width: "5%", orderable: false},
                {data: 'code', name: 'code'},
                {data: 'category', name: 'category'},
                {data: 'type', name: 'type'},
                {data: 'action', name: 'action', orderable: false, searchable: false, width: "10%"},
            ],
        }); 
    }   

    $("#filter-keyword").keyup(function() {
        $("#table-bank-soal").dataTable().fnDestroy();
        showData();
    });
    $('#filter-kategori').change(function(){
        $("#table-bank-soal").dataTable().fnDestroy();
        showData();
    });
    $('#filter-tipe').change(function(){
        $("#table-bank-soal").dataTable().fnDestroy();
        showData();
    });
    $('#delete').on( 'click', function () {
        Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                let del = [];
                $.each($("input[name='colom[]']:checked"), function(k,v){                                
                    del.push(v.value);
                });
                $.ajax({
                    url: "{{route('exam.questions.multipledelete')}}",
                    type: 'POST',
                    data: {
                        "id": del,
                        "_token": "{{csrf_token()}}",
                    },
                    success: function (res){
                        if(res){
                            if (result.value) {
                                Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                                )
                            }
                            $('#table-bank-soal').DataTable().ajax.reload(); 
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
        })
    }); 

    $('#table-bank-soal').on('click', 'tbody tr .btn-preview', function() {
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
                        table = "<label class='mt-3'>Jawaban</label><table class='table table-bordered table-sm table-preview'><thead><th style='width:1%%'>No</th><th style='width:90%; vertical-align:middle; text-align:center;'>Pilihan</th><th style='vertical-align:middle; text-align:center;'>Jawaban Benar</th></thead><tbody>";
                        $.each(res.data.question_option, function(k,v){
                            if(v.option_value == 100)
                                icon = "<i class='fa fa-check'></i>";
                            else
                                icon = '';
                            table += "<tr><td class='text-center'>"+(k+1)+"</td><td>"+v.option_text+"</td><td style='text-align:center;'>"+icon+"</td></tr>";
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
                        toolbarStartupExpanded : false,
                        toolbarCanCollapse  : false,
                        toolbar_Custom: [] //define an empty array or whatever buttons you want.
                    }); 
                    CKEDITOR.replace('pembahasanSoal',{                        
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
    </script>
@endsection