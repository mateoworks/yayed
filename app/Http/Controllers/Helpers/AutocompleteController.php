<?php

namespace App\Http\Controllers\Helpers;

use App\Http\Controllers\Controller;
use App\Models\Endorsement;
use Illuminate\Http\Request;

class AutocompleteController extends Controller
{
    public function endorsements(Request $request)
    {
        $termino = $request->search;
        $endorsements = Endorsement::where("names", 'LIKE', "%$termino%")
            ->orWhere('surnames', 'LIKE', "%$termino%")
            ->get();

        $response = array();

        foreach ($endorsements as $endorsement) {
            $response[] = array(
                "value" => $endorsement->full_name,
                "label" => $endorsement->id,
                "phone" => $endorsement->phone,
            );
        }
        return response()->json($response);
    }
}
