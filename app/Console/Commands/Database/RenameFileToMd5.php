<?php

namespace App\Console\Commands\Database;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class RenameFileToMd5 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'files:md5';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $media = Media::query()
                      ->where('file_name', 'ilike', '%ö%')
                      ->orWhere('file_name', 'ilike', '%ä%')
                      ->orWhere('file_name', 'ilike', '%ü%')
                      ->orWhere('file_name', 'ilike', '%ß%')
                      ->get();
        foreach ($media as $item) {
            $md5FileName = md5($item->file_name).'.'.$item->extension;
            $item->file_name = $md5FileName;
            Storage::disk('public')
                   ->move($item->getPath(), dirname($item->getPath()).'/'.$md5FileName);
            $item->save();
        }

        return Command::SUCCESS;
    }
}
