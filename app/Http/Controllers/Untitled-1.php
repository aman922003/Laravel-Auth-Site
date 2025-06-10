<!-- review list -->
<div class="card shadow-sm">
    <div class="card-header bg-info text-white">
        <h5 class="mb-0">Customer Reviews ({{ $post->reviews->count() }})</h5>
    </div>

    <div class="card-body">
        @forelse ($post->reviews->sortByDesc('created_at') as $review)
        <div class="border-bottom pb-3 mb-3" id="review-{{ $review->id }}">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <strong>{{ $review->name ?? $review->user->name ?? 'Anonymous' }}</strong>
                    <small
                        class="text-muted ms-2">{{ $review->created_at->diffForHumans() }}</small>
                </div>
                <div class="stars">
                    @for ($i = 1; $i <= 5; $i++) <span
                        class="{{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}">
                        ★</span>
                        @endfor
                </div>
                @if(auth()->check() && (auth()->id() === $review->user_id ||
                auth()->user()->isAdmin()))
                <div>
                    <button class="btn btn-sm btn-outline-primary"
                        onclick="toggleEdit({{ $review->id }})">Edit</button>
                    <button class="btn btn-sm btn-outline-danger"
                        onclick="deleteReview({{ $review->id }})">Delete</button>
                </div>
                @endif
            </div>

            <!-- Display Mode -->
            <div id="display-review-{{ $review->id }}">
                <h6 class="mt-2">{{ $review->title }}</h6>
                <p class="mb-0 text-muted">{{ $review->body }}</p>
            </div>

            <!-- Edit Mode (hidden initially) -->
            <form id="edit-form-{{ $review->id }}" class="d-none"
                onsubmit="updateReview(event, {{ $review->id }})">
                @csrf
                @method('PUT')

                <input name="title" class="form-control mb-2"
                    value="{{ $review->title }}" required>

                <textarea name="body" class="form-control mb-2" rows="3"
                    required>{{ $review->body }}</textarea>

                <div class="mb-2">
                    @for ($i = 5; $i >= 1; $i--)
                    <input type="radio" id="rating-{{ $review->id }}-{{ $i }}"
                        name="rating" value="{{ $i }}"
                        {{ $review->rating == $i ? 'checked' : '' }} required
                        style="display:none;">
                    <label for="rating-{{ $review->id }}-{{ $i }}"
                        style="font-size:1.5rem; cursor:pointer; color: {{ $review->rating >= $i ? '#ffc107' : '#ddd' }};">★</label>
                    @endfor
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-sm btn-success">Save</button>
                    <button type="button" class="btn btn-sm btn-secondary"
                        onclick="toggleEdit({{ $review->id }}, true)">Cancel</button>
                </div>
            </form>
        </div>
        @empty
        <p class="text-muted mb-0">No reviews yet. Be the first to review!</p>
        @endforelse
    </div>
</div>

<script>
function toggleEdit(id, cancel = false) {
    const displayDiv = document.getElementById(`display-review-${id}`);
    const editForm = document.getElementById(`edit-form-${id}`);
    if (cancel) {
        editForm.classList.add('d-none');
        displayDiv.style.display = 'block';
    } else {
        editForm.classList.remove('d-none');
        displayDiv.style.display = 'none';
    }
}

function updateReview(e, id) {
    e.preventDefault();
    const form = e.target;
    const data = new FormData(form);

    fetch(`/reviews/${id}`, {
            method: 'PUT',
            headers: {
                'X-CSRF-TOKEN': form.querySelector('[name="_token"]').value,
                'Accept': 'application/json',
            },
            body: data,
        })
        .then(res => {
            if (!res.ok) throw new Error('Network response was not ok');
            return res.json();
        })
        .then(data => {
            document.querySelector(`#display-review-${id} h6`).innerText = data
                .title;
            document.querySelector(`#display-review-${id} p`).innerText = data.body;

            const starsContainer = document.querySelector(`#review-${id} .stars`);
            let starsHTML = '';
            for (let i = 1; i <= 5; i++) {
                starsHTML +=
                    `<span class="${i <= data.rating ? 'text-warning' : 'text-muted'}">★</span>`;
            }
            starsContainer.innerHTML = starsHTML;

            toggleEdit(id, true);
        })
        .catch(() => alert('Update failed.'));
}

function deleteReview(id) {
    if (!confirm('Are you sure?')) return;

    fetch(`/reviews/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                    .content,
                'Accept': 'application/json',
            },
        })
        .then(res => {
            if (res.ok) {
                document.getElementById(`review-${id}`).remove();
            } else {
                alert('Delete failed.');
            }
        })
        .catch(() => alert('Delete failed.'));
}
</script>