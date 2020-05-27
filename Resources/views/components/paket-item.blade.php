<a href="{{ route('attempt.detail', $group->id) }}" class="card text-dark my-2 bg-light border-0" style="text-decoration:none;">
    <div class="card-body p-3">
        <div class="row">
            <div class="col-2 text-center">
                <i class="typcn typcn-clipboard display-4"></i>
            </div>
            <div class="col-8">
                <h4 class="font-weight-bold mb-1">{{$group->group_name}}</h4>
                <h5 class="my-0">{{$group->category->type}}</h5>
                <h5 class="my-0">Code : {{$group->code}}</h5>
                <p class="m-0">{{$group->questions_count}} soal</p>
            </div>
            <div class="col-2 p-0 d-flex align-items-center">
                <h4>0/100</h4>
            </div>
        </div>
    </div>    
</a>