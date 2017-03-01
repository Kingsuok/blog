<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Links;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use League\Flysystem\Exception;

class LinksController extends CommonController
{
    //由于发现在laravel中，并不像MVC那样使用很多次的Modle对象，而很多是Model的静态方法，所以可以不用设置

    // GET， admin/link , all link list
    public function index()
    {
        $data = Links::orderBy('link_order','asc')->get();
        return view('admin/links/list',compact('data'));
    }
    // ajax to update the order
    public function changeOrder()
    {$input = Input::all();
        $link_id = $input['link_id'];
        $links = Links::find($link_id);
        $links->link_order = $input['link_order'];
        try{$res = $links->update();
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
    // GET， admin/link/create, add a new link
    public function create()
    {
        return view('admin/links/add');
    }
    // POST， admin/link, store the added new link
    public function store()
    {   // 判断link_order是不是没有填写或填空，如果是，则默认为0
        if (!Input::get('link_order')){
            Input::merge(['link_order'=>0]);
        }
        $input = Input::except('_token');
        //验证表单数据 和 password验证和提交数据库
        $rules = [
            //格式：表单项name=>验证规则（required必填，between：个数要求， confirmed：两项内容一致）
            //特别注意：confirmed要求，表单中两项name要求： 第一个 x， 第二个：x_confirmation
            'link_name'=>'required',
            'link_url'=>'required',
            'link_order'=>'integer',
            //'link_order'=>'nullable|integer',// 可以为null，即表单可以不填数据库中为null，但是填了必须为正数
        ];
        //make方法中第一个参数：要验证的数据，第二：验证规则，第三：错误信息，错误信息都存放在$validator-errors()
        $validator = Validator::make($input,$rules);
        if ($validator->passes()){//验证是否通过
            $rs = Links::create($input);
            if ($rs){
                return back()->with('errors','Add successfully!');
            }else{
                return back()->with('errors','Unknown Error!');
            }
        }else{
            return back()->withErrors($validator);
        }
    }
    // GET， admin/link{link}/edit, edit a link
    public function edit($link_id)
    {
        $field = Links::find($link_id);// get the link
        return view('admin/links/edit', compact('field'));
    }
    // PUT， admin/link{link}, update a link
    public function update($link_id)
    {
        // 判断link_order是不是没有填写或填空，如果是，则默认为0
        if (!Input::get('link_order')){
            Input::merge(['link_order'=>0]);
        }
        $input = Input::except('_token','_method');
        //验证表单数据 和 提交数据库
        $rules = [
            //格式：表单项name=>验证规则（required必填，between：个数要求， confirmed：两项内容一致）
            //特别注意：confirmed要求，表单中两项name要求： 第一个 x， 第二个：x_confirmation
            'link_name'=>'required',
            'link_url'=>'required',
            'link_order'=>'integer',// 可以为null，即可以不填，但是填了必须为正数
        ];
        //make方法中第一个参数：要验证的数据，第二：验证规则，第三：错误信息，错误信息都存放在$validator-errors()
        $validator = Validator::make($input,$rules);
        if ($validator->passes()){//验证是否通过
            try{
                Links::where('link_id',$link_id)->update($input);
                return redirect('admin/link');
            }catch (Exception $e){
                return back()->with('errors','Unknown Error!');
            }
        }else{
            return back()->withErrors($validator);
        }
    }
    // DELETE， admin/link{link}, delete a link
    public function destroy($link_id)
    {
        $rs = Links::where('link_id',$link_id)->delete();
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
    // GET， admin/link{link}, show a single link
    public function show()
    {

    }


}