<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';
    protected $primaryKey = 'cate_id';
    public $timestamps = false;

    // set the mass assignment
    protected $guarded = [];


    // get all categories
    public function getCats()
    {
       // $cats = self::all();// 或者 $cats = Category::all()
        $cats = self::orderBy('cate_order','asc')->get();//或者 $cats = Category::orderBy('cate_order','asc')->get()
        return $this->tree($cats,'cate_id','cate_pid',0,0);
    }

    /**
     * Infinite level classification
     * @param $arr
     * @param string $id , the name of the attribute id
     * @param string $pid, the name of the attribute pid
     * @param int $pidValue
     * @param int $level
     * @return array
     */
    private function tree($arr, $id = 'id', $pid = 'pid',$pidValue = 0, $level = 0)
    {   $res = array();
        foreach ($arr as $k=>$v){
            if ($v->$pid == $pidValue){
                //$arr[$k]['level'] = $level;
                $arr[$k]->level = $level;
                $res[] = $v;
                $next = $this->tree($arr,$id, $pid, $v->$id, $level + 1);
                $res = array_merge($res, $next);
            }
        }
        return $res;
    }

    /** 父类-》子类-》子类-----
     * @param $cate_id
     * @return array
     */
    public function getReverseCategory($cate_id)
    {
        $cats = self::all();
        $sortCats = $this->getReverseTree($cats, $cate_id);
        krsort($sortCats);//reverse sort
        return $sortCats;
    }

    /**
     * 从子类-》父类-》父类-----
     * @param $arr
     * @param $cate_id
     * @return array
     */
    private function getReverseTree($arr, $cate_id)
    {
        $res = array();
        foreach ($arr as $v){
            if ($v['cate_id'] == $cate_id){
                $res[] = $v;
                $parent = $this->getReverseTree($arr, $v['cate_pid']);
                $res = array_merge($res, $parent);
            }
        }
        return $res;
    }
}
