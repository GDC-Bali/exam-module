<<<<<<< HEAD
=======
{{-- @extends('exam::layouts.attempt')

@section('content')      
<div class="row my-5">
    <div class="col-md-8 offset-md-2">
        <div class="float-left">                    
            <button id="delete" class="btn btn-secondary mg-5 mr-2"><i class="typcn typcn-arrow-unsorted"></i> Sort</button>                    
        </div>
        <div class="float-left">
            <a href="{{route('exam.question-type.create')}}">
                <button class="btn btn-secondary mg-5 mr-2"><i class="typcn typcn-filter"></i> Filter</button>
            </a>
        </div>
    </div>
    <div class="col-md-8 offset-md-2 pt-3 mb-5">
        @foreach ($groups as $group)
            <x-exam-paket-item :group="$group"/>
        @endforeach
    </div><!-- col -->
</div><!-- row -->
@endsection --}}

>>>>>>> 726fccfdff6db1820bf4c7e1b161fc1de2a53d8f
@extends('exam::layouts.master')

@section('content_exam')
    <div class="card p-3">        
        <div class="row">
            <div class="col-12">
                <div class="card mb-3 p-3">
                    <h6>Filter</h6>
                    <div class="row">
                        <div class="col">
                            <label for="filter-keyword"><small>Title</small></label>
                            <input type="text" class="form-control form-control-sm" id="filter-keyword" placeholder="Masukan judul">
                        </div>
                        <div class="col">
                            <label for="filter-paket"><small>Paket Soal</small></label>
                            <select class="form-control form-control-sm" id="filter-paket">
                                <option value="" selected>Semua Paket Soal</option>
                                @foreach($group as $val)
                                    <option value="{{$val->id}}">{{$val->group_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <label for="filter-status"><small>Status</small></label>
                            <select class="form-control form-control-sm" id="filter-status">
                                <option value="" selected>Semua Status</option>
                                <option value="0">Initialized</option>
                                <option value="1">Started</option>
                                <option value="2">Finished</option>
                                <option value="3">Reviewed</option>
                                <option value="4">Canceled</option>                                
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-xl-12 mt-3">
                <div class="table-responsive">
                    <table id="example" class="table table-hover table-bordered table-sm">
                        <thead>
                            <tr>
                                <th><input id="main-check" onchange="change(this)" type="checkbox"></th>
                                <th>No.</th>
                                <th>Nama Ujian</th>
                                <th>Durasi (menit)</th>
                                <th>Paket Soal</th>
                                <th>Percobaan ke-</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>                        
                    </table>  
                </div>
            </div><!-- col -->
        </div><!-- row -->
    </div><!-- az-content-body -->
@endsection
@section('script_exam')
    <script>
    $(document).ready(function(){        
        var table;
        showData();
    });
       
        showData = function(){
            table = $('#example').DataTable({            
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("exam.attempt.getdata") }}',
                    data: function ( d ) {
                        d.keyword = $('#filter-keyword').val();
                        d.paket = $('#filter-paket').val();
                        d.status = $('#filter-status').val();
                    }
                },  
                "drawCallback": function() {
                    $("#example input[type='checkbox']").iCheck({
                        checkboxClass: 'icheckbox_minimal-blue',
                    });
                    $("#example #main-check").on("ifChanged", function(){                         
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
                {data: 'title', name: 'title'},
                {data: 'duration', name: 'duration'},
                {data: 'group_name', name: 'group_name'},
                {data: 'no_attempt', name: 'no_attempt'},
                {data: 'status', name: 'status'},
            ],
        });     
    }         

        $('#example tbody').on( 'click', 'tr td:not(:first-child)', function () {                  
            window.location.href = "{{url('exam/attempt')}}/"+table.row($(this).parent()).data().id+"/result/";
        });        

        $("#filter-keyword").keyup(function() {
            $("#example").dataTable().fnDestroy();
            showData();
        });
        $('#filter-paket').change(function(){
            $("#example").dataTable().fnDestroy();
            showData();
        });
        $('#filter-status').change(function(){
            $("#example").dataTable().fnDestroy();
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
                        url: "{{route('exam.question-category.multipledelete')}}",
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
                                $('#example').DataTable().ajax.reload(); 
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
        
    </script>
@stop