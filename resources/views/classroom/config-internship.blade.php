@extends('adminlte::page')

@section('title', 'Turmas em Estágio')  

@section('content_header')
    <h1>Turma em Estágio</h1>
@stop

@section('content')
<div class="row" id="jq_load_classroom_internship">
<form action="{{ route('classroom.store-config-internship') }}" method="POST" style="overflow-y: scroll; height: 520px;">
    @csrf
    @forelse ($classrooms as $classroom)
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
          <div class="inner">
            <h3>{{ $classroom->classroom }}</h3>

            <p>Informática 3C</p>

            <label for="">
            <input type="checkbox" name="{{ str_replace(' ', '', $classroom->classroom) }}" value="{{ $classroom->id }}" @isset($classroom->internship) checked @endisset>
              Em estágio
            </label>
            <br>
            <label for="">
            <input type="radio" name="firstOrder" value="{{ $classroom->id }}" @if($classroom->internship['first_order'] == true) checked @endif>
              Primeira liberação
            </label>
          </div>
          <div class="icon box-body">
            <img src="{{ asset('img/teacher.png') }}" width="80px" height="80px" alt="Imagem de uma sala de aula">
          </div>
        </div>
      </div>
    @empty
      <p>Ainda não há salas de aula cadastradas!</p>
    @endforelse
    <div id="jq_classrooms_add">
    </div>
    @isset($classrooms)
        <div class="col-xs-offset-9">
          <button id="atualizar" type="submit" class="btn btn-primary btn-lg" disabled>Atualizar</button>
          <button id="excluir" type="" class="btn btn-danger btn-lg" disabled>Excluir Ordem</button>
        </div>
    @endisset
    </form>
@stop

@push('js')
  <script src="{{ asset('js/load-classroom-internship.js') }}"></script>
@endpush