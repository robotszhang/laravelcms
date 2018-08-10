@extends("admin.include.mother")

@section("content")

    <div class="clearfix">
        <div class="float-left">
            <div class="u-breadcrumb">
                <a class="back" href="javascript:window.location.reload()" ><span class="fa fa-repeat"></span> 刷新</a>
                <span class="name">客户留言</span>
            </div>
        </div>
        <div class="float-right">
            <a href="{{url('/admin/guestbook/create')}}" role="button" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> 新增留言</a>
        </div>
    </div>
    <div class="h10"></div>

    <table class="table table-bb">

        <tr>
            <th>ID</th>
            <th>称呼</th>
            <th>留言内容</th>
            <th>电话</th>
            <th>留言时间</th>
            <th>是否显示</th>
            <th>操作</th>
        </tr>

        @foreach($list as $vo)
            <tr>
                <td>{{$vo->id}}</td>
                <td>
                    {{$vo->nickname}}
                </td>
                <td>
                    {{$vo->body}}
                </td>
                <td>
                    {{$vo->phone}}
                </td>
                <td>
                    {{$vo->created_at->format('Y-m-d H:i')}}
                </td>
                <td>
                    @if($vo->is_show == 0)
                        <span class="badge badge-secondary">关闭</span>
                    @else
                        <span class="badge badge-success">显示</span>
                    @endif
                </td>
                <td>
                    <a class="btn btn-sm btn-outline-secondary" href="/admin/guestbook/edit?id={{$vo->id}}" role="button"><i class="fa fa-edit"></i> 编辑</a>
                    <div class="btn-group" role="group">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            更多
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#" onclick="return del_menu('{{$vo->id}}')"><i class="fa fa-trash"></i> 删除</a>
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach

    </table>
    {{$list->links()}}

    <script>
        //删除
        function del_menu(id){
            $boot.confirm({text:'确认删除当前留言？'},function(){
                if(!id){
                    $boot.warn({text:'删除参数出错'});
                    return false;
                }
                $.ajax({
                    type:'post',
                    url:'/admin/guestbook/ajax_del',
                    data:{mod:'guestbook',ids:[id]},
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