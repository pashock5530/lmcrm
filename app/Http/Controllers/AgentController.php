<?php

namespace App\Http\Controllers;

use App\Models\Salesman;
use App\Models\SphereMask;
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
        if(\Sentinel::inRole('agent')) {
            $agent = Agent::findOrFail($this->uid);
            $bill=$agent->bill()->first();
            $sphere_id=$agent->sphere()->id;
        } elseif(\Sentinel::inRole('salesman')) {
            $salesman = Salesman::findOrFail($this->uid);
            $bill=$salesman->bill()->first();
            $sphere_id=$salesman->sphere()->id;
        } else {
            return redirect()->route('login');
        }

        $mask = new SphereMask($sphere_id,$this->uid);
        $price = $mask->getPrice()->lead_price;
        $price = ($price)?floor($bill->balance/$price):0;
        view()->share('balance', [$bill->real,$price]);
    }
}
