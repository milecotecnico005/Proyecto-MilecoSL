@extends('adminlte::page')

@section('title', 'Permisos Al Usuario')

@section('content')
<div class="container">
    <h1>Asignar Permisos al Usuario: {{ $user->name }}</h1>

    <form action="{{ route('admin.permissions.updateUserPermissions', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            @foreach($permissions as $permission)
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}" 
                           @if($user->hasPermissionTo($permission)) checked @endif>
                    <label class="form-check-label" for="permissions[]">{{ $permission->name }}</label>
                </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Permisos</button>
    </form>
</div>
@endsection
