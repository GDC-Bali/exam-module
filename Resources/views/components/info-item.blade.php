<div class="text-group">
<<<<<<< HEAD
    <i class="fas fa-fw {{$icon}} attempt-info-icon {{$class}}"></i>
=======
    <i {{ $attributes->merge(['class' => 'fas fa-fw '.$icon.' attempt-info-icon']) }}></i>
>>>>>>> 8ba76e70022cef1a869f10e628614facb6b5eea1
    <div class="attempt-info-div">
        <p class="text-secondary">
            <label class="mb-0" >{{$label}}</label>
            <br>
            <strong>{{$text}}</strong>
        </p>               
    </div>
</div>