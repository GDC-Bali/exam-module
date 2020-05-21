<style>
    .callout {
        border-radius: .25rem;
        box-shadow: 0 1px 3px rgba(0,0,0,.12), 0 1px 2px rgba(0,0,0,.24);
        background-color: #fff;
        margin-top: -40px;
        padding: 1rem;
    }
</style>
<div class="row">

    <div class="col-md-5">
        <div class="callout">
            <div class="row">
                <div class="col-6 text-left">
                    <small>Sisa Waktu</small>
                    <h3 class="font-weight-bold text-warning">00:59:34</h3>
                </div>
                <div class="col-6 text-right align-self-center">
                    <button id="btn-finish" type="button" class="btn btn-danger btn-sm px-3 font-weight-bold">Akhiri Ujian</button>
                </div>
            </div>
            <hr class="my-2">
            <div class="row">  
                <div class="col-4 text-center">
                    <small>Jumlah Soal</small>
                    <h5 class="m-0 font-weight-bold">{{$totalquestions}}</h5>
                </div>
                <div class="col-4 text-center">
                    <small>Sudah Dijawab</small>
                    <h5 class="m-0 font-weight-bold">25</h5>
                </div>
                <div class="col-4 text-center">
                    <small>Belum Dijawab</small>
                    <h5 class="m-0 font-weight-bold">75</h5>
                </div>
            </div>
        </div>
    </div>
    <x-exam-question-numbers :totalquestions="$totalquestions"/>
</div>