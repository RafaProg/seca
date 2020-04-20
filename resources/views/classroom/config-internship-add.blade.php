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