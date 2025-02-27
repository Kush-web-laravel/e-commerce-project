<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class InstagramController extends Controller
{
    //
    public function showData()
    {
        // Your Instagram Business Account ID
        $instagramAccountId = '17841472641049018'; // Replace with your actual ID
        
        // Your Access Token
        $accessToken = 'EAANduOgtv9MBO6sfSgmLNe5ZALUJQC8Ve8ncgI7LuriLwBZChgZAtQwTpK0QDrwgcGs30hXFk2QhXhgDzpjgrmx1lHrMtgA9FtKUtbUPXfEdGRA28v8hbiCG8iZBKdISAKebqZBEkQ2lMD8e5UFaBoJriNnfICxHccklRygZA77HWVcBPxm9sjt9ArYugtzQ0ddZCd1hJmaxE0PgatfzQZDZD'; // Replace with your actual token

        // Fetch media details
        $mediaResponse = Http::get("https://graph.facebook.com/v22.0/$instagramAccountId/media", [
            'fields' => 'id,caption,media_type,media_url',
            'access_token' => $accessToken,
        ]);
        
        $mediaData = $mediaResponse->json();
        

        // Pass data to the view
        return view('instagram', compact('mediaData'));
    }
}
