<style>
    .option-text > p {
        margin: 0 !important;
    }
</style>
@php
    $nOptions = array();

    $k = "A";
    foreach($options as $option)
    {
        $nOptions[$k] = $option;
        $k++;
    }
@endphp
<div class="form-check mt-2">
    <form action="{{route('attempt.store')}}" method="POST">
        @foreach ($nOptions as $key=>$option)
            <label class="pl-3 option-text"><input type="radio" name="answer" value="{{$option->id}}"/>
                <span class="font-weight-bold">{{$key}}</span>
                {!!$option->option_text!!}
            </label>
        @endforeach
    </form>
</div>
