@extends('app')

@section('content')
    <h1 class="page-header">Clientes</h1>
    <a href="{{route('admin.clients.create')}}" class="btn btn-default">Adicionar</a>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Nome</th>
                <th>Telefone</th>
                <th>Endereço</th>
                <th>Cidade</th>
                <th>UF</th>
                <th>CEP</th>
                <th>Ação</th>
            </tr>
            </thead>
            <tbody>

    @foreach($clients as $client )
            <tr>
                <td>{{ $client->user['name'] }}</td>
                <td>{{ $client->phone }}</td>
                <td>{{ $client->address }}</td>
                <td>{{ $client->city }}</td>
                <td>{{ $client->state }}</td>
                <td>{{ $client->zipcode}}</td>
                <td><a href="{{route('admin.clients.edit',[$client->id])}}" class="btn btn-default btn-small">Editar</a>
                    <a href="{{route('admin.clients.destroy',[$client->id])}}" class="btn btn-danger btn-small">Excluir</a>
                </td>
            </tr>
    @endforeach
            </tbody>
        </table>

        {!! $clients->render() !!}
    </div>

@endsection