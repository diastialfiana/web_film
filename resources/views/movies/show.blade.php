@extends('layouts.app')

@section('styles')
<style>
    .movie-hero {
        position: relative;
        padding: 4rem 0;
        background-size: cover;
        background-position: center;
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 3rem;
    }
    .movie-hero::before {
        content: "";
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: linear-gradient(90deg, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0.4) 100%);
        z-index: 1;
    }
    .hero-content {
        position: relative;
        z-index: 2;
    }
    .hero-poster {
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.8);
        border: 1px solid rgba(255,255,255,0.1);
    }
    .rating-box {
        background: var(--glass);
        border: 1px solid var(--glass-border);
        border-radius: 8px;
        padding: 1rem;
        transition: transform 0.2s;
    }
    .rating-box:hover {
        transform: translateY(-5px);
        background: rgba(255,255,255,0.08);
    }
</style>
@endsection

@section('content')
<div class="mb-4">
    <a href="{{ route('movies.index') }}" class="btn btn-link text-white-50 p-0 shadow-none">
        <i class="fas fa-arrow-left mr-2"></i> {{ __('app.movie.back') }}
    </a>
</div>

<div class="movie-hero" style="background-image: url('{{ $movie['Poster'] != 'N/A' ? $movie['Poster'] : '' }}');">
    <div class="container hero-content">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-4 mb-4 mb-md-0">
                <img src="{{ $movie['Poster'] != 'N/A' ? $movie['Poster'] : 'https://via.placeholder.com/600x900/141414/ffffff?text=No+Image' }}" 
                     class="hero-poster img-fluid" 
                     alt="{{ $movie['Title'] }}">
            </div>
            <div class="col-lg-9 col-md-8">
                <div class="d-flex flex-wrap align-items-center mb-2">
                    <span class="badge badge-danger mr-2 px-3 py-2">{{ $movie['Year'] }}</span>
                    <span class="text-white-50 mr-3">{{ $movie['Rated'] }} • {{ $movie['Runtime'] }}</span>
                    <span class="text-white-50">{{ $movie['Genre'] }}</span>
                </div>
                <h1 class="display-4 font-weight-bold text-white mb-3">{{ $movie['Title'] }}</h1>
                
                <div class="d-flex mb-4">
                    <button id="detail-fav-btn" class="btn btn-lg {{ $isFavorite ? 'btn-danger' : 'btn-outline-light' }} px-4 shadow-lg font-weight-bold" 
                            data-id="{{ $movie['imdbID'] }}" 
                            data-title="{{ $movie['Title'] }}" 
                            data-year="{{ $movie['Year'] }}" 
                            data-poster="{{ $movie['Poster'] }}" 
                            data-type="{{ $movie['Type'] }}"
                            onclick="toggleFavorite(this)">
                        <i class="fa{{ $isFavorite ? 's' : 'r' }} fa-heart mr-2"></i>
                        <span>{{ $isFavorite ? __('app.movie.remove_favorite') : __('app.movie.add_favorite') }}</span>
                    </button>
                </div>

                <div class="row">
                    <div class="col-12">
                        <h6 class="text-danger font-weight-bold text-uppercase small letter-spacing-1">{{ __('app.movie.overview') }}</h6>
                        <p class="lead text-white-50" style="max-width: 800px;">{{ $movie['Plot'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row pb-5">
    <div class="col-lg-8">
        @if(isset($movie['Teaser']) && $movie['Teaser'])
        <div class="glass-card p-0 mb-4 overflow-hidden">
            <div class="bg-darker px-4 py-3 border-bottom border-secondary">
                <h5 class="text-white font-weight-bold m-0"><i class="fas fa-play-circle text-danger mr-2"></i> {{ $movie['Title'] }} - {{ __('app.movie.watch_teaser') }}</h5>
            </div>
            <div class="embed-responsive embed-responsive-16by9 bg-black">
                <video class="embed-responsive-item" controls preload="metadata">
                    <source src="{{ $movie['Teaser'] }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
            <div class="p-3 text-center border-top border-secondary bg-darker">
                <small class="text-muted">Direct Link: <a href="{{ $movie['Teaser'] }}" target="_blank" class="text-danger">Open Original Video File</a></small>
            </div>
        </div>
        @endif

        <div class="glass-card p-4 mb-4">
            <h5 class="text-white font-weight-bold mb-4">{{ __('app.movie.detail') }}</h5>
            <div class="row">
                <div class="col-6 mb-4">
                    <small class="text-muted d-block text-uppercase mb-1">{{ __('app.movie.director') }}</small>
                    <span class="text-white">{{ $movie['Director'] }}</span>
                </div>
                <div class="col-6 mb-4">
                    <small class="text-muted d-block text-uppercase mb-1">{{ __('app.movie.writer') }}</small>
                    <span class="text-white">{{ $movie['Writer'] }}</span>
                </div>
                <div class="col-6 mb-4">
                    <small class="text-muted d-block text-uppercase mb-1">{{ __('app.movie.cast') }}</small>
                    <span class="text-white">{{ $movie['Actors'] }}</span>
                </div>
                <div class="col-6 mb-4">
                    <small class="text-muted d-block text-uppercase mb-1">{{ __('app.movie.released') }}</small>
                    <span class="text-white">{{ $movie['Released'] }}</span>
                </div>
                <div class="col-6 mb-4">
                    <small class="text-muted d-block text-uppercase mb-1">{{ __('app.movie.language') }}</small>
                    <span class="text-white">{{ $movie['Language'] }}</span>
                </div>
                <div class="col-6 mb-4">
                    <small class="text-muted d-block text-uppercase mb-1">{{ __('app.movie.production') }}</small>
                    <span class="text-white">{{ $movie['Production'] ?? 'N/A' }}</span>
                </div>
                <div class="col-6 mb-4">
                    <small class="text-muted d-block text-uppercase mb-1">{{ __('app.movie.awards') }}</small>
                    <span class="text-white">{{ $movie['Awards'] }}</span>
                </div>
                <div class="col-6 mb-4">
                    <small class="text-muted d-block text-uppercase mb-1">{{ __('app.movie.country') }}</small>
                    <span class="text-white">{{ $movie['Country'] }}</span>
                </div>
                <div class="col-6 mb-4">
                    <small class="text-muted d-block text-uppercase mb-1">{{ __('app.movie.box_office') }}</small>
                    <span class="text-white">{{ $movie['BoxOffice'] ?? 'N/A' }}</span>
                </div>
                <div class="col-6 mb-4">
                    <small class="text-muted d-block text-uppercase mb-1">{{ __('app.movie.dvd') }}</small>
                    <span class="text-white">{{ $movie['DVD'] ?? 'N/A' }}</span>
                </div>
                <div class="col-6 mb-4">
                    <small class="text-muted d-block text-uppercase mb-1">{{ __('app.movie.website') }}</small>
                    @if(isset($movie['Website']) && $movie['Website'] != 'N/A')
                        <a href="{{ $movie['Website'] }}" target="_blank" class="text-danger">{{ $movie['Website'] }}</a>
                    @else
                        <span class="text-white">N/A</span>
                    @endif
                </div>
                @if(isset($movie['totalSeasons']))
                <div class="col-6 mb-4">
                    <small class="text-muted d-block text-uppercase mb-1">{{ __('app.movie.seasons') }}</small>
                    <span class="text-white">{{ $movie['totalSeasons'] }}</span>
                </div>
                @endif
                @if(isset($movie['Metascore']) && $movie['Metascore'] != 'N/A')
                <div class="col-6 mb-4">
                    <small class="text-muted d-block text-uppercase mb-1">Metascore</small>
                    <span class="badge badge-success px-2 py-1">{{ $movie['Metascore'] }}</span>
                </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="glass-card p-4">
            <h5 class="text-white font-weight-bold mb-4">{{ __('app.movie.ratings') }}</h5>
            @foreach($movie['Ratings'] as $rating)
                <div class="rating-box mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="small text-white-50 font-weight-bold">{{ $rating['Source'] }}</span>
                        <span class="text-danger font-weight-bold">{{ $rating['Value'] }}</span>
                    </div>
                    <div class="progress mt-2" style="height: 4px; background: rgba(255,255,255,0.05);">
                        @php
                            $val = 0;
                            if(strpos($rating['Value'], '/') !== false) {
                                $parts = explode('/', $rating['Value']);
                                $val = (floatval($parts[0]) / floatval($parts[1])) * 100;
                            } elseif(strpos($rating['Value'], '%') !== false) {
                                $val = floatval(str_replace('%', '', $rating['Value']));
                            }
                        @endphp
                        <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $val }}%"></div>
                    </div>
                </div>
            @endforeach
            
            <div class="text-center mt-4">
                <div class="h3 font-weight-bold text-white mb-0">{{ $movie['imdbRating'] }}</div>
                <small class="text-muted">IMDb Score ({{ $movie['imdbVotes'] }} votes)</small>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function toggleFavorite(btn) {
        // ... (existing code omitted for brevity but I will replace exactly what is there)
        const icon = btn.querySelector('i');
        const text = btn.querySelector('span');
        const isFavorited = icon.classList.contains('fas');
        const imdbId = btn.dataset.id;
        
        btn.disabled = true;

        if (isFavorited) {
            fetch(`{{ url('/favorites') }}/${imdbId}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
            })
            .then(res => res.json())
            .then(data => {
                btn.disabled = false;
                if (data.success) {
                    icon.classList.replace('fas', 'far');
                    btn.classList.replace('btn-danger', 'btn-outline-light');
                    text.innerText = "{{ __('app.movie.add_favorite') }}";
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
                btn.disabled = false;
                if (data.success) {
                    icon.classList.replace('far', 'fas');
                    btn.classList.replace('btn-outline-light', 'btn-danger');
                    text.innerText = "{{ __('app.movie.remove_favorite') }}";
                }
            });
        }
    }
</script>
@endsection
