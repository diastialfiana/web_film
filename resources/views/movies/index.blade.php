@extends('layouts.app')

@section('styles')
<style>
    .hero-video-container {
        position: relative;
        height: 500px;
        width: 100%;
        overflow: hidden;
        border-radius: 16px;
        margin-bottom: 3rem;
        box-shadow: 0 20px 50px rgba(0,0,0,0.6);
    }
    .hero-video {
        position: absolute;
        top: 50%;
        left: 50%;
        min-width: 100%;
        min-height: 100%;
        width: auto;
        height: auto;
        transform: translate(-50%, -50%);
        object-fit: cover;
    }
    .hero-overlay {
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: linear-gradient(0deg, rgba(10,10,10,1) 0%, rgba(10,10,10,0.4) 50%, rgba(10,10,10,0.2) 100%);
        z-index: 1;
    }
    .hero-text {
        position: absolute;
        bottom: 50px;
        left: 50px;
        z-index: 2;
        max-width: 600px;
    }
</style>
@endsection

@section('content')
<!-- Video Hero Section -->
<div class="hero-video-container">
    <video autoplay muted loop playsinline class="hero-video">
        <source src="./jumbo.mp4" type="video/mp4">
        <source src="/TechnicalTest/public/jumbo.mp4" type="video/mp4">
        <source src="{{ asset('jumbo.mp4') }}" type="video/mp4">
    </video>
    <div class="hero-overlay"></div>
    <div class="hero-text">
        <span class="badge badge-danger mb-2 px-3 py-2 text-uppercase letter-spacing-1">Featured Teaser</span>
        <h1 class="display-3 font-weight-bold text-white mb-2">JUMBO</h1>
        <p class="lead text-white-50 mb-4">
            {{ app()->getLocale() == 'id' 
                ? 'JUMBO menceritakan kisah petualangan luar biasa seekor gajah mungil yang memiliki mimpi besar untuk menjelajahi dunia. Ikuti perjalanannya yang penuh tawa dan haru.' 
                : 'JUMBO tells the extraordinary story of a tiny elephant with big dreams to explore the world. Follow his journey full of laughter and heart.' }}
        </p>
        <div class="d-flex align-items-center flex-wrap">
            <div class="dropdown mr-3 mb-2">
                <button class="btn btn-primary btn-lg px-4 py-3 font-weight-bold shadow-lg dropdown-toggle" type="button" data-toggle="dropdown">
                    <i class="fas fa-play-circle mr-2"></i> {{ __('app.movie.watch_teaser') }}
                </button>
                <div class="dropdown-menu dropdown-menu-dark bg-darker border-secondary shadow-lg">
                    <a class="dropdown-item text-white py-2" href="{{ route('movies.show', 'tt0033563') }}">
                        <i class="fas fa-elephant mr-2 text-danger"></i> JUMBO
                    </a>
                    <a class="dropdown-item text-white py-2" href="{{ route('movies.show', 'tt9990001') }}">
                        <i class="fas fa-laugh mr-2 text-warning"></i> Warkop DKI
                    </a>
                </div>
            </div>
            
            <button class="btn btn-outline-light btn-lg px-4 py-3 font-weight-bold shadow-lg mr-3 mb-2" onclick="document.querySelector('.search-section').scrollIntoView({behavior: 'smooth'})">
                <i class="fas fa-search mr-2"></i> {{ __('app.search.button') }}
            </button>
        </div>
    </div>
</div>

