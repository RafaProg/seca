@extends('adminlte::page')

@section('title', 'Cadastro de Salas de Aula - ')

@section('content')
<div class="box box-success">
    <div class="box-header with-border">
      <h3 class="box-title">Cadastro de Salas de Aula</h3>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
<form role="form" action="{{ route('classroom.store') }}" method="POST">
    {{ csrf_field() }}    
    <div class="box-body">
        <div class="form-group">
          <label for="exampleInputEmail1">Quantidade de Salas:</label>
        <input type="number" name="numberClassroom" value="{{ $numberClassroom }}" class="form-control" placeholder="Quantidade de Salas" min="0">
    </div>
      <!-- /.box-body -->

    <div class="box-footer">
        <button type="submit" class="btn btn-primary">Salvar</button>
    </div>
    </form>
  </div>
@stop