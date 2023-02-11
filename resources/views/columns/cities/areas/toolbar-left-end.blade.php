<div class="w-full mb-4 md:w-auto md:mb-0" x-data="{currentUrl: window.location.href}">
    <a x-bind:href="'http://localhost/city/form/?fromUrl='+currentUrl">
        <x-button>
            <i class="fa fa-thin fa-plus"></i>
            {{ __('New City') }}
        </x-button>
    </a>
</div>
