@props([
    'for',
    'label',
])
<div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-700 sm:pt-5">
    <label for="{{ $for }}"
           class="block text-sm font-medium text-gray-100 sm:mt-px sm:pt-2">
        {{ $label }}
    </label>
    <div class="mt-1 sm:mt-0 sm:col-span-2">
        {{ $slot }}
    </div>
</div>
