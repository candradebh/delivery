@extends('app')

@section('content')
    <h1 class="page-header">Cupons</h1>
    <a href="{{route('admin.cupoms.create')}}" class="btn btn-default">Adicionar</a>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Codigo</th>
                <th>Cupom</th>
                <th>Valor</th>
                <th>Ação</th>
            </tr>
            </thead>
            <tbody>

    @foreach($cupoms as $cupom )
            <tr>
                <td>{{ $cupom->id }}</td>
                <td>{{ $cupom->code}}</td>
                <td>R$ {{ $cupom->value}}</td>
                <td><a href="{{route('admin.cupoms.edit',[$cupom->id])}}" class="btn btn-default btn-small">Editar</a>
                    <a href="{{route('admin.cupoms.destroy',[$cupom->id])}}" class="btn btn-danger btn-small">Excluir</a>
                </td>
            </tr>
    @endforeach
            </tbody>
        </table>

        {!! $cupoms->render() !!}
    </div>

@endsection