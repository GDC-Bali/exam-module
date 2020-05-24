@extends('exam::layouts.master')

@section('content_exam')
    <div class="card p-3">        
        <div class="row">
            <div class="col-12">
                <div class="float-left"> 
                    @component('exam::components.button-icon', [
                        'type' => 'button',
                        'id' => 'delete',
                        'text' => 'Hapus',
                        'icon' => 'fa-trash',
                        'link' => '',
                        'class' => 'btn-danger mg-5 btn-sm'
                    ])
                    @endcomponent                      
                    {{-- <x-exam-button-icon type="button" id="delete" text="Hapus" icon="fa-trash" link="" class="btn-danger mg-5 btn-sm"/>                    --}}
                </div>
                <div class="float-right">
                    @component('exam::components.button-icon', [
                        'type' => 'a',
                        'id' => 'add',
                        'text' => 'Tambah',
                        'icon' => 'fa-plus',
                        'link' => 'exam.question-type.create',
                        'class' => 'btn-primary mg-5 btn-sm'
                    ])
                    @endcomponent
                    {{-- <x-exam-button-icon type="a" id="add" text="Tambah" icon="fa-plus" :link="route('exam.question-type.create')" class="btn-primary mg-5 btn-sm"/> --}}
                </div>
            </div>
            <div class="col-sm-12 col-xl-12 mt-3">
                <div class="table-responsive">
                    <table id="example" class="table table-hover table-sm">
                        <thead>
                            <tr>
                                <th><input id="main-check" onchange="change(this)" type="checkbox"></th>
                                <th>No.</th>
                                <th>Type</th>
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
        var table = $('#example').DataTable({            
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route("exam.question-type.getdata") }}'
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
            {data: 'type', name: 'type'},
          ],
        });         

        $('#example tbody').on( 'click', 'tr td:not(:first-child)', function () {                  
            window.location.href = "{{route('exam.question-type.index')}}/"+table.row($(this).parent()).data().id+"/edit/";
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
                        url: "{{route('exam.question-type.multipledelete')}}",
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

      });            
        
    </script>
@endsection