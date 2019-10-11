<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Photo;
use App\Place;

class PhotoController extends Controller
{
    public function uploadPhoto(Request $request)
    {
        $photo = new Photo();
        $place = Place::find($request->input('place'));

        if (!$place) {
            //add new place
            $place = new Place();
            $place->name = $request->input('place_name');
            $place->lat = $request->input('place_lat');
            $place->lng = $request->input('place_lng');
        }

        $place->visited = 1;
        $place->save();

        $photo->place()->associate($place);
        $photo->image = $request->image->store('photos', 'public');
        $photo->save();

        return redirect()->route('Main');
    }
}
