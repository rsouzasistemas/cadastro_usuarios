@extends('layouts.app')

@section('content')
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
                                        <td>Telefones</td>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
