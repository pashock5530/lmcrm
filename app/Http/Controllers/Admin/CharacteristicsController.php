<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Models\CharacteristicOptions;
use Illuminate\Support\Facades\Input;
use App\Models\CharacteristicGroup;
use App\Models\Characteristics;
use Illuminate\Http\Request;
use Datatables;

class CharacteristicsController extends AdminController {
    public function __construct()
    {
        view()->share('type', 'characteristics');
    }
    /*
   * Display a listing of the resource.
   *
   * @return Response
   */
    public function index()
    {
        // Show the page
        return view('admin.characteristics.index');
    }

    /**
     * Show the form for edit the resource.
     *
     * @return Response
     */
    public function edit()
    {
        return view('admin.characteristics.create_edit');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.characteristics.create_edit');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return JSON
     */
    public function get_config()
    {
        $data = json_decode('{"CustomForm":{"renderType":"dynamicForm","targetEntity":"","id":null,"values":[],"settings":{"label":"Dynamic Form","view":{"show":"form.dynamic","edit":"modal.dynamic"},"form.dynamic":[],"button":"Add field"}}}');
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $group = new CharacteristicGroup(['name'=>'test2']);
        $group->save();

        $data = $request->only('CustomForm');
        foreach($data['CustomForm']['variables'] as $attr) {
            $characteristic = new Characteristics($attr);
            $group -> characteristics() -> save($characteristic);
            foreach($attr['option'] as $opt) {
                $options = new CharacteristicOptions(['name'=>$opt]);
                $characteristic->options()->save($options);
            }
        }

        return response()->json(TRUE);
    }

    /**
     * Show a list of all the languages posts formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function data()
    {
        $chr = CharacteristicGroup::select(['id', 'name', 'table_name', 'created_at']);

        return Datatables::of($chr)
            ->add_column('actions', '<a href="{{ route(\'admin.characteristics.edit\',[$id]) }}" class="btn btn-success btn-sm" ><span class="glyphicon glyphicon-pencil"></span>  {{ trans("admin/modal.edit") }}</a>
                    <a href="{{{ URL::to(\'admin/user/\' . $id . \'/delete\' ) }}}" class="btn btn-sm btn-danger"><span class="glyphicon glyphicon-trash"></span> {{ trans("admin/modal.delete") }}</a>')
            ->remove_column('id')
            ->make();
    }
}