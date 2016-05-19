@extends('app')

@section('content')
    <h1 class="page-header">Categorias</h1>
    <a href="{{route('admin.categories.create')}}" class="btn btn-default">Adicionar</a>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Codigo</th>
                <th>Categoria</th>
                <th>Ação</th>
            </tr>
            </thead>
            <tbody>

    @foreach($categories as $category )
            <tr>
                <td>{{ $category->id }}</td>
                <td>{{ $category->name}}</td>
                <td><a href="{{route('admin.categories.edit',[$category->id])}}" class="btn btn-default btn-small">Editar</a>
                    <a href="{{route('admin.categories.destroy',[$category->id])}}" class="btn btn-danger btn-small">Excluir</a>
                </td>
            </tr>
    @endforeach
            </tbody>
        </table>

        {!! $categories->render() !!}
    </div>

@endsection