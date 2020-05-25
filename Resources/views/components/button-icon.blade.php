@if ($type=='button')    
<<<<<<< HEAD
<button class="btn btn-labeled {{$class}}" type="button" id="{{$id}}">
    <span class="btn-label"><i class="fas fa-fw {{$icon}}"></i></span>{{$text}}
</button>
@elseif($type=='submit')
<button class="btn btn-labeled {{$class}}" type="submit" id="{{$id}}">
    <span class="btn-label"><i class="fas fa-fw {{$icon}}"></i></span>{{$text}}
</button>
@else
<a class="btn btn-labeled {{$class}}" href="{{route($link)}}" role="button" id="{{$id}}">
=======
<button {{ $attributes->merge(['class' => 'btn btn-labeled']) }} type="button">
    <span class="btn-label"><i class="fas fa-fw {{$icon}}"></i></span>{{$text}}
</button>
@elseif($type=='submit')
<button {{ $attributes->merge(['class' => 'btn btn-labeled']) }} type="submit">
    <span class="btn-label"><i class="fas fa-fw {{$icon}}"></i></span>{{$text}}
</button>
@else
<a {{ $attributes->merge(['class' => 'btn btn-labeled']) }} href="{{$link}}" role="button">
>>>>>>> 8ba76e70022cef1a869f10e628614facb6b5eea1
    <span class="btn-label"><i class="fas fa-fw {{$icon}}"></i></span>{{$text}}
</a>
@endif