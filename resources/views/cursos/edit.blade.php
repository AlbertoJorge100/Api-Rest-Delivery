@extends('layouts.plantilla')

@section('title','edit')    
@section('content')
    {{-- formulario de edicion de productos... --}}
    
    <form action="{{route('cursos.update', compact('producto'))}}" method="POST">
        @method('put')
        @csrf
        <input type="hidden" value="{{$producto->IDProducto}}" name="IDProducto">
        <strong>Producto</strong><br><br>
        <input type="text" name="producto" placeholder="producto" value="{{old('Producto',$producto->Producto)}}" >
        @error('producto')
            <br>
            <small>*{{$message}}</small>            
        @enderror                
        <br/>
        <br/>
        <strong>Precio</strong><br><br>
        <input type="number" name="precio" placeholder="precio"
            value="{{old('Precio',$producto->Precio)}}" step="0.01" name="amount" placeholder="0.00" >
        @error('precio')
            <br>
            <small>*{{$message}}</small>            
        @enderror                
        <br/>
        <br/>        
        <strong>Imagen</strong><br><br>
        <input type="text" name="imagen" placeholder="imagen" value="{{old('Imagen',$producto->Imagen)}}" >
        @error('imagen')
            <br>
            <small>*{{$message}}</small>            
        @enderror                
        <br/>
        <br/>
        <strong>Descripcion</strong><br><br>
        <input type="text" name="descripcion" placeholder="descripcion" value="{{old('Descripcion',$producto->Descripcion)}}" >
        @error('descripcion')
            <br>
            <small>*{{$message}}</small>            
        @enderror                
        <br/>
        <br/>
        <strong>Estado</strong><br><br>
        <select name="activo" id="">                
            <option
                 @if (!$producto->Activo)
                    selected
                @endif 
            value="0">Inactivo</option> 

            <option
                 @if ($producto->Activo)
                    selected
                @endif 
            value="1">Activo</option>                                               
        </select>    
        <br/>        
        <br/>
        {{-- Input oculto para almacenar las existencias de los productos --}}
        <input type="hidden" name="existencias" value="{{$existencias->Existencias}}">
        <strong>Existencias</strong><br><br>
        <strong>            
            {{$existencias->Existencias}}
        </strong>                
        <select name="operacion" id="">
            <option value="suma"><strong> + </strong></option>
            <option value="resta"><strong> - </strong></option>
        </select>
        <input type="number" name="add_existencias">
        <br>
        <br>
        <button type="submit">
            Modificar
        </button>
    </form>
    
@endsection