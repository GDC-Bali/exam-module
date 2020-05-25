@if ($type=='button')    
<button class="btn btn-labeled {{$class}}" type="button" id="{{$id}}">
    <span class="btn-label"><i class="fas fa-fw {{$icon}}"></i></span>{{$text}}
</button>
@elseif($type=='submit')
<button class="btn btn-labeled {{$class}}" type="submit" id="{{$id}}">
    <span class="btn-label"><i class="fas fa-fw {{$icon}}"></i></span>{{$text}}
</button>
@else
<a class="btn btn-labeled {{$class}}" href="{{route($link)}}" role="button" id="{{$id}}">
    <span class="btn-label"><i class="fas fa-fw {{$icon}}"></i></span>{{$text}}
</a>
@endif