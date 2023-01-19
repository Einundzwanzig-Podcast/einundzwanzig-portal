<?php

namespace App\Http\Livewire\Chat;

use App\Events\ChatMessageSentEvent;
use Livewire\Component;

class HighscoreChat extends Component
{
    public bool $open = false;

    public array $messages = [];
    public string $myNewMessage = '';

    public function rules()
    {
        return [
            'myNewMessage' => 'required|min:1|max:255',
        ];
    }

    public function getListeners()
    {
        return [
            'toggleHighscoreChat'                               => 'toggle',
            'echo:plebchannel,.App\Events\ChatMessageSentEvent' => 'chatMessageSent',
        ];
    }

    public function mount()
    {
        $this->messages = cache()->get('highscore_chat_messages', []);
    }

    public function toggle()
    {
        $this->open = !$this->open;
    }

    public function chatMessageSent()
    {
        $this->messages = cache()->get('highscore_chat_messages', []);
        $this->dispatchBrowserEvent('chat-updated');
    }

    public function sendMessage()
    {
        $this->validate();
        $newMessages = collect($this->messages)
            ->push([
                'fromId'   => auth()->id(),
                'fromName' => str(auth()->user()->name)->limit(2),
                'userImg'  => str(auth()->user()->profile_photo_url)->replace('background=EBF4FF', 'background=F7931A'),
                'message'  => $this->myNewMessage,
                'time'     => now()->asDateTime(),
            ])
            ->toArray();
        cache()->set('highscore_chat_messages', $newMessages);
        event(new ChatMessageSentEvent());
        $this->messages = $newMessages;
        $this->myNewMessage = '';
    }

    public function render()
    {
        return view('livewire.chat.highscore-chat');
    }
}
