<?php namespace AppTupir\Catchphrase\Http\Controllers;

use RainLab\User\Models\User;
use Illuminate\Routing\Controller;
use AppTupir\Catchphrase\Models\Catchphrase;
use Libuser\Userapi\Http\Resources\SimpleUserResource;
use AppTupir\Catchphrase\Http\Resources\CatchphraseResource;

class SearchController extends Controller
{
    public function show($search)
    {
        $creator = SimpleUserResource::collection(
            User::isCreator()
                ->where('name', 'like', '%' . $search . '%')
                ->orWhere('surname', 'like', '%' . $search . '%')
                ->orWhere('username', 'like', '%' . $search . '%')
                ->get()
        );

        $catchphrase = CatchphraseResource::collection(
            Catchphrase::isPublished()
                ->where('title', 'like', '%' . $search . '%')
                ->orWhere('lyrics', 'like', '%' . $search . '%')
                ->get()
        );

        if (count($creator) || count($catchphrase)) {
            return $creator->concat($catchphrase);
        }
        else {
            return response()->json(['error' => 'No creators or catchphrases found', 'statusCode' => 404], 404);
        }
    }
}
