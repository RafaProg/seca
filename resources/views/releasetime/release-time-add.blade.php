<tr id="line{{ $newReleaseTime->id }}">
    <td>{{ $newReleaseTime->release_time }}</td>
    <td>{{ $newReleaseTime->release_in_sequence ? 'Sim' : 'Não' }}</td>
    <td>
        <input type="hidden" id="tokenDelete{{ $newReleaseTime->id }}" name="_token" value="{{ csrf_token() }}">
        <button class="btn btn-danger" id="delete-time{{ $newReleaseTime->id }}"><i class="fas fa-trash-alt"></i></button>
    </td>
</tr>