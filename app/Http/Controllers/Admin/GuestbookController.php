<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Guestbook;
use Validator;

/**
 * 在线留言控制器
 * @author my 2017-10-25
 * Class MenuController
 * @package App\Http\Controllers\Admin
 */
class GuestbookController extends BaseController
{

    /**
     * 菜单列表
     * @author my  2017-10-25
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request){
        $sign['list'] = Guestbook::orderBy('id','desc')->paginate(15);
        return view('admin/guestbook/index', $sign);
    }


    /**
     * 新增留言
     * @author zjf ${date}
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function create(Request $request){
        if($request->isMethod('post')){
            $rule = [
                'nickname' => 'required|between:1,100',
                'phone' => ['required','regex:/^1[34578][0-9]{9}$/'],
                'body' => 'required',
            ];

            $request->title_sub && $rule['title_sub'] ='between:1,100';
            $request->keywords && $rule['keywords'] ='between:1,100';
            $request->description && $rule['description'] ='between:1,500';

            $message = [
                'required' => ':attribute不能为空',
                'nickname.between' => ':attribute字符长度1-100',
                'regex' => ':attribute格式不正确',
            ];
            $replace = [
                'nickname' => '昵称',
                'phone' => '手机',
                'body' => '留言内容',
            ];

            $validator = Validator::make($request->all(),$rule,$message,$replace);
            if ($validator->fails()){
                $a = $validator->errors()->toArray();

                foreach($a as $k => $v){
                    $data['field'] = $k;
                    $data['msg'] = $v[0];
                    break;
                }
                return response()->json(['status'=>0,'msg'=>$data['msg'],'field'=>$data['field']]);
            }
            $data['nickname'] = $request->nickname;
            $data['phone'] = $request->phone;
            $data['body'] = $request->body;
            $data['created_at'] = strtotime($request->created_at);
            $data['response'] = $request->response;
            $data['responsed_at'] = strtotime($request->responsed_at);
            $data['is_show'] = $request->is_show;
            $res = Guestbook::create($data);
            if($res){
                return response()->json(['status'=>1,'msg'=>'添加成功']);
            }else{
                return response()->json(['status'=>1,'msg'=>'添加失败']);
            }

        }else{

            return view('admin/guestbook/create');
        }

    }

    /**
     * 编辑留言
     * @author zjf ${date}
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function edit(Request $request){
        if($request->isMethod('post')){
            $rule = [
                'nickname' => 'required|between:1,100',
                'phone' => ['required','regex:/^1[34578][0-9]{9}$/'],
                'body' => 'required',
            ];

            $request->title_sub && $rule['title_sub'] ='between:1,100';
            $request->keywords && $rule['keywords'] ='between:1,100';
            $request->description && $rule['description'] ='between:1,500';

            $message = [
                'required' => ':attribute不能为空',
                'nickname.between' => ':attribute字符长度1-100',
                'regex' => ':attribute格式不正确',
            ];
            $replace = [
                'nickname' => '昵称',
                'phone' => '手机',
                'body' => '留言内容',
            ];

            $validator = Validator::make($request->all(),$rule,$message,$replace);
            if ($validator->fails()){
                $a = $validator->errors()->toArray();

                foreach($a as $k => $v){
                    $data['field'] = $k;
                    $data['msg'] = $v[0];
                    break;
                }
                return response()->json(['status'=>0,'msg'=>$data['msg'],'field'=>$data['field']]);
            }
            $data['nickname'] = $request->nickname;
            $data['phone'] = $request->phone;
            $data['body'] = $request->body;
            $data['created_at'] = strtotime($request->created_at);
            $data['response'] = $request->response;
            $data['responsed_at'] = strtotime($request->responsed_at);
            $data['is_show'] = $request->is_show;
            $res = Guestbook::where('id',$request->id)->update($data);
            if($res){
                return response()->json(['status'=>1,'msg'=>'编辑成功']);
            }else{
                return response()->json(['status'=>1,'msg'=>'编辑失败']);
            }

        }else{
            $sign['page'] = Guestbook::find($request->id);
            return view('admin/guestbook/edit',$sign);
        }

    }

    /**
     * 删除留言
     * @author my  2017-10-25
     * @param Request $request 请求
     * @return array
     */
    /*public function ajaxDel(Request $request){
        $res = Guestbook::whereIn('id',$request->ids)->delete();
        if($res){
            return ['status'=>1,'msg'=>'删除成功'];
        }else {
            return ['status'=>0,'msg'=>'删除失败'];
        }
    }*/


}