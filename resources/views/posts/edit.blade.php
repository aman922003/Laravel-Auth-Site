@extends('layouts.app')

@section('title', 'Edit Post')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Edit Post</h2>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('posts.update', $post->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" id="title" value="{{ $post->title }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="content" class="form-label">Content</label>
                    <textarea name="content" id="content" class="form-control" rows="5" required>{{ $post->content }}</textarea>
                </div>

                @if($post->image)
                    <div class="mb-3">
                        <label class="form-label">Current Image</label><br>
                        <img src="{{ asset('storage/' . $post->image) }}" class="img-thumbnail" style="max-width: 250px;">
                    </div>
                @endif

                <div class="mb-3">
                    <label for="image" class="form-label">Change Image (optional)</label>
                    <input type="file" name="image" id="image" class="form-control">
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('posts.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Post</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('content');
</script>
@endsection
