<?php

namespace App\Http\Livewire\News;

use App\Models\LibraryItem;
use App\Traits\LNBitsTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use WireUi\Traits\Actions;

class InternArticleView extends Component
{
    use Actions;
    use LNBitsTrait;

    public LibraryItem $libraryItem;

    public $qrCode = '';
    public $invoice = '';
    public $paymentHash = '';
    public $checkid = null;
    public $checkThisPaymentHash = '';
    public bool $invoicePaid = false;
    public bool $alreadyPaid = false;

    public function mount()
    {
        $this->libraryItem->load([
            'libraries',
        ]);
        if ($this->libraryItem->libraries->where('is_public', false)
                                         ->count() > 0 && !auth()->check()) {
            abort(403, __('Sorry! You are not authorized to perform this action.'));
        }
        if (auth()->check() && auth()
                                   ->user()
                                   ->paidArticles()
                                   ->where('library_item_id', $this->libraryItem->id)
                                   ->count() > 0) {
            $this->invoicePaid = true;
        }
    }

    public function pay()
    {
        try {
            $invoice = $this->createInvoice(
                sats: $this->libraryItem->sats,
                memo: 'Payment for: "'.$this->libraryItem->slug.'" on Einundzwanzig Portal.',
                lnbits: $this->libraryItem->createdBy->lnbits,
            );
        } catch (\Exception $e) {
            $this->notification()
                 ->error('LNBits error: '.$e->getMessage());

            return;
        }
        session('payment_hash_article_'.$this->libraryItem->id, $invoice['payment_hash']);
        $this->paymentHash = $invoice['payment_hash'];
        $this->qrCode = base64_encode(QrCode::format('png')
                                            ->size(300)
                                            ->merge($this->libraryItem->lecturer->getFirstMedia('avatar')
                                                ? str(
                                                    $this->libraryItem
                                                        ->lecturer
                                                        ->getFirstMediaPath('avatar'))
                                                    ->replace('/home/einundzwanzig/portal.einundzwanzig.space',
                                                        ''
                                                    )
                                                : '/public/img/einundzwanzig.png',
                                                .3)
                                            ->errorCorrection('H')
                                            ->generate($invoice['payment_request']));
        $this->invoice = $invoice['payment_request'];
        $this->checkid = $invoice['checking_id'];
    }

    public function checkPaymentHash()
    {
        try {
            $invoice = $this->check($this->checkid ?? $this->checkThisPaymentHash,
                $this->libraryItem->createdBy->lnbits);
        } catch (\Exception $e) {
            $this->notification()
                 ->error('LNBits error: '.$e->getMessage());

            return;
        }
        if (isset($invoice['paid']) && $invoice['paid']) {
            $this->invoicePaid = true;
            if (auth()->check()) {
                auth()
                    ->user()
                    ->paidArticles()
                    ->syncWithoutDetaching($this->libraryItem->id);
            }
        } else {
            Log::error(json_encode($invoice, JSON_THROW_ON_ERROR));
        }
    }

    public function render()
    {
        if ($this->libraryItem->type === 'markdown_article') {
            $description = $this->libraryItem->excerpt ?? __('An entry in the library of Einundzwanzig.');
        } else {
            $description = $this->libraryItem->excerpt ?? __('Here we post important news that is relevant for everyone.');
        }

        return view('livewire.news.intern-article-view')->layout('layouts.app', [
            'SEOData' => new SEOData(
                title: $this->libraryItem->name,
                description: strip_tags($this->libraryItem->excerpt) ?? __('Here we post important news that is relevant for everyone.'),
                author: $this->libraryItem->lecturer->name,
                image: $this->libraryItem->getFirstMedia('main') ? $this->libraryItem->getFirstMediaUrl('main') : asset('img/einundzwanzig-wallpaper-benrath.png'),
                published_time: Carbon::parse($this->libraryItem->created_at),
                type: 'article',
            ),
        ]);
    }
}
