@extends('layouts.plantilla')

@section('title','edit')
    
@section('content')
    {{-- formulario de edicion de productos... --}}
    <form action="{{route('cursos.update', compact('producto'))}}" method="POST">
        @method('put')
        @csrf
        <input type="hidden" value="{{$producto->IDProducto}}" name="IDProducto">

        <input type="text" name="Producto" placeholder="producto" value="{{old('Producto',$producto->Producto)}}" >
        @error('Producto')
            <br>
            <small>*{{$message}}</small>            
        @enderror                
        <br/>
        <br/>
        <input type="number" name="Precio" placeholder="precio" value="{{old('Precio',$producto->Precio)}}" >
        @error('Precio')
            <br>
            <small>*{{$message}}</small>            
        @enderror                
        <br/>
        <br/>
        <input type="number" name="Existencias" placeholder="existencias" value="{{old('Existencias',$producto->Existencias)}}" >
        @error('Existencias')
            <br>
            <small>*{{$message}}</small>            
        @enderror                
        <br/>
        <br/>
        <input type="text" name="Imagen" placeholder="imagen" value="{{old('Imagen',$producto->Imagen)}}" >
        @error('Imagen')
            <br>
            <small>*{{$message}}</small>            
        @enderror                
        <br/>
        <br/>
        <input type="text" name="Descripcion" placeholder="descripcion" value="{{old('Descripcion',$producto->Descripcion)}}" >
        @error('Descripcion')
            <br>
            <small>*{{$message}}</small>            
        @enderror                
        <br/>
        <br/>
        
        <select name="Estado" id="">                
            <option
                 @if (!$producto->Estado)
                    selected
                @endif 
            value="0">Inactivo</option> 

            <option
                 @if ($producto->Estado)
                    selected
                @endif 
            value="1">Activo</option>                                               
        </select>    
        <br/>        
        <br/>
        <button type="submit">
            Ingresar
        </button>
    </form>
    
@endsection