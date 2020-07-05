@extends('adminlte::page')

@section('title', 'Cadastro de Usuários - ')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Lista de Usuários</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <table class="table table-bordered">
            <tbody><tr>
                <th style="width: 10px">#</th>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Função</th>
                @can('isAdministrator', Auth::user())
                    <th>Ações</th>
                @endcan
            </tr>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ ucfirst($user->role) }}(a)</td>
                    @can('isAdministrator', Auth::user())
                        <td>
                            <a href="{{ route('user.edit', $user->id) }}" class="btn btn-warning">Editar</a>
                            <form action="{{ route('user.delete', $user->id) }}" method="POST" style="display: inline-block; margin-top: 3px;">
                                @csrf
                                @method('DELETE')
                                @if (Auth::user()->id === $user->id)
                                    <button button class="btn btn-danger" disabled>Excluir</button>
                                @else
                                    <button class="btn btn-danger">Excluir</button>
                                @endif
                            </form>
                        </td>
                    @endcan
                </tr>
            @endforeach
            </tbody></table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer clearfix">
            <ul class="pagination pagination-sm no-margin pull-right">
            <li><a href="#">«</a></li>
            <li><a href="#">1</a></li>
            <li><a href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li><a href="#">»</a></li>
            </ul>
        </div>
        </div>
        <!-- /.box -->
    </div>
</div>
@endsection