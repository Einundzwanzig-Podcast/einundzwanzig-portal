<?php

namespace App\Traits;

use App\Models\TwitterAccount;
use Illuminate\Support\Facades\Http;

trait TwitterTrait
{
    public function setNewAccessToken($accountId)
    {
        $twitterAccount = TwitterAccount::find($accountId);

        $response = Http::acceptJson()
                        ->post('https://api.twitter.com/2/oauth2/token', [
                            'grant_type' => 'refresh_token',
                            'refresh_token' => $twitterAccount->refresh_token,
                            'client_id' => 'a0I1Nnp4YmMzZzdtRzFod1ZWT2c6MTpjaQ',
                        ]);
        $json = $response->json();
        \Log::info($json);

        TwitterAccount::find($accountId)
                      ->update([
                          'token' => $json['access_token'],
                          'refresh_token' => $json['refresh_token'],
                      ]);
    }

    public function postTweet($text)
    {
        $twitterAccount = TwitterAccount::find(1);
        $response = Http::acceptJson()
                        ->withToken($twitterAccount->token)
                        ->post('https://api.twitter.com/2/tweets', [
                            'text' => $text,
                        ]);

        \Log::info($response->json());
    }
}
