@extends('exam::layouts.master')

@section('content')
    <div class="card p-3">        
        <div class="row">            
            <div class="col-sm-12 col-xl-12">
                <form action="{{route('exam.question-type.store')}}" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label" for="type">Tipe</label>  
                        <div class="col-md-10">
                            <input type="text" name="type" class="form-control" id="type" placeholder="Enter type">
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
@section('script')
    
@endsection