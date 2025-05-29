@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-primary fw-bold">Manage Users</h2>

    <div class="row g-4">
        @foreach($users as $user)
        <div class="col-md-4">
            <div class="card text-white rounded-4 shadow-lg h-100 overflow-hidden"
                style="background: linear-gradient(135deg, #667eea, #764ba2); transition: transform 0.3s ease, box-shadow 0.3s ease;">
                
                <div class="position-relative overflow-hidden" style="height: 220px;">
                    <img 
                        src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : 'https://via.placeholder.com/400x220?text=No+Photo' }}" 
                        class="w-100 h-100 object-fit-cover" 
                        alt="Profile Photo"
                        style="object-fit: cover;"
                    >
                    <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 opacity-0 transition-opacity"
                         style="transition: opacity 0.3s ease;"></div>
                </div>

                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <h5 class="card-title mb-2 fw-semibold text-truncate" title="{{ $user->name }}">
                            {{ $user->name }}
                        </h5>
                        <p class="card-text mb-3 text-truncate" title="{{ $user->email }}">
                            {{ $user->email }}
                        </p>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-sm btn-light fw-semibold shadow-sm">
                            <i class="bi bi-person-lines-fill me-1"></i> View User
                        </a>

                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-light fw-semibold shadow-sm">
                                <i class="bi bi-trash-fill me-1"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <style>
                /* Hover effect on card */
                .card:hover {
                    transform: translateY(-8px);
                    box-shadow: 0 12px 24px rgba(0,0,0,0.3);
                }
                /* Overlay fade in on image hover */
                .card:hover .position-relative > .position-absolute {
                    opacity: 1 !important;
                }
            </style>
        </div>
        @endforeach
    </div>
</div>
@endsection
