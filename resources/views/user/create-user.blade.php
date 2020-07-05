@extends('adminlte::page')

@section('title', 'Cadastro de Usuários - ')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Novo Usuário</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            @if (isset($user))
            <form role="form" action="{{ route('user.update', $user->id) }}" method="POST">
                @method('PUT')
            @else
            <form role="form" action="{{ route('user.store') }}" method="POST">
            @endif
              <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        @csrf
                        <div class="form-group">

                            <label for="name">Nome</label>
                            @error('name')
                                <span style="color: red; font-weight: bold;">
                                    <br>{{ $message }}
                                </span>
                            @enderror
                            <input type="text" name="name" value="{{ isset($user) ? $user->name : '' }}" class="form-control" id="name" placeholder="Nome completo">
                        </div>
                        @if (!isset($user))
                        <div class="form-group">
                            <label for="email">Email</label>
                            @error('email')
                                <span style="color: red; font-weight: bold;">
                                    <br>{{ $message }}
                                </span>
                            @enderror
                            <input type="email" name="email" value="{{ isset($user) ? $user->email : '' }}" class="form-control" id="email" placeholder="Email">
                        </div>    
                        @endif
                        <div class="form-group">
                            <label for="role">Função</label>
                            @error('role')
                                <span style="color: red; font-weight: bold;">
                                    <br>{{ $message }}
                                </span>
                            @enderror
                            <select name="role" id="role" class="form-control">
                                <option>Selecione o papel do usuário no sistema</option>
                                <option value="administrador" @if (isset($user)) {{ $user->role === 'administrador' ? 'selected' : '' }} @endif>
                                    Administrador
                                </option>
                                <option value="controlador" @if (isset($user)) {{ $user->role === 'controlador' ? 'selected' : '' }} @endif>
                                    Controlador
                                </option>
                                <option value="monitor" @if (isset($user)) {{ $user->role === 'monitor' ? 'selected' : '' }} @endif>
                                    Monitor
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password">Senha</label>
                            @error('password')
                                <span style="color: red; font-weight: bold;">
                                    <br>{{ $message }}
                                </span>
                            @enderror
                            <input type="password" name="password" class="form-control" id="password" placeholder="Senha">
                        </div>
                        <div class="form-group">
                            <label for="passwordConfirmation">Confirmação de Senha</label>
                            @error('password')
                                <span style="color: red; font-weight: bold;">
                                    <br>{{ $message }}
                                </span>
                            @enderror
                            <input type="password" name="password_confirmation" class="form-control" id="passwordConfirmation" placeholder="Confirme a senha">
                        </div>
                    </div>
                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Cadastrar</button>
              </div>
            </form>
        </div>
    </div>
</div>
@endsection