<div id="soal-container">

</div>

<div class="d-none d-md-flex mt-4 mb-5">    
    <div class="my-1 mr-2">
        <a href="{{route('exam.attempt.result', $attempt->id)}}">
            <button class="btn btn-block btn-sm btn-secondary font-weight-bold">
                KEMBALI
            </button>
        </a>
    </div>
    <div class="my-1">            
        <button class="btn-skip btn btn-block btn-sm btn-primary font-weight-bold btn-soal">
            PEMBAHASAN SOAL BERIKUTNYA
        </button>                
    </div>
</div>