<?php

namespace App\Http\Livewire\BooksForPlebs;

use Livewire\Component;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class BookRentalGuide extends Component
{
    public function render()
    {
        return view('livewire.books-for-plebs.book-rental-guide')->layout('layouts.guest', [
            'SEOData' => new SEOData(
                title: __('BooksForPlebs'),
                description: __('Local book lending for Bitcoin-Meetup\'s.'),
                image: asset('img/book-rental.jpg')
            ),
        ]);
    }
}
