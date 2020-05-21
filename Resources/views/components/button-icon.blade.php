@if ($type=='button')    
<button {{ $attributes->merge(['class' => 'btn btn-labeled']) }} type="button">
    <span class="btn-label"><i class="fas fa-fw {{$icon}}"></i></span>{{$text}}
</button>
@elseif($type=='submit')
<button {{ $attributes->merge(['class' => 'btn btn-labeled']) }} type="submit">
    <span class="btn-label"><i class="fas fa-fw {{$icon}}"></i></span>{{$text}}
</button>
@else
<a {{ $attributes->merge(['class' => 'btn btn-labeled']) }} href="{{$link}}" role="button">
    <span class="btn-label"><i class="fas fa-fw {{$icon}}"></i></span>{{$text}}
</a>
@endif