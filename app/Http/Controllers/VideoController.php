<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;

use modulevideosecurity\managevideo\Models\TvsMapItem;

use modulevideosecurity\managevideo\Models\TvsSecret;

class VideoController extends Controller

{

    public function loadVideo($request, $route, $link)

    {

        header('Access-Control-Allow-Origin: '.asset('/'));

        header("X-Frame-Options: SAMEORIGIN");

        $ref = $request->server('HTTP_REFERER', '');

        if (strpos($ref, $request->getHttpHost()) === FALSE) {

           abort(403);

        }

        $tvsMapItemId = (int)$request->tvsMapItemId;
        $poster = $request->input('poster');

        $tvsMapItem = TvsMapItem::find($tvsMapItemId);

        if ($tvsMapItem == null) {

            return;

        }

        $secretId = 0;

        $secret = TvsSecret::where('media_id', $tvsMapItem->video_media_map_id)->where('converted', 2)->first();

        if ($secret != null) {

            $secretId = $secret->id;

        }
        if (\Auth::check()) {

            event('course.watched.video', compact('tvsMapItem'));

        }

        return view('iframe_video', compact('tvsMapItem', 'secretId','poster'));

    }

}