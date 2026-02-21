<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Favorite;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Display a listing of favorite movies.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $favorites = Auth::user()->favorites()->orderBy('created_at', 'desc')->get();

        return view('favorites.index', [
            'favorites' => $favorites
        ]);
    }

    /**
     * Store a new favorite movie.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'imdb_id' => 'required',
            'title' => 'required',
            'year' => 'required',
        ]);

        $favorite = Auth::user()->favorites()->firstOrCreate(
            ['imdb_id' => $request->imdb_id],
            [
                'title' => $request->title,
                'year' => $request->year,
                'poster' => $request->poster,
                'type' => $request->type ?? 'movie',
            ]
        );

        return response()->json(['success' => true, 'favorite' => $favorite]);
    }

    /**
     * Remove the specified favorite movie.
     *
     * @param  string  $imdbId
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        // Try deleting by database ID first, then fallback to imdb_id
        $query = Auth::user()->favorites();
        
        if (is_numeric($id)) {
            $query->where('id', $id);
        } else {
            $query->where('imdb_id', $id);
        }
        
        $query->delete();

        return response()->json(['success' => true]);
    }
}
