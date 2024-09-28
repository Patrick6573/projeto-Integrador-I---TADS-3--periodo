@extends('layouts.main')

@section('title', 'Bem vindo')

@section('content')


<h3>Minhas Casas</h3>
<p>oi</p>

<tbody>
    <tr>
        <td>
            <form action="/minhasCasas/0128fa8b-920d-4fd9-8283-409393e36c2a" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger delete-btn"><ion-icon name="trash-outline"></ion-icon>Deletar</button>
            </form>
        </td>
    </tr>
</tbody>
    
@endsection