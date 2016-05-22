<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\SphereMask;
use Validator;
use App\Models\Agent;
use App\Models\Credits;
use App\Models\Lead;
use App\Models\LeadPhone;
use App\Models\Sphere;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
//use App\Http\Requests\Admin\ArticleRequest;
use Datatables;

class LeadController extends Controller {

    public function __construct()
    {
        $this->uid = \Sentinel::getUser()->id;
    }
     /*
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index()
    {
        // Show the page
        return view('agent.lead.index');
    }

    public function deposited(){
        $leads = Agent::find($this->uid)->leads()->with('phone')->get();
        return view('agent.lead.deposited')->with('leads',$leads);
    }

    public function obtain(){
        $agent = Agent::with('spheres.leads','spheres.leadAttr')->find($this->uid);
        $mask = new SphereMask($agent->sphere()->id);
        $mask->setUserID($this->uid);

        $list = $mask->obtain()->skip(0)->take(10);
        $leads = Lead::with('obtainedBy')->whereIn('id',$list->lists('user_id'))->get();
        $lead_attr = $agent->sphere()->leadAttr()->get();
        return view('agent.lead.obtain')
            ->with('leads',$leads)
            ->with('lead_attr',$lead_attr)
            ->with('filter',$list->get());
    }

    public function obtainData(){
        $agent = Agent::with('spheres.leads','spheres.leadAttr')->find($this->uid);
        $mask = new SphereMask($agent->sphere()->id);
        $mask->setUserID($this->uid);

        $list = $mask->obtain();
        $leads = Lead::with('phone')->whereIn('id',$list->lists('user_id'))
            ->select(['leads.opened','leads.id','leads.id as status','leads.updated_at','leads.name','leads.phone_id','leads.email']);

        $datatable = Datatables::of($leads)
            ->edit_column('opened',function($model){
                return view('agent.lead.datatables.obtain_count',['opened'=>$model->opened]);
            })
            ->edit_column('id',function($model){
                return view('agent.lead.datatables.obtain_open',['lead'=>$model]);
            })
            ->edit_column('status',function($model){
                return '';
            })
            ->edit_column('phone_id',function($lead) use ($agent){
                return ($lead->obtainedBy($agent->id)->count())?$lead->phone->phone:trans('lead.hidden');
            })
            ->edit_column('email',function($lead) use ($agent){
                return ($lead->obtainedBy($agent->id)->count())?$lead->email:trans('lead.hidden');
            });
        $lead_attr = $agent->sphere()->leadAttr()->get();
        foreach($lead_attr as $l_attr){
            $datatable->add_column($l_attr->label,function($model) use ($l_attr){
                return $l_attr;
            });
        }
        return $datatable->make();
    }

    public function openLead($id){
        $agent = Agent::with('bill')->find($this->uid);
        $credit = Credits::where('agent_id','=',$this->uid)->sharedLock()->first();
        $balance = $credit->balance;

        $mask = new SphereMask($agent->sphere()->id);
        $mask->setUserID($this->uid);
        $price = $mask->findMask()->sharedLock()->first()->lead_price;

        if($price > $balance) {
            return redirect()->route('agent.lead.obtain',[0]);
        }

        $lead = Lead::lockForUpdate()->find($id);
        if($lead->sphere->openLead > $lead->opened) {
            $lead->obtainedBy()->attach($this->uid);
            $lead->opened+=1;
            $credit->payment=$price;
            $credit->save();
            //$credit->history()->save(new CreditHistory());
        }
        $lead->save();

        return redirect()->route('agent.lead.obtain');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $spheres = Sphere::active()->lists('name','id');
        return view('agent.lead.create')->with('lead',[])->with('spheres',$spheres);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|regex:/\(?([0-9]{3})\)?([\s.-])*([0-9]{3})([\s.-])*([0-9]{4})/',
            'name' => 'required'
        ]);
        $agent = Agent::with('sphereLink')->findOrFail($this->uid);

        if ($validator->fails() || !$agent->sphereLink) {
            if($request->ajax()){
                return response()->json($validator);
            } else {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }


        $phone = LeadPhone::firstOrCreate(['phone'=>preg_replace('/[^\d]/','',$request->input('phone'))]);

        $lead = new Lead($request->except('phone'));
        $lead->phone_id=$phone->id;
        $lead->date=date('Y-m-d');

        $agent->leads()->save($lead);

        if($request->ajax()){
            return response()->json();
        } else {
            return redirect()->route('agent.lead.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return Response
     */
    public function destroy($id)
    {
        Agent::findOrFail($this->uid)->leads()->whereIn([$id])->delete();
        return response()->route('agent.lead.index');
    }



}
