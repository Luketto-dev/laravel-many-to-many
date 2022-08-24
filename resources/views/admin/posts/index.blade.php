@extends('layouts.app')


@section('page_title', 'Lista Post')



@section('content')
<div class="container">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Titolo</th>
                <th>Slug</th>
                <th>Autore</th>
                <th>Azioni</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($posts as $post)
            <tr>
                <td>{{$post->id}}</td>
                <td>{{$post->title}}</td>
                <td>{{$post->slug}}</td>
                <td>{{$post->user->name}}</td>
                <td>
                    <div class="d-flex">
                        <a class="btn btn-info" href="{{ route('admin.posts.show', $post->slug) }}">Dettagli</a>
                        <a class="btn btn-warning" href="{{ route('admin.posts.edit', $post->slug) }}">Modifica</a>
                        <form action="{{ route('admin.posts.destroy', ['post' => $post->slug]) }}"
                            method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Elimina</button>
                        </form>
                        
                    </div>
                    
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
    <div class="text-center py-3">
        <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">Aggiungi Post</a>
    </div>
@endsection