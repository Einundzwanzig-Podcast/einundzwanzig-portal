<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use League\Glide\Responses\LaravelResponseFactory;
use League\Glide\ServerFactory;

class ImageController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke($path)
    {
        $filesystem = Storage::disk('public');

        $server = ServerFactory::create([
            'response'          => new LaravelResponseFactory(app('request')),
            'source'            => $filesystem->getDriver(),
            'cache'             => $filesystem->getDriver(),
            'cache_path_prefix' => '.cache',
            'base_url'          => 'img',
        ]);

        return $server->getImageResponse('/'. $path, request()->all());
    }
}
