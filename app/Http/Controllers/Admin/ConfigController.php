<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use League\Flysystem\Exception;

class ConfigController extends CommonController
{
    //由于发现在laravel中，并不像MVC那样使用很多次的Modle对象，而很多是Model的静态方法，所以可以不用设置

    // GET， admin/config , all config list
    public function index()
    {
        $data = Config::orderBy('conf_order','asc')->get();
        foreach ( $data as $v) {
            switch ($v->field_type){
                case 'input':
                    $content = '<input type="text" class="lg" name="conf_content[]" value="'.$v->conf_content.'">';
                    break;
                case 'textarea':
                    $content = '<textarea name="conf_content[]" id="" cols="30" rows="10">'.$v->conf_content.'</textarea>';
                    break;
                case 'radio':
                    $arrayValue = explode(',',$v->field_value);
                    $contentValue = $v->conf_content;
                    $checked_0 = $contentValue == 0? 'checked':'';
                    $checked_1 = $contentValue == 1? 'checked':'';
                    $content = '<input type="radio"  name="conf_content[]" value="0" '.$checked_0.' >' . $arrayValue[0].'　　'
                    .'<input type="radio"  name="conf_content[]" value="1" '.$checked_1.' >' . $arrayValue[1];
                    break;
                default:
                    $content = '';
            }
            $v['_html'] = $content;
        }
        return view('admin/config/list',compact('data'));
    }
    // ajax to update the order
    public function changeOrder()
    {
        $input = Input::all();
        $conf_id = $input['conf_id'];
        $config = Config::find($conf_id);
        $config->conf_order = $input['conf_order'];
        try{
            $res = $config->update();
            //如果order没有变化而跟新就返回0， 有变化更新后返回1
            if ($res){
                $data = [
                    'status'=> 1,
                    'msg'=>'Sort change success'
                ];
            }
        }catch(Exception $e){// 有异常返回更新失败
            $data = [
                'status'=> 0,
                'msg'=>'Sort change failure'
            ];
        }
        return $data;
    }
    // change content from index page directly
    public function changeContent()
    {
        $input = Input::all();
        foreach ($input['conf_id'] as $k => $conf_id) {
            try{
                Config::where('conf_id',$conf_id)->update(['conf_content'=>$input['conf_content'][$k]]);
            }catch (Exception $e){
                return back()->with('errors','Unknown error!');
            }
        }
        $this->writeFile();// update config file
        return back()->with('errors','Change successfully!');
    }
    // GET， admin/config/create, add a new config
    public function create()
    {
        return view('admin/config/add');
    }
    // POST， admin/config, store the added new config
    public function store()
    {   // 判断conf_order是不是没有填写或填空，如果是，则默认为0
        if (!Input::get('conf_order')){
            Input::merge(['conf_order'=>0]);
        }
        $input = Input::except('_token');
        //验证表单数据 和 password验证和提交数据库
        $rules = [
            //格式：表单项name=>验证规则（required必填，between：个数要求， confirmed：两项内容一致）
            //特别注意：confirmed要求，表单中两项name要求： 第一个 x， 第二个：x_confirmation
            'conf_title'=>'required',
            'conf_name'=>'required',
            'field_type'=>'required',
            'conf_content'=>'required',
            'conf_order'=>'integer',
            //'conf_order'=>'nullable|integer',// 可以为null，即表单可以不填数据库中为null，但是填了必须为正数
        ];
        // 只有当为radio时，才有field_value，才判断
        if ($input['field_type'] == 'radio'){
            $rules['field_value_0'] = 'required';
            $rules['field_value_1'] = 'required';
            $rules['conf_content'] = 'required|integer|between:0,1';
        }
        //make方法中第一个参数：要验证的数据，第二：验证规则，第三：错误信息，错误信息都存放在$validator-errors()
        $validator = Validator::make($input,$rules);
        if ($validator->passes()){//验证是否通过
            //如果type是radio,则要存储field_value
            if ($input['field_type'] == 'radio'){
                $input['field_value'] = $input['field_value_0'] . "," . $input['field_value_1'];
            }
            // 在insert数据库前去除，没有的字段field_value_0, field_value_1
            unset($input['field_value_0']);
            unset($input['field_value_1']);
            $rs = Config::create($input);
            if ($rs){
                $this->writeFile();//update config value
                return back()->with('errors','Add successfully!');
            }else{
                return back()->with('errors','Unknown Error!');
            }
        }else{
            return back()->withErrors($validator);
        }
    }
    // GET， admin/config{config}/edit, edit a config
    public function edit($conf_id)
    {
        $field = Config::find($conf_id);// get the config
        if ($field['field_type'] == 'radio'){
            $field_value = $field['field_value'];
            $arrayValue = explode(',',$field_value);
            $field['field_value_0'] = $arrayValue[0];
            $field['field_value_1'] = $arrayValue[1];
        }
        return view('admin/config/edit', compact('field'));
    }
    // PUT， admin/config{config}, update a config
    public function update($conf_id)
    {
        // 判断conf_order是不是没有填写或填空，如果是，则默认为0
        if (!Input::get('conf_order')){
            Input::merge(['conf_order'=>0]);
        }
        $input = Input::except('_token','_method');
        //验证表单数据 和 提交数据库
        $rules = [
            //格式：表单项name=>验证规则（required必填，between：个数要求， confirmed：两项内容一致）
            //特别注意：confirmed要求，表单中两项name要求： 第一个 x， 第二个：x_confirmation
            'conf_title'=>'required',
            'conf_name'=>'required',
            'field_type'=>'required',
            'conf_content'=>'required',
            'conf_order'=>'integer',
        ];
        if ($input['field_type'] == 'radio'){
            $rules['field_value_0'] = 'required';
            $rules['field_value_1'] = 'required';
            $rules['conf_content'] = 'required|integer|between:0,1';
        }
        //make方法中第一个参数：要验证的数据，第二：验证规则，第三：错误信息，错误信息都存放在$validator-errors()
        $validator = Validator::make($input,$rules);
        if ($validator->passes()){//验证是否通过
            //如果type是radio,则要存储field_value
            if ($input['field_type'] == 'radio'){
                $input['field_value'] = $input['field_value_0'] . "," . $input['field_value_1'];
            }
            // 在insert数据库前去除，没有的字段field_value_0, field_value_1
            unset($input['field_value_0']);
            unset($input['field_value_1']);
            try{
                Config::where('conf_id',$conf_id)->update($input);
                $this->writeFile();// update config file
                return redirect('admin/config');
            }catch (Exception $e){
                return back()->with('errors','Unknown Error!');
            }
        }else{
            return back()->withErrors($validator);
        }
    }
    // DELETE， admin/config{config}, delete a config
    public function destroy($conf_id)
    {
        $rs = Config::where('conf_id',$conf_id)->delete();
        if ($rs){
            $data = [
                'status'=>1,
                'msg'=>'Delete success!'
            ];
            $this->writeFile();// update config file
        }else{
            $data = [
                'status'=>0,
                'msg'=>'Delete failure!'
            ];
        }
        return $data;
    }

    // GET， admin/config{config}, show a single config
    public function show()
    {

    }
    //GET, admin/config/
    //write config into file under directory: config
    public function writeFile()
    {
        //获得config的数组形式数据
        $config = Config::pluck('conf_content', 'conf_name')->all();
        //数组转为字符串
        $config = var_export($config,true);
        //要写入的内容
        $config = "<?php \n return " . $config .';'; // 想用\n换行，必须用双引号把\n引起了，否则直接输出\n
        //要写入的文件目录
        $path = base_path().'\config\web.php';
        // 写入操作
        file_put_contents($path,$config);
    }
}