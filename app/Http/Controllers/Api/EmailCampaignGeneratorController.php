<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EmailTexts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EmailCampaignGeneratorController extends Controller
{
    public function __construct(public $model = 'openai/gpt-4', public $maxTokens = 8191)
    {
    }

    public function __invoke(Request $request)
    {
        $campaignId = $request->get('id');
        $md5 = $request->get('md5');

        $campaign = \App\Models\EmailCampaign::query()->find($campaignId);

        $subject = $this->generateSubject($campaign);
        //check if subject exists in database
        $subjectExists = EmailTexts::query()->where('subject', $subject)->exists();
        // loop until subject is unique
        while ($subjectExists) {
            $subject = $this->generateSubject($campaign);
            $subjectExists = EmailTexts::query()->where('subject', $subject)->exists();
        }

        $text = $this->generateText($campaign);

        $emailText = EmailTexts::query()->create([
            'email_campaign_id' => $campaign->id,
            'sender_md5' => $md5,
            'subject' => $subject,
            'text' => $text,
        ]);
        $emailText->load('emailCampaign');

        return $emailText;
    }

    public function generateSubject(\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Builder|array|null $campaign): string
    {
        $result = Http::timeout(120)->withHeaders([
            'Authorization' => 'Bearer ' . config('openai.api_key'),
            'HTTP-Referer' => 'http://localhost',
        ])->post('https://openrouter.ai/api/v1/chat/completions', [
            'model' => $this->model,
            'max_tokens' => 50,
            'temperature' => 1,
            'messages' => [
                ['role' => 'user', 'content' => $campaign->subject_prompt],
            ],
        ]);

        if ($result->failed()) {
            Log::error($result->json());
            abort(500, 'OpenAI API failed');
        }

        return $result->json()['choices'][0]['message']['content'];
    }

    public function generateText(\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Builder|array|null $campaign): mixed
    {
        $result = Http::timeout(120)->withHeaders([
            'Authorization' => 'Bearer ' . config('openai.api_key'),
            'HTTP-Referer' => 'http://localhost',
        ])->post('https://openrouter.ai/api/v1/chat/completions', [
            'model' => $this->model,
            'max_tokens' => $this->maxTokens,
            'temperature' => 1,
            'messages' => [
                ['role' => 'user', 'content' => $campaign->text_prompt],
            ],
        ]);

        if ($result->failed()) {
            Log::error($result->json());
            abort(500, 'OpenAI API failed');
        }

        return $result->json()['choices'][0]['message']['content'];
    }

}
