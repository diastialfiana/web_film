<?php

namespace App\Http\Controllers;

use App\Services\OmdbService;
use Illuminate\Http\Request;
use App\Favorite;
use Illuminate\Support\Facades\Auth;

class MovieController extends Controller
{
    protected $omdbService;

    public function __construct(OmdbService $omdbService)
    {
        $this->omdbService = $omdbService;
    }

    /**
     * Display a listing of movies.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = $request->get('s', 'Batman'); // Default search
        $type = $request->get('type', '');
        $year = $request->get('y', '');
        
        $results = $this->omdbService->search($query, $type, $year, 1);
        $movies = $results['Search'] ?? [];
        
        $featured = [
            ['Title' => 'JUMBO', 'Year' => '2024', 'imdbID' => 'tt0033563', 'Type' => 'movie', 'Poster' => asset('jumbo_poster.jpg')],
            ['Title' => 'Warkop DKI', 'Year' => '1980', 'imdbID' => 'tt9990001', 'Type' => 'movie', 'Poster' => asset('warkop_poster.png')]
        ];

        // Only show featured if it's the initial landing OR if the query matches the title
        $isExplicitSearch = $request->has('s');
        foreach (array_reverse($featured) as $f) {
            if (!$isExplicitSearch || stripos($f['Title'], $query) !== false) {
                // Check if already in results (avoid duplicates if API also returns it)
                $exists = false;
                foreach ($movies as $m) {
                    if ($m['imdbID'] === $f['imdbID']) { $exists = true; break; }
                }
                if (!$exists) {
                    array_unshift($movies, $f);
                }
            }
        }

        $favorites = Auth::user()->favorites()->pluck('imdb_id')->toArray();

        return view('movies.index', [
            'movies' => $movies,
            'totalResults' => ($results['totalResults'] ?? 0) + count($featured),
            'favorites' => $favorites,
            'query' => $query,
            'type' => $type,
            'year' => $year
        ]);
    }

    /**
     * Search movies via AJAX for infinite scroll.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $query = $request->get('s');
        $type = $request->get('type', '');
        $year = $request->get('y', '');
        $page = $request->get('page', 1);

        $results = $this->omdbService->search($query, $type, $year, $page);
        $movies = $results['Search'] ?? [];
        
        if ($page == 1) {
            $featured = [
                ['Title' => 'JUMBO', 'Year' => '2024', 'imdbID' => 'tt0033563', 'Type' => 'movie', 'Poster' => asset('jumbo_poster.jpg')],
                ['Title' => 'Warkop DKI', 'Year' => '1980', 'imdbID' => 'tt9990001', 'Type' => 'movie', 'Poster' => asset('warkop_poster.png')]
            ];

            $isExplicitSearch = $request->has('s');
            foreach (array_reverse($featured) as $f) {
                if (!$isExplicitSearch || stripos($f['Title'], $query) !== false) {
                    $exists = false;
                    foreach ($movies as $m) {
                        if ($m['imdbID'] === $f['imdbID']) { $exists = true; break; }
                    }
                    if (!$exists) {
                        array_unshift($movies, $f);
                        $results['Response'] = 'True';
                    }
                }
            }
        }

        $favorites = Auth::user()->favorites()->pluck('imdb_id')->toArray();
        
        foreach ($movies as &$movie) {
            $movie['is_favorite'] = in_array($movie['imdbID'], $favorites);
        }
        $results['Search'] = $movies;

        return response()->json($results);
    }

    /**
     * Display movie detail.
     *
     * @param string $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        // Mock details to bypass API errors
        if ($id === 'tt0033563') {
            $movie = [
                'Title' => 'JUMBO',
                'Year' => '2024',
                'Rated' => 'G',
                'Released' => '21 Feb 2024',
                'Runtime' => '120 min',
                'Genre' => 'Animation, Adventure, Family',
                'Director' => 'Aldmic Studios',
                'Writer' => 'Technical Test Team',
                'Actors' => 'Jumbo the Elephant, Friends',
                'Plot' => 'JUMBO menceritakan kisah petualangan luar biasa seekor gajah mungil yang memiliki mimpi besar untuk menjelajahi dunia. Ikuti perjalanannya yang penuh tawa dan haru.',
                'Language' => 'Indonesian, English',
                'Country' => 'Indonesia',
                'Awards' => 'Best Teaser 2024',
                'Poster' => asset('jumbo_poster.jpg'),
                'Teaser' => asset('jumbo.mp4'),
                'Ratings' => [['Source' => 'Internal', 'Value' => '10/10']],
                'Metascore' => '100',
                'imdbRating' => '9.9',
                'imdbVotes' => '1,000,000',
                'imdbID' => 'tt0033563',
                'Type' => 'movie',
                'DVD' => 'N/A',
                'BoxOffice' => 'N/A',
                'Production' => 'Aldmic',
                'Website' => 'N/A',
                'Response' => 'True'
            ];
        } elseif ($id === 'tt9990001') {
            $movie = [
                'Title' => 'Warkop DKI',
                'Year' => '1980',
                'Rated' => 'R',
                'Released' => '01 Jan 1980',
                'Runtime' => '95 min',
                'Genre' => 'Comedy',
                'Director' => 'Nwi Abanyi',
                'Writer' => 'Warkop Team',
                'Actors' => 'Dono, Kasino, Indro',
                'Plot' => 'Petualangan lucu trio legendaris Dono, Kasino, Indro dalam menghadapi berbagai situasi konyol yang mengocok perut.',
                'Language' => 'Indonesian',
                'Country' => 'Indonesia',
                'Awards' => 'Legendary Comedy',
                'Poster' => asset('warkop_poster.png'),
                'Teaser' => asset('warkopdki.mp4'),
                'Ratings' => [['Source' => 'Internal', 'Value' => '10/10']],
                'Metascore' => '100',
                'imdbRating' => '9.5',
                'imdbVotes' => '2,000,000',
                'imdbID' => 'tt9990001',
                'Type' => 'movie',
                'DVD' => 'N/A',
                'BoxOffice' => 'N/A',
                'Production' => 'Parkit Film',
                'Website' => 'N/A',
                'Response' => 'True'
            ];
        } else {
            $movie = $this->omdbService->getById($id);
            // Default teaser for other movies if they don't have one (optional, but keep it empty)
            $movie['Teaser'] = null;
        }
        
        if (isset($movie['Response']) && $movie['Response'] === 'False') {
            return redirect()->route('movies.index')->with('error', $movie['Error']);
        }

        $isFavorite = Auth::user()->favorites()->where('imdb_id', $id)->exists();

        return view('movies.show', [
            'movie' => $movie,
            'isFavorite' => $isFavorite
        ]);
    }
}
