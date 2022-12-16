<div class="flex flex-col space-y-1 justify-center items-center">
    <img class="h-8" src="{{ asset('vendor/blade-country-flags/1x1-'.$row->venue->city->country->code.'.svg') }}"
         alt="{{ $row->venue->city->country->code }}">
    <div>
        {{ $row->venue->city->country->code }}
    </div>
</div>
