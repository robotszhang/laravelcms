@extends("admin.include.mother")

@section("content")

    <div class="clearfix">
        <div class="float-left">
            <div class="u-breadcrumb">
                <a class="back" href="javascript:window.location.reload();" ><span class="fa fa-repeat"></span> 刷新</a>
                <span class="name">管理员</span>
            </div>
        </div>
        <div class="float-right">
            <a role="button" class="btn btn-sm btn-primary" href="{{url('/admin/manager_user/create')}}"><i class="fa fa-plus"></i> 新增管理员</a>
        </div>
    </div>
    <div class="h15"></div>


    <table class="table table-hover">

        <tr>
            <th>ID</th>
            <th>用户名称</th>
            <th>账号</th>
            <th>关联角色</th>
            <th>最后更新</th>
            <th>操作</th>
        </tr>

        @foreach($list as $vo)
            <tr>
                <td>{{$vo->id}}</td>
                <td>{{$vo->name}}</td>
                <td>{{$vo->account}}</td>
                <td>
                    @foreach($vo->roles as $voo)
                        <span class="badge badge-pill badge-secondary">{{$voo->name}}</span>
                    @endforeach

                </td>
                <td>{{$vo->updated_at}}</td>
                <td>
                    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                        <a class="btn btn-sm btn-outline-secondary" href="{{url('/admin/manager_user/edit?id='.$vo['id'])}}" role="button"><i class="fa fa-edit"></i> 编辑</a>
                        <a class="btn btn-sm btn-outline-secondary" href="#" role="button" onclick="return alert_powers('{{$vo['name']}}',{{$vo['id']}})"><i class="fa fa-empire"></i> 权限</a>
                        <div class="btn-group" role="group">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                更多
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" onclick="return del_user({{$vo['id']}});"><i class="fa fa-trash"></i>删除</a>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach

    </table>

    <div id="permission" class="hide">
        <div class="js-permission-con">
            权限
        </div>
    </div>

    <script>
        //显示用户权限
        function alert_powers(name,id){
            $.ajax({
                type:'post',
                url:'/admin/manager_user/ajax_page_powers',
                data:{id:id},
                success:function(res){
                    if(res.status == 0){
                        $boot.warn({text:res.msg});
                    }else{
                        $('.js-permission-con').html(res.body);
                        $boot.win({id:'#permission',size:'lg',title:name+'的权限'});
                    }
                }
            });
            return false;
        }

        //删除角色
        function del_user(id){
            $boot.confirm({text:'确认删除该角色？'},function(){
                if(!id){
                    $boot.warn({text:'删除参数出错'});
                    return false;
                }
                $.ajax({
                    type:'post',
                    url:'/admin/manager_user/ajax_del',
                    data:{id:id},
                    success:function(res){
                        if(res.status == 0){
                            $boot.warn({text:res.msg});
                        }else{
                            $boot.success({text:res.msg},function(){
                                window.location = window.location;
                            });

                        }
                    }
                });
            });
            return false;
        }
    </script>

@endsection