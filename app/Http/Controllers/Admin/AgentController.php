<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Models\Agent;
use App\Models\AgentSphere;
use App\Models\Sphere;
//use App\Http\Requests\Admin\UserRequest;
use App\Http\Requests\AdminUsersEditFormRequest;
//use App\Repositories\UserRepositoryInterface;
use Datatables;


class AgentController extends AdminController
{


    public function __construct()
    {
        view()->share('type', 'agent');
    }

    /*
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index()
    {
        // Show the page
        return view('admin.agent.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $spheres = Sphere::active()->lists('name','id');
        return view('admin.agent.create_edit')->with('spheres',$spheres);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(AdminUsersEditFormRequest $request)
    {

        $user = new Agent ($request->except('password','password_confirmation','sphere'));
        //$user->password = bcrypt($request->password);
        $user->password = \Hash::make($request->input('password'));
        //$user->confirmation_code = str_random(32);
        $user->save();
        $role = \Sentinel::findRoleBySlug('agent');
        $user->roles()->attach($role);
        $user->spheres()->sync($request->only('sphere'));

        return redirect()->route('admin.agent.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $user
     * @return Response
     */
    public function edit($id)
    {
        $agent = Agent::with('sphereLink')->findOrFail($id);
        $spheres = Sphere::active()->lists('name','id');
        return view('admin.agent.create_edit', ['agent'=>$agent,'spheres'=>$spheres]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $user
     * @return Response
     */
    public function update(AdminUsersEditFormRequest $request, $id)
    {
        $agent=Agent::findOrFail($id);
        $password = $request->password;
        $passwordConfirmation = $request->password_confirmation;

        if (!empty($password)) {
            if ($password === $passwordConfirmation) {
                //$user->password = bcrypt($password);
                $agent->password = \Hash::make($request->input('password'));
            }
        }
        $agent->fill($request->except('password','password_confirmation'));
        $agent->save();

        $agent->spheres()->sync($request->only('sphere'));
        return redirect()->route('admin.agent.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $user
     * @return Response
     */
    public function destroy($id)
    {
        Agent::findOrFail($id)->delete();
        return redirect()->route('admin.agent.index');
    }

    /**
     * Show a list of all the languages posts formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function data()
    {
        $agents = Agent::listAll();

        return Datatables::of($agents)
            ->remove_column('first_name')
            ->remove_column('last_name')
            ->add_column('name', function($model) { return view('admin.agent.datatables.username',['user'=>$model]); })
            ->add_column('actions', function($model) { return view('admin.agent.datatables.control',['id'=>$model->id]); })
            ->remove_column('id')
            ->make();
    }

}
