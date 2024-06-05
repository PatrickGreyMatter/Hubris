<?php

// app/Http/Controllers/SearchController.php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');
        $films = Media::where('title', 'LIKE', "%$query%")
                        ->orWhereHas('director', function($q) use ($query) {
                            $q->where('name', 'LIKE', "%$query%");
                        })
                        ->get();

        return view('search_results', compact('films', 'query'));
    }
}

