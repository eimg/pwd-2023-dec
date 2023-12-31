@extends("layouts.app")

@section("content")
    <div class="container" style="max-width: 800px">

        @if(session('info'))
            <div class="alert alert-info">
                {{ session('info') }}
            </div>
        @endif

        <div class="card mb-2 border-primary">
            <div class="card-body">
                <h2 class="card-title">{{ $article->title }}</h2>
                <div class="text-muted">
                    <b class="text-success">{{ $article->user->name }}</b>,
                    <b>Category:</b> {{ $article->category->name }},
                    {{ $article->created_at->diffForHumans() }}
                </div>
                <p style="font-size: 1.2em">
                    {{ $article->body }}
                </p>
                @auth
                    @can('delete-article', $article)
                        <a href="{{ url("/articles/delete/$article->id") }}"
                            class="btn btn-sm btn-outline-danger">
                            Delete
                        </a>
                        <a href="{{ url("/articles/edit/$article->id") }}"
                            class="btn btn-sm btn-outline-primary">
                            Edit
                        </a>
                    @endcan
                @endauth
            </div>
        </div>

        <ul class="list-group mt-4">
            <li class="list-group-item active">Comment ({{ count($article->comments) }})</li>
            @foreach ($article->comments as $comment)
                <li class="list-group-item">
                    @can('delete-comment', $comment)
                        <a href="{{ url("/comments/delete/$comment->id") }}"
                            class="btn-close float-end"></a>
                    @endcan

                    <b class="text-success">{{ $comment->user->name }}</b> - 
                    {{ $comment->content }}
                </li>
            @endforeach
        </ul>
        @auth
            <form action="{{ url("/comments/add") }}" method="post">
                @csrf
                <input type="hidden" name="article_id" value="{{ $article->id }}">
                <textarea name="content" class="form-control my-2"></textarea>
                <button class="btn btn-secondary">Add Comment</button>
            </form>
        @endauth
    </div>
@endsection
