<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EmailCampaign;

class EmailCampaignController extends Controller
{
    public function __invoke()
    {
        return EmailCampaign::query()->get();
    }

}
