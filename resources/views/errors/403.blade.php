<x-app-layout class="h-full">
    <main class="min-h-full bg-cover bg-top sm:bg-top" style="background-image: url('https://images.unsplash.com/photo-1545972154-9bb223aac798?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=3050&q=80&exp=8&con=-15&sat=-75')">
        <div class="mx-auto max-w-7xl py-16 px-6 text-center sm:py-24 lg:px-8 lg:py-48">
            <p class="text-base font-semibold text-black text-opacity-50">403</p>
            <h1 class="mt-2 text-4xl font-bold tracking-tight text-white sm:text-5xl">Uh oh! I think you’re lost.</h1>
            <p class="mt-2 text-lg font-medium text-black text-opacity-50">{{ __('You do not have permission to view the page.') }}</p>
            <div class="mt-6">
                <a href="#" class="inline-flex items-center rounded-md border border-transparent bg-white bg-opacity-75 px-4 py-2 text-sm font-medium text-black text-opacity-75 sm:bg-opacity-25 sm:hover:bg-opacity-50">Go back home</a>
            </div>
        </div>
    </main>
</x-app-layout>
