<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __($libro->titulo) }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-12">
        <div class="contenido-libro text-gray-700 leading-relaxed text-lg">
            {!! nl2br(e(preg_replace('/\./', '', $libro->contenido))) !!}
        </div>
    </div>
</x-app-layout>

<style>
    .contenido-libro {
    width: 1100px;
    padding-left: 200px
    }

</style>