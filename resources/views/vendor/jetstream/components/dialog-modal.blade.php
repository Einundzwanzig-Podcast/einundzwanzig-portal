@props(['id' => null, 'maxWidth' => null, 'bg' => 'bg-white'])

<x-jet-modal :id="$id" :maxWidth="$maxWidth" :bg="$bg" {{ $attributes }}>
    <div class="px-6 py-4">
        <div class="text-lg">
            {{ $title }}
        </div>

        <div class="mt-4">
            {{ $content }}
        </div>
    </div>

    <div class="flex flex-row justify-end px-6 py-4 {{ $bg }} text-right">
        {{ $footer }}
    </div>
</x-jet-modal>
