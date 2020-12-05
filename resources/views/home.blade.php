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

                        <div class="form-group">
                            <a href="/prizes" class="btn btn-success">Generate random prize</a>
                        </div>
                    <br>

                    <br>

                    @if(isset($prize))
                        <ul>
                            <li>{{$prize['title']}}</li>
                            <li>{{$prize['sum']}}</li>
                            <li>{{$prize['product']}}</li>
                        </ul>
                        <form method="POST" action="/prizes/{{$prize['id']}}" class="mr-1 form-group">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger">Reject the prize</button>
                        </form>

                            <div class="form-group">
                                <a href="" class="btn btn-primary mr-1">Convert to the points</a>
                            </div>
                            @if($prize['title'] === 'Money')
                                <div class="form-group">
                                    <form method="POST" action="/user-account" class="mr-1">
                                        @csrf
                                        <input type="hidden" name="prize_id" value="{{$prize['id']}}">
                                        <button class="btn btn-primary">Deposit to the bank account</button>
                                    </form>
                                </div>
                            @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
