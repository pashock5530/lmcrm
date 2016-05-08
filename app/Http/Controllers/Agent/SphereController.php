<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Validator;
use App\Models\Agent;
use App\Models\CharacteristicGroup as Sphere;
use App\Models\Characteristics as SphereAttr;
use App\Models\CharacteristicBit as SphereMask;

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
        $spheres = Sphere::active()->get();
        // Show the page
        return view('agent.sphere.index')->with('spheres',$spheres);
    }

    /**
     * Show the form to edit resource.
     *
     * @return Response
     */
    public function edit($id)
    {
        $data = Sphere::findOrFail($id);
        $data->load('characteristics.options');
        //$mask = new SphereMask($group->id);
        //$data = $mask->findMask(\Sentinel::getUser()->id);
        return view('agent.sphere.edit')->with('sphere',$data);
    }

    /**
     * Store the resource in storage.
     *
     * @return Response
     */
    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'options[]' => 'numeric',
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
        $mask->agent_id=\Sentinel::getUser()->id;


        $mask->save();

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
        Agent::findOrFail(\Sentinel::getUser()->id)->leads()->whereIn([$id])->delete();
        return response()->route('agent.lead.index');
    }


}
