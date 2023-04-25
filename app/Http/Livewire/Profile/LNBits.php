<?php

namespace App\Http\Livewire\Profile;

use App\Traits\HasTextToSpeech;
use App\Traits\LNBitsTrait;
use Illuminate\Support\Facades\File;
use Livewire\Component;
use WireUi\Traits\Actions;

class LNBits extends Component
{
    use Actions;
    use LNBitsTrait;
    use HasTextToSpeech;

    public array $settings = [
        'url'       => 'https://legend.lnbits.com',
        'wallet_id' => '',
        'read_key'  => '',
    ];

    public function rules()
    {
        return [
            'settings.url'       => 'required|url',
            'settings.wallet_id' => 'required',
            'settings.read_key'  => 'required',
        ];
    }

    public function mount()
    {
        if (auth()->user()->lnbits) {
            $this->settings = auth()->user()->lnbits;
            if ($this->settings['url'] === null) {
                $this->settings['url'] = 'https://legend.lnbits.com';
            }
        }
    }

    public function save()
    {
        $this->validate();
        if ($this->checkLnbitsSettings($this->settings['read_key'], $this->settings['url'], $this->settings['wallet_id']) === false) {
            $this->notification()
                 ->error(__('LNBits settings are not valid!'));
            $legends = "Außerdem hast du nicht deine eigene Nod verwendet. Markus Turm wird darüber sehr traurig sein. Komm in die Einundzwanzig Telegramm Gruppe, und melde dich sofort bei Markus Turm mit einer Entschuldigung.";
            $text = sprintf("
            Es gab einen Fehler beim Speichern der LN Bitts Einstellungen. Bitte überprüfe die A P I Daten. %s
            ", $this->settings['url'] === 'https://legend.lnbits.com' ? $legends : '');
            File::put(storage_path('app/public/tts/lnbits_error.txt'), $text);
            dispatch(new \App\Jobs\CodeIsSpeech('lnbits_error', false))->delay(now()->addSecond());

            return;
        }
        $user = auth()->user();
        $user->lnbits = $this->settings;
        $user->save();

        $this->notification()
             ->success(__('LNBits settings saved successfully!'));
    }

    public function render()
    {
        return view('livewire.profile.l-n-bits');
    }
}
