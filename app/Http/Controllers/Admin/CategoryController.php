<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use League\Flysystem\Exception;

class CategoryController extends CommonController
{
    //由于发现在laravel中，并不像MVC那样使用很多次的Modle对象，而很多是Model的静态方法，所以可以不用设置
    private $category = null;
    public function __construct()
    {
        $this->category = new Category();
    }
    // GET， admin/category , all category list
    public function index()
    {
        $data = $this->category->getCats();
        return view('admin/category/list', compact('data'));// 推荐使用 compact()
        //return view('admin/category/list')->with('data', $cats);
    }
    // ajax to update the order
    public function changeOrder()
    {
       $input = Input::all();
       $cate_id = $input['cate_id'];
       $cat = Category::find($cate_id);
       $cat->cate_order = $input['cate_order'];
       try{
           $res = $cat->update();
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
    // GET， admin/category/create, add a new category
    public function create()
    {
        $data = Category::where('cate_pid',0)->get();
        return view('admin/category/add',compact('data'));
    }
    // POST， admin/category, store the added new category
    public function store()
    {
        $input = Input::except('_token');
        //验证表单数据 和 password验证和提交数据库
        $rules = [
            //格式：表单项name=>验证规则（required必填，between：个数要求， confirmed：两项内容一致）
            //特别注意：confirmed要求，表单中两项name要求： 第一个 x， 第二个：x_confirmation
            'cate_pid'=>'required',
            'cate_name'=>'required',
            'cate_title'=>'required',
            'cate_keywords'=>'required',
            'cate_order'=>'required|integer',
        ];
        //make方法中第一个参数：要验证的数据，第二：验证规则，第三：错误信息，错误信息都存放在$validator-errors()
        $validator = Validator::make($input,$rules);
        if ($validator->passes()){//验证是否通过
            $rs = Category::create($input);
            if ($rs){
                return back()->with('errors','Add successfully!');
            }else{
                return back()->with('errors','Unknown Error!');
            }
        }else{
            return back()->withErrors($validator);
        }
    }
    // GET， admin/category{category}/edit, edit a category
    public function edit($cate_id)
    {
        $data = Category::where('cate_pid',0)->get();// get all categories
        $field = Category::find($cate_id);
        return view('admin/category/edit', compact('field','data'));
    }
    // PUT， admin/category{category}, update a category
    public function update($cate_id)
    {
        $input = Input::except('_token','_method');
        //验证表单数据 和 password验证和提交数据库
        $rules = [
            //格式：表单项name=>验证规则（required必填，between：个数要求， confirmed：两项内容一致）
            //特别注意：confirmed要求，表单中两项name要求： 第一个 x， 第二个：x_confirmation
            'cate_pid'=>'required',
            'cate_name'=>'required',
            'cate_title'=>'required',
            'cate_keywords'=>'required',
            'cate_order'=>'required',
        ];
        //make方法中第一个参数：要验证的数据，第二：验证规则，第三：错误信息，错误信息都存放在$validator-errors()
        $validator = Validator::make($input,$rules);
        if ($validator->passes()){//验证是否通过
            try{
                Category::where('cate_id',$cate_id)->update($input);
                return redirect('admin/category');
            }catch (Exception $e){
                return back()->with('errors','Unknown Error!');
            }
        }else{
            return back()->withErrors($validator);
        }
    }
    // DELETE， admin/category{category}, delete a category
    public function destroy($cate_id)
    {
        $rs = Category::where('cate_id',$cate_id)->delete();
        $cate_pid = Input::get('cate_pid');
        if ($cate_pid == 0){// check whether the item is top category or not, if yes, the sub-categories's pid =0
            Category::where('cate_pid',$cate_id)->update(['cate_pid'=>0]);
        }
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
    // GET， admin/category{category}, show a single category
    public function show()
    {

    }


}

