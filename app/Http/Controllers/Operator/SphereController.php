<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use Validator;
use App\Models\Agent;
use App\Models\Sphere;
use App\Models\SphereMask;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
//use App\Http\Requests\Admin\ArticleRequest;

class SphereController extends Controller {

    public function __construct()
    {
        view()->share('type', 'article');
    }
     /*
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index()
    {
        $spheres = Sphere::with('leads')->active()->get();
        return view('sphere.lead.list')->with('spheres',$spheres);
    }

    /**
     * Show the form to edit resource.
     *
     * @return Response
     */
    public function edit($sphere,$id)
    {
        $data = Sphere::findOrFail($sphere);
        $data->load('attributes.options');
        $mask = new SphereMask($data->id);
        $mask = $mask->findAgentShortMask(\Sentinel::getUser()->id);
        return view('agent.sphere.edit')->with('sphere',$data)->with('mask',$mask);
    }

    /**
     * Store the resource in storage.
     *
     * @return Response
     */
    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'options.*' => 'integer',
        ]);
        if ($validator->fails()) {
            if($request->ajax()){
                return response()->json($validator);
            } else {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }
        $sphere = Sphere::findOrFail($id);
        $mask = new SphereMask($sphere->id);

        $options=array();
        if ($request->has('options')) {
            $options=$request->only('options')['options'];
        }
        $mask->setAttr(\Sentinel::getUser()->id,$options);

        if($request->ajax()){
            return response()->json();
        } else {
            return redirect()->route('agent.sphere.index');
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
        Agent::findOrFail(\Sentinel::getUser()->id)->leads()->whereIn([$id])->delete();
        return response()->route('agent.lead.index');
    }


}
