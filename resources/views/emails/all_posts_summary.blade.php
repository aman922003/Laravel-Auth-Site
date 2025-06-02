<!DOCTYPE html>
<html>
<head>
    <title>All Blog Posts</title>
</head>
<body>
    <h2>Blog Posts Summary</h2>
    @foreach ($posts as $post)
        <div style="margin-bottom: 20px;">
            <h3>{{ $post->title }}</h3>
            <p><strong>Author:</strong> {{ $post->user->name ?? 'Unknown' }}</p>
            <p><strong>Date:</strong> {{ $post->created_at->format('F d, Y') }}</p>
            <p><strong>Content:</strong> {{ $post->content }}</p>
            <hr>
        </div>
    @endforeach
</body>
</html>
