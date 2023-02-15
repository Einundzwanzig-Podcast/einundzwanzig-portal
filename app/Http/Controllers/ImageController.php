<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Filesystem\Filesystem;
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
    public function __invoke(Filesystem $filesystem, $path)
    {
        $server = ServerFactory::create([
            'response'          => new LaravelResponseFactory(app('request')),
            'source'            => $filesystem->getDriver(),
            'cache'             => $filesystem->getDriver(),
            'cache_path_prefix' => '.cache',
            'base_url'          => 'img',
        ]);

        return $server->getImageResponse('public/'.$path, request()->all());
    }
}
