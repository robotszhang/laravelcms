@extends("admin.include.mother")

@section("content")

    <div class="u-breadcrumb">
        <a class="back" href="javascript:history.back()" ><span class="fa fa-chevron-left"></span> 后退</a>
        <a class="back" href="javascript:window.location.reload()" ><span class="fa fa-repeat"></span> 刷新</a>
        <span class="name">新增留言</span>
    </div>
    <div class="h15"></div>

    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label><span class="text-danger">* </span>称呼</label>
            <div class="form-inline">
                <input type="text" class="form-control w400" name="nickname" placeholder="称呼" value="" />
            </div>
            <small class="form-text text-muted">1-100个字符</small>
        </div>
        <div class="form-group">
            <label><span class="text-danger">* </span>手机</label>
            <div class="form-inline">
                <input type="text" class="form-control w400" name="phone" placeholder="手机" value="" />
            </div>
            <small class="form-text text-muted"></small>
        </div>
        <div class="form-group">
            <label><span class="text-danger">* </span>留言内容</label>
            <div class="form-inline">
                <textarea class="form-control w600" name="body"></textarea>
            </div>
            <small class="form-text text-muted"></small>
        </div>
        <div class="form-group">
            <label>留言时间</label>
            @component('admin.component.picker_datetime',['input_name'=>'created_at','input_value'=>date('Y-m-d H:i',time()-300)]) @endcomponent
            <small class="form-text text-muted"></small>
        </div>
        <div class="form-group">
            <label>留言回复</label>
            <div class="form-inline">
                <textarea class="form-control w600" name="response"></textarea>
            </div>
            <small class="form-text text-muted"></small>
        </div>
        <div class="form-group">
            <label>回复时间</label>
            @component('admin.component.picker_datetime',['input_name'=>'responsed_at','input_value'=>date('Y-m-d H:i')]) @endcomponent
            <small class="form-text text-muted"></small>
        </div>
        <div class="form-group">
            <label>是否显示</label>
            <div>
                @if(isset($page->is_show) && $page->is_show == 0)
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="is_show1" name="is_show" class="custom-control-input" value="1">
                        <label class="custom-control-label" for="is_show1">显示</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="is_show2" name="is_show" class="custom-control-input" value="0" checked>
                        <label class="custom-control-label" for="is_show2">关闭</label>
                    </div>
                @else
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="is_show1" name="is_show" class="custom-control-input" value="1" checked>
                        <label class="custom-control-label" for="is_show1">显示</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="is_show2" name="is_show" class="custom-control-input" value="0">
                        <label class="custom-control-label" for="is_show2">关闭</label>
                    </div>
                @endif
            </div>
        </div>
        <button type="submit" class="btn btn-primary" onclick="return post_create()">保存</button>
    </form>


    <script type="text/javascript">
        //提交编辑
        function post_create(){
            var data = $('form').serializeObject();
            $.ajax({
                type:'post',
                url:'/admin/guestbook/create',
                data:data,
                success:function(res){
                    if(res.status == 0){
                        $boot.warn({text:res.msg},function(){
                            $('input[name='+res.field+']').focus();
                        });
                    }else{
                        $boot.success({text:res.msg},function(){
                            window.location = "/admin/guestbook";
                        });
                    }
                }
            })
            return false;
        }
    </script>

@endsection
