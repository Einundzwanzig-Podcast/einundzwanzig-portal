<div>
    @php
        $a = (bool)rand(0, 1);
    @endphp
    @if($a)
        <img class="h-12" src="{{ asset('img/social_credit_minus.webp') }}" alt="">
    @endif
    @if(!$a)
        <img class="h-12" src="{{ asset('img/social_credit_plus.webp') }}" alt="">
    @endif
</div>
