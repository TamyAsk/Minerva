<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Librería') }}
        </h2>
    </x-slot>

    <div class="container">
        <!-- Mis likes -->
        <h1 class="section-title">Mis likes</h1>
        @if($librosLikes->isEmpty())
            <div class="flex justify-center">
                <p style="color: #999;">{{ __('No hay libros con like.') }}</p>
            </div>
        @else
            <div class="grid-container">
                @foreach($librosLikes as $librol)
                    <a href="{{ route('leer', ['id' => $librol->pk_libros]) }}" class="cuadro">
                        <div>
                            <img src="{{ asset($librol->portada) }}" alt="{{ $librol->titulo }} Portada" class="portada">
                            <h3 class="titulo">{{ $librol->titulo }}</h3>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif

        <!-- Ver después -->
        <h1 class="section-title">Ver después</h1>
        @if($librosVerDespues->isEmpty())
            <div class="flex justify-center">
                <p style="color: #999;">{{ __('No hay libros para ver después.') }}</p>
            </div>
        @else
            <div class="grid-container">
                @foreach($librosVerDespues as $librov)
                    <a href="{{ route('leer', ['id' => $librov->pk_libros]) }}" class="cuadro">
                        <div>
                            <img src="{{ asset($librov->portada ?? 'ruta/de/imagen/generica.jpg') }}" alt="{{ $librov->titulo }} Portada" class="portada">
                            <h3 class="titulo">{{ $librov->titulo }}</h3>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif

        <!-- Mis libros leídos -->
        <h1 class="section-title">Mis libros leídos</h1>
        @if($librosVistos->isEmpty())
            <div class="flex justify-center w-full">
                <p style="color: #999;">{{ __('No hay libros vistos.') }}</p>
            </div>
        @else
            <div class="grid-container">
                @foreach($librosVistos as $librovi)
                    <a href="{{ route('leer', ['id' => $librovi->pk_libros]) }}" class="cuadro">
                        <div>
                            <img src="{{ asset($librovi->portada ?? 'ruta/de/imagen/generica.jpg') }}" alt="{{ $librovi->titulo }} Portada" class="portada">
                            <h3 class="titulo">{{ $librovi->titulo }}</h3>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>

<style>
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 40px 20px;
}

.section-title {
    font-size: 1.5rem;
    font-weight: bold;
    color: #2d3748;
    margin-bottom: 20px;
}

/* Grid Layout */
.grid-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 25px;
    padding-bottom: 20px;
}

/* Card Style */
.cuadro {
    background-color: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s, box-shadow 0.2s;
    text-align: center;
    text-decoration: none;
    color: inherit;
    height: auto;
    min-height: 360px; /* Altura mínima para tarjetas más uniformes */
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.cuadro:hover {
    transform: scale(1.05);
    box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
}

.portada {
    width: 100%;
    height: auto;
    max-height: 250px;
    object-fit: cover;
    border-radius: 4px;
    margin-bottom: 10px;
}

.titulo {
    font-size: 1rem;
    font-weight: 600;
    color: #2d3748;
    margin-top: 10px;
}
</style>
