<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\Request;
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
    public function __invoke(Request $request, Filesystem $filesystem, $path)
    {
        $filesystemPublic = Storage::disk('publicDisk');

        $server = ServerFactory::create([
            'response'          => new LaravelResponseFactory(app('request')),
            'source'            => str($request->path())->contains('img-public') ? $filesystemPublic->getDriver() : $filesystem->getDriver(),
            'cache'             => $filesystem->getDriver(),
            'cache_path_prefix' => '.cache',
            'base_url'          => $request->route()
                                           ->getName() === 'imgPublic' ? '' : 'img',
        ]);

        return $server->getImageResponse($path, request()->all());
    }
}
