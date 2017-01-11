<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\AgentController;
use App\Models\SphereMask;
use Illuminate\Http\Request;
use App\Models\Lead;
use DB;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ProfileController extends AgentController {

    /**
     * @return $this
     */
    public function index() {
        $leads = $this->user->leads()
            ->with('customer')
            ->join('open_leads', function ($join){
                $join->on('leads.id', '=', 'open_leads.lead_id')
                    ->where('open_leads.agent_id', '=', $this->uid);
            })
            ->get();

        return view('agent.profile.index')->with('leads', $leads);
    }

    /**
     * @param Request $request
     * @return $this
     */
    public function ajaxData(Request $request) {
        if ($request->ajax()) {
            $name = $request->input('name');
            $data = $this->user->leads()
                ->with('customer')
                ->with('sphere_attributes')
                ->where('leads.name', $name)
                ->limit(1)
                ->get();

            if (count($data) > 0) {
                $masks = [];
                $mask = null;

                foreach ($data[0]->sphere_attributes as $attribute) {
                    $mask = new SphereMask($attribute->sphere_id);
                    $masks = $mask->findShortMask($data[0]->id);
                }

            }

            return view('agent.profile._data')
                ->with('data', count($data) > 0 ? $data[0] : [])
                ->with('masks', $masks);
        } else {
            throw new BadRequestHttpException();
        }
    }

}