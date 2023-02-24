<?php

namespace App\Traits;

use Illuminate\Support\Facades\Process;

trait NostrTrait
{
    public function publishOnNostr($model, $text): array
    {
        //noscl publish "Good morning!"
        $result = Process::timeout(60 * 5)
                         ->run('noscl publish "'.$text.'"');

        if ($result->successful()) {
            $model->nostr_status = $result->output();
            $model->save();
        }

        return [
            'success'     => $result->successful(),
            'output'      => $result->output(),
            'exitCode'    => $result->exitCode(),
            'errorOutput' => $result->errorOutput()
        ];
    }
}