<div class="row mb-5 search-section">
    <div class="col-md-12">
        <div class="glass-card mb-4" style="background: rgba(255,255,255,0.03); border: 1px solid var(--glass-border); border-radius: 12px; padding: 2rem;">
            <h5 class="text-white font-weight-bold mb-4"><i class="fas fa-filter mr-2 text-danger"></i> {{ __('app.search.title') }}</h5>
            <form id="search-form" class="row align-items-end" action="{{ route('movies.index') }}" method="GET">
                <div class="col-lg-5 col-md-12 mb-3 mb-lg-0">
                    <label class="text-white small font-weight-bold mb-2">{{ __('app.search.title') }}</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-transparent border-secondary text-muted border-right-0">
                                <i class="fas fa-search"></i>
                            </span>
                        </div>
                        <input type="text" name="s" id="search-input" class="form-control bg-dark text-white border-secondary border-left-0" value="{{ $query }}" placeholder="{{ __('app.search.placeholder') }}">
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-3 mb-lg-0">
                    <label class="text-white small font-weight-bold mb-2">{{ __('app.search.type') }}</label>
                    <select name="type" id="type-select" class="form-control bg-dark text-white border-secondary">
                        <option value="">All Types</option>
                        <option value="movie" {{ $type == 'movie' ? 'selected' : '' }}>Movie</option>
                        <option value="series" {{ $type == 'series' ? 'selected' : '' }}>Series</option>
                        <option value="episode" {{ $type == 'episode' ? 'selected' : '' }}>Episode</option>
                    </select>
                </div>

                <div class="col-lg-2 col-md-6 mb-3 mb-lg-0">
                    <label class="text-white small font-weight-bold mb-2">{{ __('app.search.year') }}</label>
                    <input type="number" name="y" id="year-input" class="form-control bg-dark text-white border-secondary" value="{{ $year }}" placeholder="Year">
                </div>

                <div class="col-lg-2 col-md-12">
                    <button type="submit" class="btn btn-primary btn-block">
                        {{ __('app.search.button') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="movie-list" class="row gx-4 gy-4">
    @forelse($movies as $movie)
        <div class="col-6 col-md-4 col-lg-3 mb-4">
            <a href="{{ route('movies.show', $movie['imdbID']) }}" class="movie-card position-relative d-block text-decoration-none">
                <img src="{{ $movie['Poster'] != 'N/A' ? $movie['Poster'] : 'https://via.placeholder.com/600x900/141414/ffffff?text=No+Image' }}" 
                     class="movie-poster img-fluid" 
                     alt="{{ $movie['Title'] }}"
                     loading="lazy">
                
                <div class="card-img-overlay">
                    <h6 class="text-white font-weight-bold text-truncate mb-1" title="{{ $movie['Title'] }}">{{ $movie['Title'] }}</h6>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="small text-white-50">{{ $movie['Year'] }}</span>
                        <span class="badge badge-light py-1 px-2 small">{{ ucfirst($movie['Type']) }}</span>
                    </div>
                    <button class="btn btn-sm btn-icon-only position-absolute p-0 border-0 bg-transparent text-danger shadow-none" 
                            style="top: 10px; right: 10px; font-size: 1.2rem; transition: transform 0.2s;"
                            data-id="{{ $movie['imdbID'] }}" 
                            data-title="{{ $movie['Title'] }}" 
                            data-year="{{ $movie['Year'] }}" 
                            data-poster="{{ $movie['Poster'] }}" 
                            data-type="{{ $movie['Type'] }}"
                            onclick="event.preventDefault(); event.stopPropagation(); toggleFavorite(this)">
                        <i class="fa{{ in_array($movie['imdbID'], $favorites) ? 's' : 'r' }} fa-heart"></i>
                    </button>
                </div>
            </a>
        </div>
    @empty
        <div class="col-12 text-center py-5">
            <div class="glass-card d-inline-block px-5 py-5" style="background: var(--bg-dark); max-width: 500px;">
                <i class="fas fa-search fa-4x text-muted mb-4"></i>
                <h3 class="text-white">{{ __('app.search.no_results') }}</h3>
                <p class="text-muted">{{ __('app.search.no_results_desc') }}</p>
                <button onclick="document.getElementById('search-input').value = 'Batman'; document.getElementById('search-form').submit();" class="btn btn-outline-danger mt-3">{{ __('app.search.try_batman') }}</button>
            </div>
        </div>
    @endforelse
</div>

<div id="loading" class="text-center py-5" style="display: none;">
    <div class="spinner-grow text-danger" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div>

<div id="sentinel" style="height: 50px;"></div>

@endsection

@section('scripts')
<script>
    let page = 1;
    let loading = false;
    let hasMore = {{ count($movies) >= 10 ? 'true' : 'false' }};
    const movieList = document.getElementById('movie-list');
    const loadingEl = document.getElementById('loading');
    const searchForm = document.getElementById('search-form');

    // Intersection Observer for Infinite Scroll
    const observer = new IntersectionObserver((entries) => {
        if (entries[0].isIntersecting && !loading && hasMore) {
            loadMore();
        }
    }, { rootMargin: '200px' });

    observer.observe(document.getElementById('sentinel'));

    function loadMore() {
        if (loading || !hasMore) return;
        
        loading = true;
        loadingEl.style.display = 'block';
        page++;

        const params = new URLSearchParams(new FormData(searchForm));
        params.append('page', page);

        fetch(`{{ route('movies.search') }}?${params.toString()}`, {
            headers: { 'Accept': 'application/json' }
        })
        .then(res => res.json())
        .then(data => {
            loading = false;
            loadingEl.style.display = 'none';

            if (data.Response === 'True' && data.Search) {
                data.Search.forEach(movie => {
                    const isFav = movie.is_favorite;
                    const poster = movie.Poster !== 'N/A' ? movie.Poster : 'https://via.placeholder.com/600x900/141414/ffffff?text=No+Image';
                    const movieHtml = `
                        <div class="col-6 col-md-4 col-lg-3 mb-4">
                            <a href="{{ url('/movies') }}/${movie.imdbID}" class="movie-card position-relative d-block text-decoration-none">
                                <img src="${poster}" class="movie-poster img-fluid" alt="${movie.Title}" loading="lazy">
                                <div class="card-img-overlay">
                                    <h6 class="text-white font-weight-bold text-truncate mb-1" title="${movie.Title}">${movie.Title}</h6>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="small text-white-50">${movie.Year}</span>
                                        <span class="badge badge-light py-1 px-2 small">${movie.Type.charAt(0).toUpperCase() + movie.Type.slice(1)}</span>
                                    </div>
                                    <button class="btn btn-sm btn-icon-only position-absolute p-0 border-0 bg-transparent text-danger shadow-none" 
                                            style="top: 10px; right: 10px; font-size: 1.2rem;"
                                            data-id="${movie.imdbID}" data-title="${movie.Title}" data-year="${movie.Year}" data-poster="${movie.Poster}" data-type="${movie.Type}"
                                            onclick="event.preventDefault(); event.stopPropagation(); toggleFavorite(this)">
                                        <i class="fa${isFav ? 's' : 'r'} fa-heart"></i>
                                    </button>
                                </div>
                            </a>
                        </div>
                    `;
                    movieList.insertAdjacentHTML('beforeend', movieHtml);
                });
                if (data.Search.length < 10) hasMore = false;
            } else {
                hasMore = false;
            }
        })
        .catch(() => {
            loading = false;
            loadingEl.style.display = 'none';
        });
    }

    function toggleFavorite(btn) {
        const icon = btn.querySelector('i');
        const isFavorited = icon.classList.contains('fas');
        const imdbId = btn.dataset.id;
        
        btn.style.transform = 'scale(1.3)';
        setTimeout(() => btn.style.transform = 'scale(1)', 200);

        if (isFavorited) {
            fetch(`{{ url('/favorites') }}/${imdbId}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    icon.classList.replace('fas', 'far');
                }
            });
        } else {
            fetch(`{{ route('favorites.store') }}`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json', 'Accept': 'application/json' },
                body: JSON.stringify({
                    imdb_id: imdbId,
                    title: btn.dataset.title,
                    year: btn.dataset.year,
                    poster: btn.dataset.poster,
                    type: btn.dataset.type
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    icon.classList.replace('far', 'fas');
                }
            });
        }
    }

    // Native form submission handles the redirect now
</script>
@endsection
