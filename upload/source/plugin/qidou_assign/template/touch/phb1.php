<?php exit; ?>
<!DOCTYPE html>
<html>
<head>
    <meta name="save" content="history" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0, user-scalable=no">
    <meta name="format-detection" content="telephone=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="blank" />
    <meta http-equiv="Content-Type" content="text/html; charset={$_G['charset']}" />
    <link rel="stylesheet" href="{$assetsBaseUrlPath}/css/style2.css" />
    <script type="text/javascript" src="{$assetsBaseUrlPath}/js/appbyme.js"></script>
    <title>{lang qidou_assign:phb}</title>
     <script>
       connectAppbymeJavascriptBridge(function(bridge){
          var json ={
            button1:{//右侧数第一个位置，与more二选一
                title:'{lang qidou_assign:refresh}',
                type:'refresh',
                url:''
            }
        }
        AppbymeJavascriptBridge.customButton(JSON.stringify(json));
    });
    
        init_rem();
        function init_rem(){
            var iw = 750;
            var w = window.innerWidth;
            if(w>375){
                w = 375;
            }
            var irate= 625/(iw/w);
            if(irate > 298.3333333333333){
                irate = 288.3333333333333;
            }
            var str = 'html{font-size:' + irate + '%' + '}';
            var h_style = document.createElement("style");
            h_style.setAttribute("type", "text/css");
            h_style.innerHTML = str;
            document.getElementsByTagName('head')[0].appendChild(h_style);
        }
    
    </script>
  <script type="text/javascript" src="{$assetsBaseUrlPath}/js/jquery-1.8.3.min.js"></script>
</head>
<body>
<div class="page_top">
  
    <div class="header clearfix">
        <p class="qdw" onclick="window.location='{$_G['siteurl']}plugin.php?id=qidou_assign&act=phb';" style="color: rgb(255, 102, 51);">{lang qidou_assign:jrph}</p>
        <p class="zfy" onclick="window.location='{$_G['siteurl']}plugin.php?id=qidou_assign&act=phb1';">{lang qidou_assign:zph}</p>

        <!--三角箭头-->
        <div class="triangle"></div>
    </div>
  
    <!--4个区域-->
    <div class="top_box" style="padding-bottom: 10px;">
                <div class="qdw_con pub pub-3">
            <div class="top_title">
                <!--<p>累计签到排行</p>-->
                <p><img src="{$assetsBaseUrlPath}/images/qdw_font.png" alt=""></p>
                <div class="top_tip">{lang qidou_assign:zhu}</div>
            </div>
            <div class="top_box">
                <!--前三名-->
                  <ul class="before_3">
                    <!--{if $arr1 }-->  
                    <li class="one">
                        <p class="line_jbl"></p>
                        <p class="line_jbr"></p>
                        <p class="user_order">1</p>
                        <div class="user_header" onclick="AppbymeJavascriptBridge.userCenter({$arr1['uid']});">
                            <img src="{$_G['setting']['ucenterurl']}/avatar.php?uid={$arr1['uid']}" />
                        </div>
                        <p class="user_name">{$arr1['username']}</p>
                        <p class="user_hb"><span>{$arr1['totaltian']}</span>&nbsp;<span>{lang qidou_assign:t}</span></p>
                    </li>
                     <!--{else}-->
                     <p style="font-size: 18px; text-align: center; padding: 80px 0px; font-family: '微软雅黑';"> {lang qidou_assign:myqd}</p>
                     <!--{/if}--> 
                     <!--{if $arr2 }-->
                    <li class="two">
                        <p class="user_order">2</p>
                        <div class="user_header" onclick="AppbymeJavascriptBridge.userCenter({$arr2['uid']});">
                            <img src="{$_G['setting']['ucenterurl']}/avatar.php?uid={$arr2['uid']}" />
                        </div>
                        <p class="user_name">{$arr2['username']}</p>
                        <p class="user_hb"><span>{$arr2['totaltian']}</span>&nbsp;<span>{lang qidou_assign:t}</span></p>
                    </li>
                     <!--{/if}--> 
                  <!--{if $arr3 }-->
                    <li class="three">
                        <p class="user_order">3</p>
                        <div class="user_header" onclick="AppbymeJavascriptBridge.userCenter({$arr3['uid']});">
                            <img src="{$_G['setting']['ucenterurl']}/avatar.php?uid={$arr3['uid']}" />
                        </div>
                        <p class="user_name">{$arr3['username']}</p>
                        <p class="user_hb"><span>{$arr3['totaltian']}</span>&nbsp;<span>{lang qidou_assign:t}</span></p>
                    </li>
                    <!--{/if}--> 
                  </ul>
                                              
                <ul class="all_top">        
                    <!--{if $record }-->
                    <!--{loop $record $key $val}-->
                    <li class="clearfix">
                                <div class="fl clearfix">
                                    <p class="fl user_order">{$key}</p>
                                    <p class="fl user_header" onclick="AppbymeJavascriptBridge.userCenter({$val['uid']});"><img src="{$_G['setting']['ucenterurl']}/avatar.php?uid={$val['uid']}&size=small" /></p>
                                </div>
                                <div class="fr clearfix">
                                    <p class="fl user_name">{$val['username']}</p>
                                    <p class="fr user_hb clearfix"><span>{$val['totaltian']}</span><span>{lang qidou_assign:t}</span></p>
                                </div>
                  </li>
                 <!--{/loop}-->             
                  <!--{/if}-->                  
                          </ul>
                                <!--我的排名-->
                                <!--{if $my }-->
                                <ul class="me_top">
                                        <li>
                                            <div class="fl clearfix">
                                                <p class="fl user_order">{$my['num']}</p>
                                                <p class="fl user_header" onclick="QFH5.jumpUser(2487595);"><img src="{$_G['setting']['ucenterurl']}/avatar.php?uid={$my['data']['uid']}&size=small" /></p>
                                            </div>
                                            <div class="fr clearfix">
                                                <p class="fl user_name">{$my['data']['username']}</p>
                                                <p class="fr user_hb clearfix"><span>{$my['data']['totaltian']}</span><span>{lang qidou_assign:t}</span></p>
                                            </div>
                                        </li>
                                    </ul>
                                    <!--{/if}-->    
                            </div>
        </div>
                                <!--        <p class="h_bottom">注：该排行榜每1小时更新一次</p>-->
    </div>
</div>
    <script>
        
    $(function(){
           
            $('.triangle').css({'left':'75%'});
            $('.qdw,.zfy,.zjw').css('color','#666');
             $('.zfy').css('color','#FF6633');
    });
    </script>
</body>
</html>
