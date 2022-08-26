@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header fs-3">Benvenuto {{Auth::user()->name}}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <a href="{{route("admin.posts.index")}}" class="btn btn-primary">Vai ai Post</a>
                    <a href="{{route("admin.users.index")}}" class="btn btn-secondary">Vai agli Utenti</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
