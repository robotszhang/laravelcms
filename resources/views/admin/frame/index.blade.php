@extends('admin.include.mother_frame')

@section('content')
    <div class="lay_default_left">
        <h1 class="m-frame-logo"><a href="/admin/"><img src="/resources/admin/images/logo.png" /></a></h1>
        @foreach($menus as $vo)
            <div class="m-frame-sidenav">
                <ul>
                    @foreach($vo['children'] as $voo)
                        <li class="on">
                            <a class="item">
                                <span class="icon"></span>
                                {{$voo['name']}}
                                <span class="arrow arrow-1 fa fa-chevron-down"></span>
                                <span class="arrow arrow-2 fa fa-chevron-up"></span>
                            </a>

                            {{--<a href="#" class="item" data-title="{{$voo['name']}}" url="{{$voo['url']}}" url_md5="{{md5($voo['url'])}}">--}}
                            {{--<span class="icon"></span>--}}
                            {{--{{$voo['name']}}--}}
                            {{--</a>--}}
                            @if($voo['children'])
                                <div class="handle">
                                    <dl>
                                        @foreach($voo['children'] as $vooo)
                                            <dd><a title="{{$vooo['name']}}" data-title="{{$vooo['name']}}" url="{{$vooo['url']}}" url_md5="{{md5($vooo['url'])}}">- {{$vooo['name']}}</a></dd>
                                        @endforeach
                                    </dl>
                                    <div class="clear"></div>
                                </div>
                            @endif
                        </li>
                    @endforeach
                </ul>

                <div class="clear"></div>
            </div>
        @endforeach

        <div class="g-vision">{{date('Y')}}© {{$config['sitename'] or ''}}</div>
    </div>


    <div class="lay_default_right">
        <div class="m-frame-top">

            <div class="m-frame-nav">
                <ul>
                    @foreach($menus as $menu)
                        <li>
                            {{$menu['name']}}
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="user">
                <span>{{$admin->name}}</span>，欢迎登录！&nbsp;&nbsp;&nbsp;&nbsp;
                <a class="text-primary" href="/admin/logout">退出</a>
            </div>
            <div class="clear"></div>
        </div>
        <div class="lay_default_right_con">
            <div class="m-frame-tab">
                <div class="prev">‹</div>
                <div class="next">›</div>
                <div class="contain_wrap">
                    <div class="contain">
                        <ul><li class="on" url_md5="{{md5('http://baidu.com')}}">
                                <a class="refresh" href="#"></a>
                                <span class="title">首页</span>
                            </li></ul>
                    </div>
                </div>
            </div>
            <div class="iframe_wrap">
                <iframe name="{{md5('http://baidu.com')}}" src="http://baidu.com"></iframe>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function reset_frame()
        {
            var h = $(window).height();
            $(".lay_default_left,.lay_default_right").css({height:h});
            $(".lay_default_right_con").css({height:h-80});
            $(".lay_default_right_con .iframe_wrap,.lay_default_right_con .iframe_wrap iframe").css({height:h-80});
            //$(".lay_default_left").mCustomScrollbar();
        }

        reset_frame();

        $(window).resize(function () {
            reset_frame();
        });

        //一二级菜单切换
        $(".m-frame-nav ul li").eq(0).addClass('on');
        $(".m-frame-sidenav").hide().eq(0).show();
        $(".m-frame-nav ul li").click(function(){
            var num = $(".m-frame-nav ul li").index(this);
            $(".m-frame-nav ul li").removeClass('on')
            $(this).addClass('on');
            $(".m-frame-sidenav").hide().eq(num).show();
        });

        //判断是否已存在iframe
        function exist_iframe(url_md5){
            if($('.lay_default_right_con').find('iframe').filter('iframe[name='+url_md5+']').length>0){
                return true;
            }
            return false;
        }
        //指定菜单切换
        function menu_on(url_md5){
            $('.m-frame-sidenav ul li .handle dd').removeClass('on');
            $('.m-frame-sidenav ul li .handle dd a').filter('a[url_md5='+url_md5+']').parent().addClass('on');
            var $nav_index = $('.lay_default_left .m-frame-sidenav').index($('.m-frame-sidenav ul li .handle dd a').filter('a[url_md5='+url_md5+']').parents('.m-frame-sidenav'));
            $(".m-frame-nav ul li").removeClass('on').eq($nav_index).addClass('on');
            $(".m-frame-sidenav").hide().eq($nav_index).show();
        }
        //指定iframe切换
        function iframe_on(url_md5){
            $('.m-frame-tab .contain ul li').removeClass('on').filter('li[url_md5='+url_md5+']').addClass('on');
            $('.lay_default_right_con').find('iframe').css({left:-9999}).filter('iframe[name='+url_md5+']').css({left:0});
        }
        //弹出内部选项卡
        function alert_iframe(title,url,url_md5){
            menu_on(url_md5);

            var $iframe_contain = $(".lay_default_right_con .iframe_wrap");
            //判断是否已存在iframe
            if(exist_iframe(url_md5)){
                //$(".m-frame-tab .contain ul li[url_md5="+url_md5+"]").find('.title').click();
                $('.lay_default_right_con').find('iframe').filter('iframe[name='+url_md5+']').attr({'src':url});
                setTimeout(function(){
                    iframe_on(url_md5);
                },200);
                return false;
            }

            $('.lay_default_right_con').find('iframe').css({left:-9999});
            var newwin = $('<iframe name="'+url_md5+'" src="'+url+'"></iframe>');
            newwin.prependTo($iframe_contain);
            reset_frame();
            $('.m-frame-tab .contain ul li').removeClass('on');
            $('<li class="on" url_md5="'+url_md5+'"><span class="title">'+title+'</span><a class="refresh" href="#"></a><a class="close-btn">×</a></li>').appendTo('.m-frame-tab .contain ul');
            return false;
        }
        (function(){
            //打开新iframe
            $(".m-frame-sidenav ul li .handle dd a").click(function(){
                var title = $(this).attr('data-title'),url = $(this).attr('url'),url_md5 = $(this).attr('url_md5');
                window.alert_iframe(title,url,url_md5);
                return false;
            });
            //iframe切换
            $(".m-frame-tab .contain ul").delegate('li span.title','click',function(){
                var url_md5 = $(this).parent().attr('url_md5');
                iframe_on(url_md5);
                menu_on(url_md5);
            });
            //关闭iframe
            $(".m-frame-tab .contain ul").delegate('li a.close-btn','click',function(){
                var url_md5 = $(this).parent().attr('url_md5');
                $('.lay_default_right_con').find('iframe').filter('iframe[name='+url_md5+']').remove();
                $(this).parent().remove();
                var num = $('.m-frame-tab .contain ul li').filter('.on').length;
                if(num == 0){
                    $('.m-frame-tab .contain ul li').last().find('.title').click();
                }
            });
        })();

        //菜单滑动
        (function(){
            var scroll_left=0,$prev = $(".m-frame-tab .prev"),$next = $(".m-frame-tab .next"),$ul = $(".m-frame-tab .contain ul");
            //根据li的个数计算宽度
            function count_width(num){
                var w = 0;
                $('.m-frame-tab .contain ul li').each(function(){
                    w += $(this).outerWidth();
                });
                return w;
            }
            //判断是否可以右滑
            function is_next(){
                var contain_width = $(".m-frame-tab .contain").width();
                if(count_width()+scroll_left>contain_width){
                    return true;
                }
                return false;
            }
            //判断是否可以左滑
            function is_prev(){
                if(scroll_left < 0){
                    return true;
                }
                return false;
            }
            //计算点击向右-滑动距离
            function count_next(){
                var contain_width = $(".m-frame-tab .contain").width();
                if(count_width()-Math.abs(scroll_left)>contain_width){
                    return contain_width;
                }else{
                    return count_width()-Math.abs(scroll_left);
                }
            }
            //计算点击向左-滑动距离
            function count_prev(){
                var contain_width = $(".m-frame-tab .contain").width();
                if(Math.abs(scroll_left) > contain_width){
                    return contain_width;
                }else{
                    return Math.abs(scroll_left);
                }
            }

            $prev.click(function(){
                if(is_prev()){
                    scroll_left = scroll_left+count_prev();
                    $ul.animate({left:scroll_left},250);
                }
            });

            $next.click(function(){
                //$boot.success({text:count_width()});
                if(is_next()){
                    scroll_left = scroll_left-count_next();
                    $ul.animate({left:scroll_left},250);
                }
            });
        })();
        //iframe刷新
        $(".m-frame-tab .contain ul").delegate('li a.refresh','click',function(){
            var url_md5 = $(this).parent().attr('url_md5');
            var url = $("iframe[name="+url_md5+"]").attr('src');
            $("iframe[name="+url_md5+"]")[0].contentWindow.location.replace(url);
            return false;
        });

        //左侧菜单收缩效果
        $(".m-frame-sidenav ul li").click(function(){
            if($(this).hasClass("on")){
                $(this).removeClass('on');
                $(this).find('.arrow').addClass('am-icon-angle-down').removeClass('am-icon-angle-up');
            }else{
                $(this).addClass('on');
                $(this).find('.arrow').addClass('am-icon-angle-up').removeClass('am-icon-angle-down');
            }
        });


        //$('.m-frame-sidenav_control').addClass('am-icon-toggle-off');
        //$(".m-frame-sidenav ul li").removeClass('on');
        //$('.arrow').addClass('am-icon-angle-down');

        //控制左侧菜单统一打开或收起
        /*$(".m-frame-sidenav_control").click(function(){
            if($(this).is('.am-icon-toggle-off')){
                $menu_opened = 1;
                $(this).attr('title','展开所有');
                $(".m-frame-sidenav ul li").addClass('on');
                $(this).removeClass('am-icon-toggle-off').addClass('am-icon-toggle-on');
            }else{
                $menu_opened = 9;
                $(this).attr('title','收起所有');

                $(".m-frame-sidenav ul li").removeClass('on');
                $(this).removeClass('am-icon-toggle-on').addClass('am-icon-toggle-off');
            }

            _ajax('/admin/ajax/update', {
                mod : 'User',
                id : '123',
                menu_opened : $menu_opened
            }, function (data) {


            });
        });*/
    </script>

@stop
