<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Models\User;
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
        return view('admin.agent.create_edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(AdminUsersEditFormRequest $request)
    {

        $user = new User ($request->except('password','password_confirmation'));
        //$user->password = bcrypt($request->password);
        $user->password = \Hash::make($request->input('password'));
        $user->confirmation_code = str_random(32);
        $user->save();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $user
     * @return Response
     */
    public function edit(User $agent)
    {
        return view('admin.agent.create_edit', compact('agent'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $user
     * @return Response
     */
    public function update(AdminUsersEditFormRequest $request, User $agent)
    {
        $password = $request->password;
        $passwordConfirmation = $request->password_confirmation;

        if (!empty($password)) {
            if ($password === $passwordConfirmation) {
                //$user->password = bcrypt($password);
                $agent->password = \Hash::make($request->input('password'));
            }
        }
        $agent->update($request->except('password','password_confirmation'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $user
     * @return Response
     */

    public function delete(User $agent)
    {
        return view('admin.agent.delete', compact('agent'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $user
     * @return Response
     */
    public function destroy(User $agent)
    {
        $agent->delete();
    }

    /**
     * Show a list of all the languages posts formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function data()
    {
        $agents = \Sentinel::findRoleBySlug('agent')->users()->with('roles')->select(array('users.id', 'users.name', 'users.email', 'users.created_at'));

        return Datatables::of($agents)
            ->add_column('actions', function($model) { return view('admin.agent.datatables.control',['id'=>$model->id]); })
            ->remove_column('id')
            ->make();
    }

}
