@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Novo usuário</div>

                    <div class="card-body">
                        @if(Session::has('alert-danger'))
                            <div class="alert alert-danger text-center mb-3">
                                {!! Session::get('alert-danger') !!}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('users.store') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">Nome</label>

                                <div class="col-md-6">
                                    <input id="name"
                                           type="text"
                                           class="form-control @error('name') is-invalid @enderror"
                                           name="name" value="{{ old('name') }}" required autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">Email</label>

                                <div class="col-md-6">
                                    <input id="email"
                                           type="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           name="email" value="{{ old('email') }}" required>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end">Senha</label>

                                <div class="col-md-6">
                                    <input id="password"
                                           type="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           name="password" required>

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            @php
                            $old = [1 => 1];
                            if (!empty(old('phones'))) {
                                $old = old('phones');
                            }
                            @endphp

                            <div class="replica">
                                @foreach($old as $keyOld => $phone)
                                    <div class="replicated" id="{{ $keyOld }}">
                                        <div class="row mb-3">
                                            <label for="phone"
                                                   class="col-md-4 col-form-label text-md-end">Telefone</label>

                                            <div class="col-md-5">
                                                <input id="phone"
                                                       type="text"
                                                       class="form-control @error("phones.{{ $keyOld }}.phone") is-invalid @enderror"
                                                       name="phones[{{ $keyOld }}][phone]"
                                                       value="{{ $phone['phone'] ?? null }}" required>

                                                @error("phones.{{ $keyOld }}.phone")
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            @if($keyOld > 1)
                                                @php
                                                    $simbol = "-";
                                                    $class = "btn btn-outline-danger";
                                                    $jqueryFunction = "remove_replica($keyOld);";
                                                @endphp
                                            @else
                                                @php
                                                    $simbol = "+";
                                                    $class = "btn btn-outline-success";
                                                    $jqueryFunction = "replicate_fields();";
                                                @endphp
                                            @endif

                                            <div class="col-md-1">
                                                <a id="btnReplica"
                                                   class="{{ $class }}"
                                                   onclick="{{ $jqueryFunction }}">
                                                    {{ $simbol }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            @dump($errors)

                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Gravar
                                    </button>

                                    <a href="{{ route('users.index') }}" class="btn btn-secondary">
                                        Cancelar
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function replicate_fields () {
            let count = $('.replicated:last').attr('id');
            let original = $('.replicated:last').clone();
            let copy = original.attr({
                'class': 'replicated',
                'id': ++count
            })
                .insertAfter('.replicated:last')
                .appendTo('.replica');

            $(copy).find('input').each(function(i){
                $(this).attr({
                    'id': $(this).attr('id'),
                    'name': 'phones['+count+']['+$(this).attr('id')+']'
                }).val('');
            });

            $(copy).find('a').each(function(y){
                $(this).attr({
                    'id': $(this).attr('id')+count,
                    'class': 'btn btn-outline-danger',
                    'onclick': 'remove_replica('+count+')'
                }).text('-');
            });
        }

        function remove_replica (id) {
            if ($('.replicated:last').attr('id') > 1) {
                $('div').remove('#'+id);
            }
        }
    </script>
@endsection
