@extends('adminlte::page')

@section('title', 'Configurar Ordem de Liberação - ')

@push('css')
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endpush

@section('content')
<div class="box box-success">
    <div class="box-header with-border">
      <h3 class="box-title">Configuração da Ordem de Liberação</h3>
    </div>
    
  <form role="form" action="{{ route('classroom.config-release-update') }}" method="POST">
    {{ csrf_field() }}
    {{ method_field('put') }}
    
    <div class="col-xs-12">
      <div>
        <!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
            <table class="table table-hover">
                <thead>  
                    <tr>
                    <th>Salas</th>
                    <th>Turma</th>
                    <th>Curso</th>
                    <th>Posição Atual</th>
                    <th>Nova Posição</th>
                    </tr>
                </thead>

                <tbody id="sortable">
                @forelse ($releases as $release)
                <tr id="{{ str_replace(' ', '', $release->classroom->classroom) }}">
                    <td>{{ ucfirst($release->classroom->classroom) }}</td>
                    <td>colocar</td>
                    <td>colocar</td>
                    <td><span class="badge bg-red">{{ $release->release_order }}</span></td>
                    <td><span class="badge bg-green">0</span></td>
                </tr>
                @empty
                    <h3>Não há salas cadastradas!</h3>
                @endforelse

                </tbody>
            </table>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>

      <div class="box-footer">
          <button type="submit" class="btn btn-primary">Salvar</button>
      </div>

      <input type="hidden" name="classrooms" id="datarooms">
    </form>
    
  </div>
@stop

@push('js')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="{{ asset('js/ordering-classroom.js') }}"></script>
@endpush