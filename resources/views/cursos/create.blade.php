@extends('layouts.plantilla')

@section('title','create')
    
@section('content')   
    

    <form action="{{route('cursos.store')}}" method="POST">
        @csrf
        <input type="text" name="Producto" placeholder="producto" value="{{old('Producto')}}">
        @error('Producto')
            <br>
            <small>*{{$message}}</small>            
        @enderror                
        <br/>
        <br>
        <input type="number" name="Precio" placeholder="precio" value="{{old('Precio')}}">
        @error('Precio')
            <br>
            <small>*{{$message}}</small>            
        @enderror                
        <br/>
        <br>
        <input type="number" name="Existencias" placeholder="existencias" value="{{old('Existencias')}}">
        @error('Existencias')
            <br>
            <small>*{{$message}}</small>            
        @enderror                
        <br/>
        <br>
        <input type="text" name="Imagen" placeholder="imagen" value="{{old('Imagen')}}">
        @error('Imagen')
            <br>
            <small>*{{$message}}</small>                        
        @enderror                
        <br/>
        <br>
        <input type="text" name="Descripcion" placeholder="descripcion" value="{{old('Descripcion')}}">
        @error('Descripcion')
            <br>
            <small>*{{$message}}</small>                        
        @enderror                
        <br/>
        <br>
        <select name="IDCategoria" id="">        
            @foreach ($categorias as $categoria)
                <option value="{{$categoria->IDCategoria}}">{{$categoria->Categoria}} </option>                        
            @endforeach        
        </select>
        @error('IDCategoria')
            <br>
            <small>*{{$message}}</small>                        
        @enderror                
        <br/>
        <br>
        <button type="submit">
            Ingresar
        </button>
    </form>
    
@endsection