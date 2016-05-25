<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
//use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Agent;


class AgentController extends BaseController
{
//    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    use DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $this->uid = \Sentinel::getUser()->id;
        $bill=Agent::findOrFail($this->uid)->bill()->first();
        view()->share('balance', [$bill->real,$bill->virtual]);
    }
}
