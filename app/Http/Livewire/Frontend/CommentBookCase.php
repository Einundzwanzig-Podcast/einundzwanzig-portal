<?php

namespace App\Http\Livewire\Frontend;

use App\Models\BookCase;
use Livewire\Component;

class CommentBookCase extends Component
{
    public string $c = 'de';

    public BookCase $bookCase;

    public function render()
    {
        return view('livewire.frontend.comment-book-case');
    }

    protected function url_to_absolute($url)
    {
        // Determine request protocol
        $request_protocol = $request_protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http');
        // If dealing with a Protocol Relative URL
        if (stripos($url, '//') === 0) {
            return $url;
        }
        // If dealing with a Root-Relative URL
        if (stripos($url, '/') === 0) {
            return $request_protocol.'://'.$_SERVER['HTTP_HOST'].$url;
        }
        // If dealing with an Absolute URL, just return it as-is
        if (stripos($url, 'http') === 0) {
            return $url;
        }
        // If dealing with a relative URL,
        // and attempt to handle double dot notation ".."
        do {
            $url = preg_replace('/[^\/]+\/\.\.\//', '', $url, 1, $count);
        } while ($count);
        // Return the absolute version of a Relative URL
        return $request_protocol.'://'.$_SERVER['HTTP_HOST'].'/'.$url;
    }
}
