@extends('layouts.app')

@section('content')
<div class="row mb-5">
    <div class="col-md-12">
        <h2 class="text-white font-weight-bold mb-2">{{ __('app.favorites.title') }}</h2>
        <p class="text-muted">{{ __('app.favorites.subtitle') }}</p>
    </div>
</div>

<div id="favorite-list" class="row gx-4 gy-4">
    @forelse($favorites as $favorite)
        <div class="col-6 col-md-4 col-lg-3 mb-4 favorite-item" id="fav-container-{{ $favorite->imdb_id }}">
            <a href="{{ route('movies.show', $favorite->imdb_id) }}" class="movie-card position-relative d-block text-decoration-none">
                <img src="{{ $favorite->poster != 'N/A' ? $favorite->poster : 'https://via.placeholder.com/600x900/141414/ffffff?text=No+Image' }}" 
                     class="movie-poster img-fluid" 
                     alt="{{ $favorite->title }}"
                     loading="lazy">
                
                <div class="card-img-overlay">
                    <h6 class="text-white font-weight-bold text-truncate mb-1" title="{{ $favorite->title }}">{{ $favorite->title }}</h6>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="small text-white-50">{{ $favorite->year }}</span>
                        <span class="badge badge-light py-1 px-2 small">{{ ucfirst($favorite->type) }}</span>
                    </div>
                    <button class="btn btn-sm btn-icon-only position-absolute p-0 border-0 bg-transparent text-danger shadow-none" 
                            style="top: 10px; right: 10px; font-size: 1.2rem; transition: transform 0.2s;"
                            onclick="event.preventDefault(); event.stopPropagation(); removeFavorite({{ $favorite->id }}, '{{ $favorite->imdb_id }}')">
                        <i class="fas fa-heart"></i>
                    </button>
                </div>
            </a>
        </div>
    @empty
        <div class="col-12 text-center py-5">
            <div class="glass-card d-inline-block px-5 py-5" style="background: var(--bg-dark); max-width: 500px;">
                <i class="fas fa-heart-broken fa-4x text-muted mb-4"></i>
                <h3 class="text-white">{{ __('app.favorites.empty') }}</h3>
                <a href="{{ route('movies.index') }}" class="btn btn-primary mt-3">{{ __('app.favorites.browse') }}</a>
            </div>
        </div>
    @endforelse
</div>

@endsection

@section('scripts')
<script>
    function removeFavorite(id, imdbId) {
        if (!confirm('{{ __('app.favorites.confirm_remove') }}')) return;

        const btn = event.currentTarget;
        btn.disabled = true;

        fetch(`{{ url('/favorites') }}/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-HTTP-Method-Override': 'DELETE',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const item = document.getElementById(`fav-container-${imdbId}`);
                if (item) {
                    item.style.transform = 'scale(0)';
                    item.style.opacity = '0';
                    item.style.transition = 'all 0.3s ease';
                    setTimeout(() => {
                        item.remove();
                        if (document.querySelectorAll('.favorite-item').length === 0) {
                            location.reload();
                        }
                    }, 300);
                }
            } else {
                btn.disabled = false;
                alert('Failed to remove favorite.');
            }
        })
        .catch(() => {
            btn.disabled = false;
            alert('Error removing favorite.');
        });
    }
</script>
@endsection
