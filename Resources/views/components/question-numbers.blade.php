<style>
    .div-nomor {
        margin:1px;
    }
</style>
<div class="col-md-4 offset-md-3 d-none d-md-block" id="nomor-soal">
    <p class="font-weight-bold">Nomor Soal</p>
    <div class="row px-2 py-0">
        @for ($i = 0; $i < $totalquestions; $i++)
        <div class="col-2 p-1 div-nomor">
            <a href="?page={{$i+1}}" class="btn btn-light d-flex justify-content-center"><small class="m-0 align-self-center font-weight-bold text-muted">{{$i+1}}</small></a>
        </div>
        @endfor
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
                @for ($i = 0; $i < $totalquestions; $i++)
                <div class="col-2 p-1 div-nomor">
                    <a href="?page={{$i+1}}" class="btn btn-light d-flex justify-content-center"><small class="m-0 align-self-center font-weight-bold text-muted">{{$i+1}}</small></a>
                </div>
                @endfor
            </div>
        </div>
      </div>
    </div>
  </div>