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
                <th>Categoria / Tags</th>
                <th class="text-center">Azioni</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($posts as $post)
            <tr>
                <td>{{$post->id}}</td>
                <td>{{$post->title}}</td>
                <td>{{$post->slug}}</td>
                <td>{{$post->user->name}}</td>
                <td>{{$post->category ? $post->category->name : ''}}
                <br>
                    {{$post->tags->implode('name', ' - ')}}
                </td>
                <td>
                    <div class="d-flex">
                        <a class="btn btn-info mr-2" href="{{ route('admin.posts.show', $post->slug) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-activity">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </a>
                        <a class="btn btn-warning mr-2" href="{{ route('admin.posts.edit', $post->slug) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-activity">
                                <polygon points="14 2 18 6 7 17 3 17 3 13 14 2"></polygon>
                                <line x1="3" y1="22" x2="21" y2="22"></line>
                            </svg>
                        </a>
                        <form action="{{ route('admin.posts.destroy', ['post' => $post->slug]) }}"
                            method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-activity">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    <line x1="10" y1="11" x2="10" y2="17"></line>
                                    <line x1="14" y1="11" x2="14" y2="17"></line>
                                </svg>
                            </button>
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