@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                        <form method="POST" action="/prizes" class="mr-1">
                            @csrf
                            <button class="btn btn-success">Generate random prize</button>
                        </form>
                    <br>

                    <br>

                    @if(isset($prize))
                        <ul>
                            <li>{{$prize['title']}}</li>
                            <li>{{$prize['sum']}}</li>
                            <li>{{$prize['product']}}</li>
                        </ul>
                        {{--<span>{{$prize->title}}</span>--}}
                        <form method="POST" action="/prizes/{{$prize['id']}}" class="mr-1">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger">Reject the prize</button>
                        </form>

                            <a href="" class="btn btn-primary">Зачислить баллы</a>
                            <a href="" class="btn btn-primary">Конвертировать в баллы</a>
                            <a href="" class="btn btn-primary">Перевести в банк</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
