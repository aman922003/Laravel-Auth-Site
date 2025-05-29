<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

</head>
<script>
function sharePost(url) {
    if (navigator.share) {
        navigator.share({
            title: document.title,
            url: url,
        }).catch(console.error);
    } else {
        navigator.clipboard.writeText(url).then(() => {
            alert('Link copied to clipboard!');
        });
    }
}
</script>

<body class="bg-light">
    <div class="container py-5">
        <div class="card shadow-lg rounded-4 mb-4 border-0 overflow-hidden">
            <!-- Header -->
            <div class="card-header bg-primary bg-gradient text-white py-3">
                <h2 class="card-title fw-bold mb-0 display-6">{{ $post->title }}</h2>
                <div class="d-flex align-items-center mt-2">
                    <i class="bi bi-person-circle me-2"></i>
                    <span class="me-3">By <strong>{{ $post->user->name }}</strong></span>
                    <i class="bi bi-calendar me-2"></i>
                    <span>Posted on {{ $post->created_at->format('F d, Y') }}</span>
                </div>
            </div>

            <!-- Body -->
            <div class="card-body">
                <!-- Post Content -->
                <div class="mb-5 fs-5 lh-base" style="white-space: pre-wrap;">
                    {!! e($post->content) !!}
                </div>

                <!-- Likes Section -->
                <div class="d-flex align-items-center mb-4 p-3 bg-light rounded">
                    <i class="bi bi-heart-fill text-danger me-2 fs-5"></i>
                    <span class="fw-bold me-3">{{ $post->likes->count() }} Likes</span>
                    <button type="button" class="btn btn-sm btn-outline-primary rounded-pill" data-bs-toggle="modal"
                        data-bs-target="#likesModal">
                        <i class="bi bi-people-fill me-1"></i> View All
                    </button>
                </div>

                <!-- Likes Modal -->
                <div class="modal fade" id="likesModal" tabindex="-1" aria-labelledby="likesModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                        <div class="modal-content rounded-4">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title" id="likesModalLabel"><i class="bi bi-heart-fill me-2"></i>People
                                    who liked this post</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-0">
                                @if($post->likes->count())
                                <ul class="list-group list-group-flush">
                                    @foreach($post->likes as $like)
                                    <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary bg-opacity-10 p-2 rounded-circle me-3">
                                                <i class="bi bi-person-circle text-primary fs-4"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0">{{ $like->user->name }}</h6>
                                                <small class="text-muted">Liked
                                                    {{ $like->created_at->diffForHumans() }}</small>
                                            </div>
                                        </div>
                                        <form action="{{ route('likes.destroy', $like->id) }}" method="POST"
                                            onsubmit="return confirm('Remove your like from this post?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger rounded-circle" type="submit">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </form>
                                    </li>
                                    @endforeach
                                </ul>
                                @else
                                <div class="text-center py-4">
                                    <i class="bi bi-emoji-frown fs-1 text-muted"></i>
                                    <p class="text-muted mt-2">No likes yet. Be the first to like this post!</p>
                                </div>
                                @endif
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary rounded-pill"
                                    data-bs-dismiss="modal">
                                    <i class="bi bi-x-lg me-1"></i> Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Comments Section -->
                <div class="mt-5">
                    <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
                        <h4 class="mb-0">
                            <i class="bi bi-chat-square-text-fill text-info me-2"></i>
                            Comments <span class="badge bg-info rounded-pill">{{ $post->comments->count() }}</span>
                        </h4>
                    </div>

                    @if($post->comments->count())
                    <div class="list-group">
                        @foreach($post->comments as $comment)
                        <div class="list-group-item list-group-item-action mb-3 rounded-3 shadow-sm">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="bg-info bg-opacity-10 p-2 rounded-circle me-3">
                                        <i class="bi bi-person-circle text-info"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 text-primary">{{ $comment->user->name }}</h6>
                                        <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                                <form action="{{ route('admin.comments.destroy', $comment->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this comment?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </div>
                            <div class="ms-5 ps-3 mt-2">
                                <p class="mb-0">{{ $comment->content }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-4 bg-light rounded-3">
                        <i class="bi bi-chat-square-text fs-1 text-muted"></i>
                        <p class="text-muted mt-2">No comments yet. Be the first to share your thoughts!</p>
                    </div>
                    @endif
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <!-- Back Button on the Left -->
                    <a href="{{ route('users.show', $post->user->id) }}" class="btn btn-outline-secondary rounded-pill">
                        <i class="bi bi-arrow-left-circle me-2"></i> Back to Author Profile
                    </a>


                    <!-- Share & Save Buttons on the Right -->
                    <div class="d-flex align-items-center gap-3">
                        <!-- Share Button -->
                        <button class="btn btn-outline-success rounded-pill"
                            onclick="sharePost('{{ route('posts.show', $post->id) }}')">
                            <i class="bi bi-share-fill me-2"></i> Share
                        </button>

                        <!-- Save Button -->
                        <form action="{{ route('posts.toggleSave', $post->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-warning rounded-pill">
                                <i
                                    class="bi {{ auth()->user()->savedPosts->contains($post->id) ? 'bi-bookmark-fill' : 'bi-bookmark' }} me-2"></i>
                                {{ auth()->user()->savedPosts->contains($post->id) ? 'Saved' : 'Save' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>