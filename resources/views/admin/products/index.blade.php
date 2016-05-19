@extends('app')

@section('content')
    <h1 class="page-header">Produtos</h1>
    <a href="{{route('admin.products.create')}}" class="btn btn-default">Adicionar</a>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Codigo</th>
                <th>Produto</th>
                <th>Preço</th>
                <th>Categoria</th>
                <th>Ação</th>
            </tr>
            </thead>
            <tbody>

    @foreach($products as $product )
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->name}}</td>
                <td>{{ $product->price}}</td>
                <td>{{ $product->category->name}}</td>
                <td><a href="{{route('admin.products.edit',[$product->id])}}" class="btn btn-default btn-small">Editar</a>
                    <a href="{{route('admin.products.destroy',[$product->id])}}" class="btn btn-danger btn-small">Excluir</a>
                </td>
            </tr>
    @endforeach
            </tbody>
        </table>

        {!! $products->render() !!}
    </div>

@endsection