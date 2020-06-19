@extends('adminlte::page')

@section('title', 'Cadastrar horários de liberação de salas - ')

@push('css')
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endpush

@section('content')
<div id="message">
</div>

<div class="row">
  <div class="col-sm-12">
    <div class="alert alert-danger alert-dismissible d-none alert-box">
      <button type="button" class="close" data-dismiss="alert">
          <i class="fas fa-window-close"></i>
      </button>
      
      <p>
          <i class="fas fa-exclamation-circle"></i>
          <b class="msg-alert"></b>
      </p>
  </div>

    <div class="box box-success">
      <div class="box-header with-border">
        <h3 class="box-title">Configuração do Intervalo de Liberação em Sequência</h3>
    
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <div class="row">
          <div class="col-sm-12">
            <div class="form-group">
              <label for="release-time">Tempo Entre Liberação de Salas em Sequência</label>
              <input type="number" min="1" max="60" value="{{ $interval ?? '' }}" class="form-control" id="intervalBetweenRelease">
              <input type="hidden" id="tokenInterval" value="{{ csrf_token() }}">
            </div>
          </div>
        </div>
        <!-- /.row -->
      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        <a type="button" id="save-release-time" class="btn btn-primary">Salvar Intervalo</a>
      </div>
    </div>
  </div>

  <div class="col-sm-12">
    <div class="box box-success">
      <div class="box-header with-border">
        <h3 class="box-title">Horários Configurados para Liberação de Salas de Aula</h3>
    
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
        </div>
      </div>

      <div class="box-body">
        <div class="row">
          <div class="col-sm-12">
            <table class="table table-bordered">
              <tbody>
                <tr>
                  <th>Horário de Liberação</th>
                  <th>Liberação em Sequência</th>
                  <th></th>
                </tr>
                @foreach ($releaseTimes as $releaseTime)
                  <tr id="line{{ $releaseTime->id }}">
                    <td>{{ $releaseTime->release_time }}</td>
                    <td>{{ $releaseTime->release_in_sequence ? 'Sim' : 'Não' }}</td>
                    <td>
                      <input type="hidden" id="tokenDelete{{ $releaseTime->id }}" name="_token" value="{{ csrf_token() }}">
                      <button class="btn btn-danger" id="delete-time{{ $releaseTime->id }}"><i class="fas fa-trash-alt"></i></button>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="box-footer">
        <div class="row">
          <div class="col-sm-5">
            <div class="form-group">
              <input type="time" class="form-control" id="releaseTime">
            </div>
          </div>
          
          <div class="col-sm-5">
            <div class="form-group">
              <select class="form-control" id="modeRelease">
                <option value="1" selected>Liberer salas de aula em sequência.</option>
                <option value="0">Liberar todas as salas de aula.</option>
              </select>
            </div>
            <input type="hidden" id="tokenAdd" value="{{ csrf_token() }}">
          </div>
          
          <div class="col-sm-2">
            <a type="button" id="add-time" class="btn btn-primary">Adicionar Horário</a>
          </div>

        </div>
      </div>

    </div>
  </div>
</div>
@endsection

@push('js')
  <script src="{{ asset('js/release-time.js') }}"></script>
@endpush