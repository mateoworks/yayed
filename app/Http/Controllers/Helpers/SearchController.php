<?php

namespace App\Http\Controllers\Helpers;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $term = $request->search;
        $parters = Partner::where(DB::raw("CONCAT(names, ' ', surname_father, ' ', surname_mother)"), 'LIKE', "%" . $term . "%")
            ->paginate();
        return view('other.search', [
            'term' => $term,
            'partners' => $parters,
        ]);
    }
}
