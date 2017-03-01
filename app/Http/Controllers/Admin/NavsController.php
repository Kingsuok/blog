<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Navs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use League\Flysystem\Exception;

class NavsController extends CommonController
{
    //由于发现在laravel中，并不像MVC那样使用很多次的Modle对象，而很多是Model的静态方法，所以可以不用设置

    // GET， admin/nav , all nav list
    public function index()
    {
        $data = Navs::orderBy('nav_order','asc')->get();
        return view('admin/navs/list',compact('data'));
    }
    // ajax to update the order
    public function changeOrder()
    {
        $input = Input::all();
        $nav_id = $input['nav_id'];
        $navs = Navs::find($nav_id);
        $navs->nav_order = $input['nav_order'];
        try{
            $res = $navs->update();
            if ($res){
                $data = [
                    'status'=> 1,
                    'msg'=>'Sort change success'
                ];
            }
        }catch (Exception $e){
            $data = [
                'status'=> 0,
                'msg'=>'Sort change failure'
            ];
        }
        return $data;
    }
    // GET， admin/nav/create, add a new nav
    public function create()
    {
        return view('admin/navs/add');
    }
    // POST， admin/nav, store the added new nav
    public function store()
    {   // 判断nav_order是不是没有填写或填空，如果是，则默认为0
        if (!Input::get('nav_order')){
            Input::merge(['nav_order'=>0]);
        }
        $input = Input::except('_token');
        //验证表单数据 和 password验证和提交数据库
        $rules = [
            //格式：表单项name=>验证规则（required必填，between：个数要求， confirmed：两项内容一致）
            //特别注意：confirmed要求，表单中两项name要求： 第一个 x， 第二个：x_confirmation
            'nav_name'=>'required',
            'nav_alias'=>'required',
            'nav_url'=>'required',
            'nav_order'=>'integer',
            //'nav_order'=>'nullable|integer',// 可以为null，即表单可以不填数据库中为null，但是填了必须为正数
        ];
        //make方法中第一个参数：要验证的数据，第二：验证规则，第三：错误信息，错误信息都存放在$validator-errors()
        $validator = Validator::make($input,$rules);
        if ($validator->passes()){//验证是否通过
            $rs = Navs::create($input);
            if ($rs){
                return back()->with('errors','Add successfully!');
            }else{
                return back()->with('errors','Unknown Error!');
            }
        }else{
            return back()->withErrors($validator);
        }
    }
    // GET， admin/nav{nav}/edit, edit a nav
    public function edit($nav_id)
    {
        $field = Navs::find($nav_id);// get the nav
        return view('admin/navs/edit', compact('field'));
    }
    // PUT， admin/nav{nav}, update a nav
    public function update($nav_id)
    {
        // 判断nav_order是不是没有填写或填空，如果是，则默认为0
        if (!Input::get('nav_order')){
            Input::merge(['nav_order'=>0]);
        }
        $input = Input::except('_token','_method');
        //验证表单数据 和 提交数据库
        $rules = [
            //格式：表单项name=>验证规则（required必填，between：个数要求， confirmed：两项内容一致）
            //特别注意：confirmed要求，表单中两项name要求： 第一个 x， 第二个：x_confirmation
            'nav_name'=>'required',
            'nav_alias'=>'required',
            'nav_url'=>'required',
            'nav_order'=>'integer',// 可以为null，即可以不填，但是填了必须为正数
        ];
        //make方法中第一个参数：要验证的数据，第二：验证规则，第三：错误信息，错误信息都存放在$validator-errors()
        $validator = Validator::make($input,$rules);
        if ($validator->passes()){//验证是否通过
            try {
                Navs::where('nav_id',$nav_id)->update($input);
                return redirect('admin/nav');
            }catch (Exception $e) {
                return back()->with('errors','Unknown Error!');
            }
        }else{
            return back()->withErrors($validator);
        }
    }
    // DELETE， admin/nav{nav}, delete a nav
    public function destroy($nav_id)
    {
        $rs = Navs::where('nav_id',$nav_id)->delete();
        if ($rs){
            $data = [
                'status'=>1,
                'msg'=>'Delete success!'
            ];
        }else{
            $data = [
                'status'=>0,
                'msg'=>'Delete failure!'
            ];
        }
        return $data;
    }
    // GET， admin/nav{nav}, show a single nav
    public function show()
    {

    }


}