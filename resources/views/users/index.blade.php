@extends('layouts.app')

@section('content')
    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 10%;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Usuários

                        <a href="{{ route('users.create') }}" class="btn btn-sm btn-outline-primary float-end">
                            Novo
                        </a>
                    </div>

                    <div class="card-body">
                        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                            @if(Session::has('alert-' . $msg))
                                <div class="alert alert-{{ $msg }} text-center mb-3">
                                    {!! Session::get('alert-' . $msg) !!}
                                </div>
                            @endif
                        @endforeach

                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nome</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Telefones</th>
                                    <th scope="col">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <th>{{ $user->id }}</th>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td><a onclick="phones({{ $user->id }})" class="btn btn-sm btn-outline-primary">Telefones</a></td>
                                        <td>
                                            <form action="{{ route('users.destroy', $user->id) }}" method="post">
                                                @csrf
                                                @method('delete')

                                                <a href="{{ route('users.edit', $user->id) }}"
                                                   class="btn btn-sm btn-outline-info">Editar</a>
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    Apagar
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="row">
                            <div class="col-lg-6 col-sm-12">{{ $users->links() }}</div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="float-xl-end">
                                    Mostrando {{ $users->count() }} de um total de
                                    {{ $users->total() }} registro(s)
                                </div>
                            </div>
                        </div>

                        <div id="user-phones" class="modal">
                            <div id="phone-list" class="modal-content"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var modal = document.getElementById("user-phones");

        window.onclick = function(event) {
            if (event.target === modal) {
                modal.style.display = "none";
            }
        }

        function phones(id) {
            axios.get("./usuarios/show_phones/"+id, {})
                .then(response => {

                    if (response.data.erro) {
                        return;
                    }

                    innerHtml = "<ul>";

                    $.each(response.data, function(index, value) {
                        console.log(value)
                        innerHtml += "<li>";
                        innerHtml += value['phone_number'];
                        innerHtml += "</li>";
                    });

                    innerHtml += "</ul>";

                    $('#phone-list').empty().append(innerHtml);
                    $('#user-phones').attr('style', 'display: block');

                }).catch(
                    erro => {
                        console.log(erro);
                    }
                );
        }
    </script>
@endsection
