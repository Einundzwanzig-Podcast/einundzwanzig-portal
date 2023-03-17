<?php

namespace App\Traits;

use App\Models\Tag;
use App\Rules\TagUniqueRule;

trait HasTagsTrait
{
    public array $tags = [];
    public array $selectedTags = [];

    public bool $addTag = false;
    public $newTag;

    public function mountHasTagsTrait()
    {
        $this->tags = Tag::query()
                         ->where('type', 'library_item')
                         ->get()
                         ->map(fn($tag) => ['id' => $tag->id, 'name' => $tag->name])
                         ->toArray();
    }

    public function selectTag($name)
    {
        $selectedTags = collect($this->selectedTags);
        if ($selectedTags->contains($name)) {
            $selectedTags = $selectedTags->filter(fn($tag) => $tag !== $name);
        } else {
            $selectedTags->push($name);
        }
        $this->selectedTags = $selectedTags->values()
                                           ->toArray();
    }

    public function addTag()
    {
        $this->validateOnly('newTag', [
            'newTag' => ['required', 'string', new TagUniqueRule()],
        ]);
        Tag::create(['name' => $this->newTag, 'type' => 'library_item']);
        $this->tags = Tag::query()
                         ->where('type', 'library_item')
                         ->get()
                         ->map(fn($tag) => ['id' => $tag->id, 'name' => $tag->name])
                         ->toArray();
        $this->newTag = '';
        $this->addTag = false;
    }
}
