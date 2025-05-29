@extends('layouts.app')

@section('title', 'User Details')

@section('content')
<div class="container py-5">
    <!-- Enhanced Profile Card with Hover Effects -->
    <div class="card shadow-lg border-primary rounded-4 mb-5 overflow-hidden hover-shadow-lg transition-all">
        <div class="row g-0 align-items-center bg-primary bg-opacity-10">
            <div class="col-md-4 p-4">
                <div class="ratio ratio-1x1 rounded-3 overflow-hidden shadow-sm">
                    <img src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : 'https://via.placeholder.com/300x300?text=No+Photo' }}"
                        class="img-fluid object-fit-cover hover-scale" alt="Profile Photo">
                </div>
            </div>
            <div class="col-md-8">
                <div class="card-body px-4 px-lg-5 py-4">
                    <h2 class="card-title fw-bold text-primary mb-3 display-5">
                        <i class="bi bi-person-badge-fill me-2"></i>{{ $user->name }}
                    </h2>
                    <div class="d-flex flex-column gap-3">
                        <!-- Email Card -->
                        <div class="d-flex align-items-center bg-dark p-3 rounded-3 shadow hover-bg-darken">
                            <div
                                class="bg-warning bg-opacity-50 p-3 rounded-circle me-3 d-flex justify-content-center align-items-center">
                                <i class="bi bi-envelope-fill text-dark fs-4"></i>
                            </div>
                            <div>
                                <p class="mb-1 text-light opacity-75">EMAIL</p>
                                <p class="mb-0 fw-bold fs-5 text-white">{{ $user->email }}</p>
                            </div>
                        </div>

                        <!-- Join Date Card -->
                        <div class="d-flex align-items-center bg-dark p-3 rounded-3 shadow hover-bg-darken">
                            <div
                                class="bg-warning bg-opacity-50 p-3 rounded-circle me-3 d-flex justify-content-center align-items-center">
                                <i class="bi bi-calendar-check-fill text-dark fs-4"></i>
                            </div>
                            <div>
                                <p class="mb-1 text-light opacity-75">JOINED DATE</p>
                                <p class="mb-0 fw-bold fs-5 text-white">{{ $user->created_at->format('F d, Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Posts Section -->
    <div class="mb-4">



        <h4 class="d-flex align-items-center mb-4">
            <!-- Icon Container with Enhanced Styling -->
            <span class="bg-info bg-opacity-25 p-3 rounded-3 shadow-sm me-3">
                <i class="bi bi-file-post-fill text-info fs-2"></i>
            </span>

            <!-- Text Container with Box Design -->
            <div class="d-flex align-items-center bg-light p-3 rounded-3 shadow-sm position-relative"
                style="min-width: 200px;">
                <!-- Decorative Left Border -->
                <span class="bg-info position-absolute start-0 top-0 bottom-0 rounded-start" style="width: 5px;"></span>

                <div class="ps-3">
                    <span class="fw-bold text-dark fs-4">{{ $user->name }}'s Posts</span>
                    <span class="badge bg-info text-white rounded-pill ms-3 fs-6 py-2 px-3">
                        {{ $user->posts->count() }}
                    </span>
                </div>
            </div>
        </h4>
        @if($user->posts->count())
        <div class="table-responsive rounded-4 overflow-hidden shadow">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-info text-dark">
                    <tr>
                        <th style="width: 5%;" class="ps-4">#</th>
                        <th style="width: 25%;">Title</th>
                        <th>Content Preview</th>
                        <th style="width: 200px;" class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($user->posts as $post)
                    <tr class="border-top border-light hover-bg-light">
                        <td class="ps-4 fw-bold">{{ $loop->iteration }}</td>
                        <td class="fw-semibold text-primary">{{ $post->title }}</td>
                        <td>{{ Str::limit(strip_tags($post->content), 100) }}</td>
                        <td>
                            <div class="d-flex justify-content-end gap-3 pe-2">
                                <a href="{{ route('admin.posts.show', $post->id) }}"
                                    class="btn btn-warning btn-sm rounded-pill px-3 d-flex align-items-center hover-shadow-sm text-dark">
                                    <i class="bi bi-eye-fill me-2"></i> View
                                </a>
                                <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this post?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="btn btn-danger btn-sm rounded-pill px-3 d-flex align-items-center hover-shadow-sm">
                                        <i class="bi bi-trash-fill me-2"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="alert alert-warning d-flex align-items-center rounded-4 shadow-sm" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-3 fs-3"></i>
            <div>
                <h5 class="alert-heading mb-1">No Posts Found</h5>
                <p class="mb-0">This user hasn't created any posts yet.</p>
            </div>
        </div>
        @endif
    </div>

    <!-- Back Button -->
    <a href="{{ route('admin.dashboard') }}"
        class="btn btn-outline-primary mt-5 rounded-pill px-4 d-inline-flex align-items-center hover-shadow-sm">
        <i class="bi bi-arrow-left-circle-fill me-2 fs-5"></i>Back to Dashboard
    </a>
</div>
@endsection