<?php

namespace App\Traits;

trait HasMapEmbedCodeTrait
{
    public string $mapEmbedCode = '';

    public function mountHasMapEmbedCodeTrait()
    {
        $this->mapEmbedCode = '<iframe src="'.url()->route('meetup.embed.countryMap',
                ['country' => $this->country->code]).'" width="100%" height="500" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>';
    }

}
