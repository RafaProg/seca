@extends('adminlte::page')

@section('title', 'Configurar Ordem de Liberação - ')

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
            <tbody><tr>
              <th>Salas</th>
              <th>Turma</th>
              <th>Curso</th>
              <th>Ordem de Liberação</th>
              <th>Reordenar Liberação</th>
            </tr>

            @forelse ($classrooms as $classroom)
              <tr>
                <td>{{ ucfirst($classroom->classroom) }}</td>
                <td>colocar</td>
                <td>colocar</td>
                <td>{{ $classroom->release->release_order }}</td>
                <td>
                  <select name="" class="form-control">
                    <option selected style="color: rgb(189, 195, 199)" >Selecionar nova ordem</option>
                    @for($i = 1; $i <= count($classrooms); $i++)
                      <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                  </select>
                </td>
              </tr>
            @empty
                <h3>Não há salas cadastradas!</h3>
            @endforelse

          </tbody></table>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>

      <div class="box-footer">
          <button type="submit" class="btn btn-primary">Salvar</button>
      </div>
    </form>
    
  </div>
@stop