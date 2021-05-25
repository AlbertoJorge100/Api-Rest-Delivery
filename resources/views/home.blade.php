<!-- Aqui heredaremos la plantilla para todas las paginas
    que esta en: layouts/plantilla.blade.php  -->
@extends('layouts.plantilla')

@section('title','Home')

@section('content')

    {{-- Contar los productos que trae la lista --}}
    {{-- <h4>{{count($productos)}}</h4> --}}
    
    <a href="{{route('cursos.create')}}">Añadir un producto</a>
    <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" {{-- width="100%" --}} cellspacing="0">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Existencias</th>                    
                    <th>Estado</th>                
                    <th>Imagen</th>
                    {{-- <th>Descripcion</th> --}}
                    <th>IDCategoria</th>                
                    <th>Accion</th>                
                </tr>
            </thead>
            <tbody>
                <a href={{route('cursos.create')}}></a>
                @foreach ($productos as $producto)
                    <tr>
                        <td>{{$producto->Producto}}</td>
                        <td>$ {{$producto->Precio}}</td>
                        <td>{{$producto->Existencias}}</td>s                            
                        <td>
                            @if ($producto->Existencias>=10)
                                En stock
                            @elseif($producto->Existencias>=5 &&
                                $producto->Existencias<10)
                                Pocas exist..
                            @else
                                Agotadas                            
                            @endif
                        </td>
                       
                        <td>imagen</td>
                        {{-- <td>{{$producto->Descripcion}} </td> --}}
                        <td>{{$producto->IDCategoria}}</td>
                        
                        <td>
                            <a href={{route('cursos.edit',$producto)}}>Modificar</a>                    
                            <a href={{route('cursos.delete',$producto)}}>Eliminar</a>
                        </td>
                        
                    </tr>
                @endforeach
                
            </tbody>
        </table>  
    </div>
    
@endsection
