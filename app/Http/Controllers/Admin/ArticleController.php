<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Article;
use App\Http\Model\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use League\Flysystem\Exception;

class ArticleController extends CommonController
{
    // GET， admin/article , all article list
    public function index()
    {
        //$data = Article::paginate(5);
        $data = Article::orderBy('art_id','desc')->paginate(5);//paginate（num）,分页函数，num每页显示条数
        //$pagingHtml = $data->links();//分页显示的html代码
        return view('admin.article.list',compact('data'));
    }
    // GET， admin/article/create, add a new article
    public function create()
    {
        $data = (new Category())->getCats();
        return view('admin/article/add',compact('data'));
    }
    // POST， admin/article, store the added new article
    public function store()
    {
        $input = Input::except('_token');
        $input['art_time'] = time();// add the time into $input
        //验证表单数据 和 提交数据库
        $rules = [
            //格式：表单项name=>验证规则（required必填，between：个数要求， confirmed：两项内容一致）
            //特别注意：confirmed要求，表单中两项name要求： 第一个 x， 第二个：x_confirmation
            'art_cat'=>'required',
            'art_title'=>'required',
            'art_editor'=>'required',
            'art_content'=>'required',
        ];
        //make方法中第一个参数：要验证的数据，第二：验证规则，第三：错误信息，错误信息都存放在$validator-errors()
        $validator = Validator::make($input,$rules);
        if ($validator->passes()){//验证是否通过
            $rs = Article::create($input);
            if ($rs){
                return back()->with('errors','Add successfully!');
            }else{
                return back()->with('errors','Unknown Error!');
            }
        }else{
            return back()->withErrors($validator);
        }
    }
    // GET， admin/article{article}/edit, edit an article
    public function edit($art_id)
    {
        $data = (new Category())->getCats();// get all categories
        $field = Article::find($art_id);
        return view('admin/article/edit', compact('field','data'));
    }
    // PUT， admin/article{article}, update an article
    public function update($art_id)
    {
        $input = Input::except('_token','_method');
        //验证表单数据 和 提交数据库
        $rules = [
            //格式：表单项name=>验证规则（required必填，between：个数要求， confirmed：两项内容一致）
            //特别注意：confirmed要求，表单中两项name要求： 第一个 x， 第二个：x_confirmation
            'art_cat'=>'required',
            'art_title'=>'required',
            'art_editor'=>'required',
            'art_content'=>'required',
        ];
        //make方法中第一个参数：要验证的数据，第二：验证规则，第三：错误信息，错误信息都存放在$validator-errors()
        $validator = Validator::make($input,$rules);
        if ($validator->passes()){//验证是否通过
            try{
                Article::where('art_id',$art_id)->update($input);
                return redirect('admin/article');
            }catch (Exception $e){
                return back()->with('errors','Unknown Error!');
            }
        }else{
            return back()->withErrors($validator);
        }
    }
    // DELETE， admin/article{article}, delete an article
    public function destroy($art_id)
    {
        $rs = Article::where('art_id',$art_id)->delete();
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
}
