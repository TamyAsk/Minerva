<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mis libros') }}
        </h2>
    </x-slot>

    <div style="max-width: 1200px; margin: 0 auto; padding: 30px; border-radius: 12px;">
        @if($libros->whereIn('estatus', [1, 2])->isEmpty())
            <p style="text-align: center; color: #7f8c8d; font-size: 1.2rem;">{{ __('No hay libros disponibles para mostrar.') }}</p>
        @else
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; background: #ffffff; border-radius: 12px; overflow: hidden;">
                    <thead>
                        <tr style="background: #2c3e50; color: #ecf0f1; border-bottom: 2px solid #34495e;">
                            <th style="padding: 15px; text-align: left; font-weight: bold;">Portada</th>
                            <th style="padding: 15px; text-align: left; font-weight: bold;">Título</th>
                            <th style="padding: 15px; text-align: left; font-weight: bold;">Estatus</th>
                            <th style="padding: 15px; text-align: left; font-weight: bold;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($libros->whereIn('estatus', [1, 2]) as $libro)
                            <tr style="border-bottom: 1px solid #ecf0f1; background: #ffffff; transition: background-color 0.3s;">
                                <!-- Portada -->
                                <td style="padding: 15px; text-align: center;">
                                    <img src="{{ asset($libro->portada) }}" alt="{{ $libro->titulo }} Portada" style="height: 100px; width: auto; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                </td>
                                <!-- Título -->
                                <td style="padding: 15px; font-size: 1.1rem; color: #34495e; font-weight: 500;">
                                    {{ $libro->titulo }}
                                </td>
                                <!-- Estatus -->
                                <td style="padding: 15px; font-size: 1rem; color: #7f8c8d;">
                                    @if ($libro->estatus == 1)
                                        <span style="background: #e67e22; color: #ffffff; padding: 5px 10px; border-radius: 20px; font-size: 0.9rem;">Borrador</span>
                                    @elseif ($libro->estatus == 2)
                                        <span style="background: #2ecc71; color: #ffffff; padding: 5px 10px; border-radius: 20px; font-size: 0.9rem;">Publicado</span>
                                    @endif
                                </td>
                                <!-- Acciones -->
                                <td style="padding: 15px;">
                                    <a href="{{ route('libro.publicar', ['id' => $libro->pk_libros, 'estatus' => $libro->estatus == 1 ? 2 : 1]) }}" 
                                        style="background: #3498db; color: #ffffff; padding: 8px 12px; border-radius: 5px; text-decoration: none; font-size: 0.9rem; margin-right: 8px; display: inline-block;">
                                        @if ($libro->estatus == 1)
                                            Publicar
                                        @elseif ($libro->estatus == 2)
                                            Bajar
                                        @endif
                                    </a>
                                    <a href="{{ route('libro.editar', ['id' => $libro->pk_libros]) }}" 
                                        style="background: #9b59b6; color: #ffffff; padding: 8px 12px; border-radius: 5px; text-decoration: none; font-size: 0.9rem; margin-right: 8px; display: inline-block;">
                                        Editar
                                    </a>
                                    <a href="{{ route('libro.eliminar', ['id' => $libro->pk_libros]) }}" 
                                        style="background: #e74c3c; color: #ffffff; padding: 8px 12px; border-radius: 5px; text-decoration: none; font-size: 0.9rem; display: inline-block;">
                                        Borrar
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-app-layout>
