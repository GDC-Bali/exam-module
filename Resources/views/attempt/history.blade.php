@extends('exam::layouts.attempt')

@section('content')
<div class="container py-4">
    <div class="row d-flex justify-content-center">
        <div class="col-md-12 mb-3">
            <div class="project">
                <div class="row bg-white has-shadow">
                    <div class="left-col col-lg-6 d-flex align-items-center justify-content-between">
                        <div class="project-title d-flex align-items-center">
                            <div class="text">
                                <h3 class="h4">Ujian Matematika</h3><small>Lorem Ipsum Dolor</small>
                            </div>
                            <div class="time"><i class="fa fa-clock-o"></i>12:00 PM </div>
                        </div>
                        <div class="project-date"><span class="hidden-sm-down">Today at 4:24 AM</span></div>
                    </div>
                    <div class="right-col col-lg-6 d-flex align-items-center">
                        <div class="comments"><i class="fa fa-comment-o"></i>20</div>
                        <div class="project-progress">
                            <div class="progress">
                                <div role="progressbar" style="width: 45%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" class="progress-bar bg-red"></div>
                            </div>
                        </div>
                        <div class="image has-shadow">
                            20/100
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection