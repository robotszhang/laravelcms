<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
/**
 * 文件模型
 * @author kevin 2017-11-08
 * Class Pic
 * @package App
 */
class Config extends Model
{
    protected $table = 'config';
    protected $guarded = [];
    protected $dateFormat = 'U';

    /**
     * 将配置转换成单条记录
     * @author zjf 2017-11-08
     * @param $md5
     * @return array
     */
    protected function toItem(){
        $list = $this->select('key','value')->get();
        foreach($list as $val){
            if($val->key == 'talk_qq' || $val->key == 'talk_phone'){
                $val->value = str_replace('：',':',$val->value);
                $arr = [];
                $a = explode('|',$val->value);

                foreach($a as $v){
                    $b = explode(':',$v);
                    if(count($b) > 1){
                        $arr[] = ['key'=>$b[0],'value'=>$b[1]];
                    }else{
                        $arr[] = ['key'=>'','value'=>''];
                    }
                }
                $data[$val->key] = $arr;
            }else{
                $data[$val->key] = $val->value;
            }

        }
        return $data;
    }

}
