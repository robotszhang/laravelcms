<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

/**
 * 基础控制器
 * @author my 2017-10-25
 * Class MenuController
 * @package App\Http\Controllers\Admin
 */
class BaseController extends Controller
{
    /**
     * 删除内容
     * @author my  2017-10-25
     * @param Request $request 请求
     * @return array
     */
    public function ajaxDel(Request $request){
        $res = DB::table($request->mod)->whereIn('id',$request->ids)->delete();
        if($res){
            return response()->json(['status'=>1,'msg'=>'删除成功']);
        }else {
            return response()->json(['status'=>0,'msg'=>'删除失败']);
        }
    }

    /**
     * 置顶
     * @author zjf ${date}
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxStick(Request $request){
        $res = DB::table($request->mod)->whereIn('id',$request->ids)->update(['is_stick'=>1,'sort'=>500]);
        if($res){
            return response()->json(['status'=>1,'msg'=>'置顶成功']);
        }else {
            return response()->json(['status'=>0,'msg'=>'置顶失败']);
        }
    }

    /**
     * 取消置顶
     * @author zjf ${date}
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxUnstick(Request $request){
        $res = DB::table($request->mod)->whereIn('id',$request->ids)->update(['is_stick'=>0]);
        if($res){
            return response()->json(['status'=>1,'msg'=>'置顶成功']);
        }else {
            return response()->json(['status'=>0,'msg'=>'置顶失败']);
        }
    }

    /**
     * 批量排序
     * @author zjf ${date}
     * @param Request $request
     * $_POST = ['mod'=>'','sort_data'=>[['id'=>'','sort'=>''],...]]
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxSetsort(Request $request){
        foreach($request->sort_data as $val){
            DB::table($request->mod)->where('id',$val['id'])->update(['sort'=>$val['sort']]);
        }
        return response()->json(['status'=>1,'msg'=>'排序成功']);
    }

    /**
     * 分类变更
     * @author zjf ${date}
     * @param Request $request
     * $_POST = ['mod'=>,'ids'=>[1,2,3],'to_id'=>]
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxMoveContent(Request $request){
        $res = DB::table($request->mod)->whereIn('id',$request->ids)->update(['cate_id'=>$request->to_id]);
        if($res){
            return response()->json(['status'=>1,'msg'=>'移动成功']);
        }else {
            return response()->json(['status'=>0,'msg'=>'移动失败']);
        }
    }

    /**
     * 开启显示
     * @author zjf ${date}
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxShow(Request $request){
        $res = DB::table($request->mod)->whereIn('id',$request->ids)->update(['is_show'=>1]);
        if($res){
            return response()->json(['status'=>1,'msg'=>'开启成功']);
        }else {
            return response()->json(['status'=>0,'msg'=>'开启失败']);
        }
    }

    /**
     * 关闭显示
     * @author zjf ${date}
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxUnshow(Request $request){
        $res = DB::table($request->mod)->whereIn('id',$request->ids)->update(['is_show'=>0]);
        if($res){
            return response()->json(['status'=>1,'msg'=>'开启成功']);
        }else {
            return response()->json(['status'=>0,'msg'=>'开启失败']);
        }
    }

}