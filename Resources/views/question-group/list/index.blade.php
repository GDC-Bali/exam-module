@extends('exam::layouts.master')

@section('content_exam')
    <div class="card p-3">        
        <div class="row">
            <div class="col-12">
                <div class="card mb-3 p-3">
                    <h6>Filter</h6>
                    <div class="row">
                        <div class="col">
                            <label for="filter-keyword"><small>Keyword</small></label>
                            <input type="text" class="form-control form-control-sm" id="filter-keyword" placeholder="Masukan kode">
                        </div>
                        <div class="col">
                            <label for="filter-kategori"><small>Kategori</small></label>
                            <select class="form-control form-control-sm" id="filter-kategori">
                                <option value="" selected></option>
                                @foreach ($categories as $category)
                                    <option value="{{$category->id}}">{{$category->type}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="float-left">                    
                    <x-exam-button-icon type="button" id="delete" text="Hapus" icon="fa-trash" link="" class="btn-danger mg-5 btn-sm"/>                  
                </div>
                <div class="float-right">
                    <x-exam-button-icon type="a" id="delete" text="Tambah" icon="fa-plus" :link="route('exam.question-group.create')" class="btn-primary mg-5 btn-sm"/>
                </div>
            </div>
            <div class="col-sm-12 col-xl-12 mt-3">
                <div class="table-responsive">
                    <table id="table-list" class="table table-hover table-sm">
                        <thead>
                            <tr>
                                <th><input id="main-check" onchange="change(this)" type="checkbox"></th>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Kode</th>
                                <th>Kategori</th>
                                <th>Jumlah Soal</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>                        
                    </table>
                </div>     
            </div><!-- col -->
        </div><!-- row -->
    </div>
@endsection
@section('script_exam')
    <script>
    $(document).ready(function(){     
        var table;   
        showData();     
        $('#filter-kategori').select2({
            allowClear : true,
            placeholder : 'Semua Kategori',
            width: 'resolve',
        });          
    }); 

    $('#table-list tbody').on( 'click', 'tr td:not(:first-child)', function () {                  
        window.location.href = "{{route('exam.question-group.index')}}/"+table.row($(this).parent()).data().id+"/edit/";
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
                    url: "{{route('exam.question-group.multipledelete')}}",
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
                            $('#table-list').DataTable().ajax.reload(); 
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

    showData = function(){
        table = $('#table-list').DataTable({   
            searching: false,        
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route("exam.question-group.getdata") }}',
                data: function ( d ) {
                    d.keyword = $('#filter-keyword').val();
                    d.kategori = $('#filter-kategori').val();
                }
            },  
            "drawCallback": function() {
                $("#table-list input[type='checkbox']").iCheck({
                    checkboxClass: 'icheckbox_minimal-blue',
                });
                $("#table-list #main-check").on("ifChanged", function(){                         
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
                {data: 'group_name', name: 'group_name'},
                {data: 'code', name: 'code'},
                {data: 'category.type', name: 'category.type'},
                {data: 'total', name: 'total'},
            ],
        });  
    };  

    $("#filter-keyword").keyup(function() {
        $("#table-list").dataTable().fnDestroy();
        showData();
    });
    $('#filter-kategori').change(function(){
        $("#table-list").dataTable().fnDestroy();
        showData();
    });
    </script>
@endsection