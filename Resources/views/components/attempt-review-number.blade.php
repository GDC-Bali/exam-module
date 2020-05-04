<div class="col-md-4 d-none d-md-block" id="nomor-soal">
    <p class="font-weight-bold">Nomor Soal</p>
    <div class="row px-2 py-0">
        @foreach($hasil['no'] as $key => $val)
        <div class="col-2 p-1 div-nomor" z-index='999'>
            @if($val == 1)
                <a href="javascript:void(0);" class="btn btn-number btn-success d-flex justify-content-center" data-number="{{$key}}"><small class="m-0 align-self-center font-weight-bold text-white">{{$key}}</small></a>
            @elseif($val == -1)
                <a href="javascript:void(0);" class="btn btn-number btn-danger d-flex justify-content-center" data-number="{{$key}}"><small class="m-0 align-self-center font-weight-bold text-white">{{$key}}</small></a>
            @elseif($val == 0)
                <a href="javascript:void(0);" class="btn btn-number btn-light d-flex justify-content-center" data-number="{{$key}}"><small class="m-0 align-self-center font-weight-bold text-muted">{{$key}}</small></a>
            @endif
        </div>
        @endforeach
    </div>
</div>

<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title font-weight-bold" id="exampleModalLongTitle">Nomor Soal</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        <div class="modal-body">
            <div class="row px-2 py-0 justify-content-center">
                @foreach($hasil['no'] as $key => $val)
                <div class="col-2 p-1 div-nomor">
                    @if($val == 1)
                        <a href="javascript:void(0);" class="btn btn-number btn-success d-flex justify-content-center" data-number="{{$key}}"><small class="m-0 align-self-center font-weight-bold text-white">{{$key}}</small></a>
                    @elseif($val == -1)
                        <a href="javascript:void(0);" class="btn btn-number btn-danger d-flex justify-content-center" data-number="{{$key}}"><small class="m-0 align-self-center font-weight-bold text-white">{{$key}}</small></a>
                    @elseif($val == 0)
                        <a href="javascript:void(0);" class="btn btn-number btn-light d-flex justify-content-center" data-number="{{$key}}"><small class="m-0 align-self-center font-weight-bold text-muted">{{$key}}</small></a>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
      </div>
    </div>
  </div>