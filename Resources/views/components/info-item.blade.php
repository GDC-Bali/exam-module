<div class="text-group">
    <i {{ $attributes->merge(['class' => 'fas fa-fw '.$icon.' attempt-info-icon']) }}></i>
    <div class="attempt-info-div">
        <p class="text-secondary">
            <label class="mb-0" >{{$label}}</label>
            <br>
            <strong>{{$text}}</strong>
        </p>               
    </div>
</div>