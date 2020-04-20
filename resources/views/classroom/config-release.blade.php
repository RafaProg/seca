@extends('adminlte::page')

@section('title', 'Configurar Ordem de Liberação - ')

@section('content')
<div class="box box-success">
    <div class="box-header with-border">
      <h3 class="box-title">Ordem de Liberação do Dia</h3>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
  <form role="form" action="{{ route('classroom.config-release-update') }}" method="POST">
    {{ csrf_field() }}
    {{ method_field('put') }}
    <div class="box-body">
    <div class="input-group">
      <span class="input-group-addon"><i class="far fa-calendar-alt"></i></span>
    <input type="text" value="{{ $date }}" readonly class="form-control">
    </div>
    </div>
    <div class="box-body">
        <div class="form-group">
          <label for="firstClassroomRelease">Primeira Sala:</label>
        <input type="number" name="numberClassroom" value="{{ isset($classroom->classroom) ? mb_substr($classroom->classroom, 5) : '' }}" class="form-control" id="firstClassroomRelease" min="1" placeholder="{{ isset($classroom->classroom) ? '' : 'Não existe uma ordem de liberação previamente configurada!' }}">
    </div>

    <div class="box-footer">
        <button type="submit" class="btn btn-primary">Salvar</button>
    </div>
    </form>
  </div>
@stop