<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Models\CharacteristicOptions;
use Illuminate\Support\Facades\Input;
use App\Models\CharacteristicGroup;
use App\Models\Characteristics;
use App\Models\CharacteristicRules;
use App\Models\CharacteristicBit;
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
    public function edit($id)
    {
        $rules=CharacteristicGroup::find($id)->rules()->get();
        return view('admin.characteristics.create_edit')->with('fid',$id)->with('rules',$rules);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $rules=[];
        return view('admin.characteristics.create_edit')->with('fid',0)->with('rules',$rules);
    }

    /**
     * Send config to page builder for creating/editing a resource.
     *
     * @return JSON
     */
    public function get_config($id)
    {
        $data = [
            "renderType"=>"dynamicForm",
            "id"=>null,
            "targetEntity"=>"Characteristic",
            "values"=>[],
            "settings"=>[
                "view"=>[
                    "show"=>"form.dynamic",
                    "edit"=>"modal.dynamic"
                ],
                "form.dynamic"=>[],
                "button"=>"Add field"
            ]
        ];
        $settings = [
            "targetEntity"=>"CharacteristicSettings",
            "_settings"=>[
                "label"=>'Options',
            ],
            "variables"=>[
                'name'=>[
                    "renderType"=>"single",
                    'name' => 'text',
                    'values'=>'',
                    "attributes" => [
                        "type"=>'text',
                        "class" => 'form-control',
                    ],
                    "settings"=>[
                        "label" => 'Form name',
                        "type"=>'text'
                    ]
                ],
                "status"=>[
                    "renderType"=>"single",
                    'name' => 'status',
                    'values'=>'',
                    "attributes" => [
                        "type"=>'text',
                        "class" => 'form-control',
                    ],
                    "settings"=>[
                        "label" => 'Status',
                        "type"=>'select',
                        'option'=>[['key'=>1,'value'=>'on'],['key'=>0,'value'=>'off']],
                    ]
                ],
                "icon"=>[
                    "renderType"=>"single",
                    'name' => 'icon',
                    'values'=>'',
                    "settings"=>[
                        "label" => 'Status',
                        "type"=>'upload',
                    ]
                ]
            ],
        ];
        $threshold = [

        ];

        if($id) {
            $group = CharacteristicGroup::find($id);
            $data['id']=$id;
            $settings['variables']['name']['values'] = $group->name;
            $settings['variables']['status']['values'] = $group->status;
            $settings['variables']['icon']['values'] = $group->icon;

            foreach($group->characteristics()->get() as $chrct) {
                $arr=[];
                $arr['id'] = $chrct->id;
                $arr['_type'] = $chrct->_type;
                $arr['label'] = $chrct->label;
                //$arr['required'] = ($chrct->required)?1:0;
                $arr['position'] = $chrct->position;
                if($chrct->has('options')) {
                    $def_val = bindec($chrct->default_value);
                    $flag=1<<(strlen($chrct->default_value)-1);
                    $offset = 0;
                    $arr['option']=[];
                    foreach($chrct->options()->get() as $eav) {
                        $arr['option'][]=['id'=>$eav->id,'val'=>$eav->name,'vale'=>($def_val & ($flag>>$offset))?1:0];
                        $offset++;
                    }
                }
                $data['values'][]=$arr;
            }
        }

        $data=['opt'=>$settings,"cform"=>$data,'threshold'=>$threshold];
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return
     * Response
     */
    public function store(Request $request)
    {
        return false;
    }

    /**
     * Create a newly created, update existing resource in storage.
     *
     * @return Response
     */
    public function update(Request $request,$id)
    {
        $opt = $request->only('opt');

        if($id) {
            $group = CharacteristicGroup::find($id);
            $group->name = $opt['opt']['data']['variables']['name'];
            $group->icon = $opt['opt']['data']['variables']['icon'];
            $group->status = $opt['opt']['data']['variables']['status'];
        } else {
            $group = new CharacteristicGroup(['name' => $opt['opt']['data']]);
            $group->save();
        }
        $bitMask = new CharacteristicBit($group->id);
        $group->table_name = $bitMask->getTableName();
        $group->save();

        $group->rules()->delete();
        $req_rules = $request->only('rules');
        foreach($req_rules['rules'] as $arr){
            $group_rule =new CharacteristicRules();
            foreach($arr as $dataArr) {
                switch ($dataArr['name']) {
                    case 'srange':
                        $group_rule->srange=$dataArr['value'];
                        break;
                    case 'erange':
                        $group_rule->erange=$dataArr['value'];
                        break;
                    case 'rule':
                        $group_rule->rule=$dataArr['value'];
                        break;
                }
            }
            $group->rules()->save($group_rule);
        }

        $data = $request->only('cform');

        $new_chr = $data['cform']['data']['variables'];
        foreach($new_chr as $index=>$characteristic) {
            if(isset($characteristic['_status'])){
                if($characteristic['_status'] == 'DELETE') {
                    $group->characteristics()->where('id', '=', $characteristic['id'])->delete();
                    $bitMask->removeAttr([(int)$characteristic['id']], null);
                    unset($new_chr[$index]);
                }
            }
        }

        foreach($new_chr as $attr) {
            if (isset($attr['id']) && $attr['id']) {
                $characteristic = Characteristics::find($attr['id']);
                $characteristic->update($attr);
            } else {
                $characteristic = new Characteristics($attr);
                $group->characteristics()->save($characteristic);
            }
            $new_options = [];
            for ($i = 0; $i < count($attr['option']); $i++) {
                if($attr['option'][$i]['id']) $new_options[] = $attr['option'][$i]['id'];
            }

            $old_options = $characteristic->options()->lists('id')->all();
            if ($deleted = (array_diff($old_options, $new_options))) {
                $characteristic->options()->whereIn('id', $deleted)->delete();
                $bitMask->removeAttr($characteristic->id, $deleted);
            }

            $default_value = [];
            foreach ($attr['option'] as $optVal) {
                if ($optVal['id']) {
                    $chr_options = CharacteristicOptions::find($optVal['id']);
                    $chr_options->name = $optVal['val'];
                    $chr_options->save();
                } else {
                    $chr_options = new CharacteristicOptions();
                    $chr_options->name = $optVal['val'];
                    $characteristic->options()->save($chr_options);
                    $bitMask->addAttr($characteristic->id, $chr_options->id);
                }
                $default_value[$chr_options->id]=(isset($optVal['vale']) && $optVal['vale'])?1:0;
            }
            $bitMask->setDefault($characteristic->id,$default_value);
            $characteristic->default_value=implode('',array_values($default_value));
            $characteristic->save();
        }
        return response()->json(TRUE);
    }

    public function destroy($id){
        $group = CharacteristicGroup::find($id);
        $bitMask = new CharacteristicBit($group->id);
        $bitMask->_delete();
        $group->delete();
        return redirect()->route('admin.characteristics.index');
    }

    /**
     * Show a list of all the languages posts formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function data()
    {
        $chr = CharacteristicGroup::select(['id','icon', 'name', 'status', 'created_at']);

        return Datatables::of($chr)
            ->edit_column('icon', function($model) { return view('admin.characteristics.datatables.icon',['icon'=>$model->icon]); } )
            ->edit_column('status', function($model) { return view('admin.characteristics.datatables.status',['status'=>$model->status]); } )
            ->add_column('actions', function($model) { return view('admin.characteristics.datatables.control',['id'=>$model->id]); } )
            ->remove_column('id')
            ->make();
    }
}