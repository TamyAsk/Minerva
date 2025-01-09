<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __($libro->titulo) }}
        </h2>
    </x-slot>
    <link rel="stylesheet" href="{{asset('css/mostrar_libro.css')}}">

    <div class="max-w-7xl mx-auto py-12">
        <!-- Contenedor principal con flexbox -->
        <div class="flex justify-between items-start">
            <!-- Contenido centrado -->
            <div class="contenido-libro text-gray-700 leading-relaxed text-lg mx-auto">
                {!! nl2br(e(preg_replace('/\./', '', $libro->contenido))) !!}
            </div>
            <!-- Botón al extremo derecho -->
            <a href="{{route('leer',['id'=>$libro->pk_libros])}}" 
               class="btn-leer ml-4 self-start">
                Volver
            </a>
        </div>
    </div>
</x-app-layout>

<style>
    .contenido-libro {
        max-width: 1000px;
        text-align: justify;
    }

</style>
