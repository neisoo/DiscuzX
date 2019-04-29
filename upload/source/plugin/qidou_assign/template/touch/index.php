<?php exit; ?>
<!DOCTYPE html>
<html>
    <head>
        <meta content="text/html;charset=UTF-8" http-equiv="Content-Type"/>
        <!-- Mobile Devices Support @begin -->
        <meta content="no-cache,must-revalidate" http-equiv="Cache-Control"/>
        <meta content="no-cache" http-equiv="pragma"/>
        <meta content="0" http-equiv="expires"/>
        <meta content="telephone=no, address=no" name="format-detection"/>
        <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
        <meta name="apple-mobile-web-app-capable" content="yes"/>
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
        <!-- Mobile Devices Support @end -->
        <title>{lang qidou_assign:qdt}</title>
        <link href="{$assetsBaseUrlPath}/css/style.css" rel="stylesheet">
        <link rel="stylesheet" href="{$assetsBaseUrlPath}/css/swipe.css" />
        <script type="text/javascript" src="{$assetsBaseUrlPath}/js/QF.js"></script>
        <script type="text/javascript" src="{$assetsBaseUrlPath}/js/jquery-1.8.3.min.js"></script>
        <script type="text/javascript" src="{$assetsBaseUrlPath}/js/swipeSlider.js"></script>
        <script type="text/javascript" src="{$assetsBaseUrlPath}/js/common.js"></script>
        <script type="text/javascript" src="{$assetsBaseUrlPath}/js/script.js"></script>
        <script type="text/javascript" src="{$assetsBaseUrlPath}/js/main.js"></script>
        <script type="text/javascript" src="{$assetsBaseUrlPath}/js/appbyme.js"></script>
        <script>
            connectAppbymeJavascriptBridge(function (bridge) {
                var json = {
                    button1: {//右侧数第一个位置，与more二选一
                        title: '{lang qidou_assign:refresh}',
                        type: 'refresh',
                        url: ''
                    }
                }
                AppbymeJavascriptBridge.customButton(JSON.stringify(json));
            });
        </script>
        <style>
            .back{
                height:50px; 
                line-height: 50px;
                background: red;
                color: #fff;
                text-align: center;
            }
            .back a{color: #fff; position: absolute; left: 20px; line-height: 50px;}
            .back span{display: inline-block; font-size: 20px; }
        </style>
    </head>
    <body>
    <body>
        <div class="page_signin-2">
          
            <!--{if $isapp != 1}-->
                <div class='back' <!--{if $config['top_color']}-->style="background: {$config['top_color']};"<!--{/if}-->>
                    <a href="javascript:;" onclick="javascript:history.back(-1);"  <!--{if $config['text_color']}-->style="color: {$config['text_color']};"<!--{/if}-->>&lt;</a> <span  <!--{if $config['text_color']}-->style="color: {$config['text_color']};"<!--{/if}-->>{lang qidou_assign:qdt}</span>
                </div>   
            <!--{/if}-->
            <div class="header">
                <!-- 去排行榜 -->
                <a href="{$_G['siteurl']}plugin.php?id=qidou_assign&act=phb" class="box_tophb">
                    <p class="to_phbtext"><img src="{$assetsBaseUrlPath}/images/img_tophb.png" alt=""></p>
                    <div>
                        <p class="gold_body">
                            <img src="{$assetsBaseUrlPath}/images/gold_body.png" alt="" >
                        </p>
                        <p class="gold_hand">
                            <img src="{$assetsBaseUrlPath}/images/gold_hand.png" alt="" >
                        </p>
                    </div>
                </a>
                <div class="header_text">
                    <p class="text">{lang qidou_assign:qdcg}</p>
                    <p class="signin_days">{lang qidou_assign:lxqd}<span>{$dates['liantian']}</span>{lang qidou_assign:t}</p>
                </div>
                <p class="sign_rule">{lang qidou_assign:rules}</p>
            </div>
            <!--广告位-->
            
            <!--{if $pics[0][0]}-->

            <div class="slider" id="slider_02">
                <ul>
                    <!--{loop $pics $key $val}--> 
                    <!--{if $val[0] && $val[1]}-->
                    <li data-index="0">
                        <a href="{$val[0]}" data-belongtype="3" data-belongid="0" data-url="{$val[0]}" data-belongname="">
                            <img src="{$val[1]}" alt="">
                        </a>
                    </li>
                    <!--{/if}-->
                    <!--{/loop}-->
                </ul>
                <div class="dot">
                    <span class="cur"></span>
                </div>
                <div class="number_index" style="display: none"></div>
            </div>
            
            <!--{/if}-->
            <!--日历-->
            <div class="signin_content">
                <div id="Demo">
                    <div id="CalendarMain">
                        <div id="title">
                            <a class="selectBtn month" href="javascript:;" onclick=""></a>
                            <p class="icon_lbook"></p>
                            <p class="icon_rbook"></p>
                            <p></p>
                            <div style="text-align: center;">
                                <a class="selectBtn selectYear" href="javascript:void(0)"></a>
                                <a class="selectBtn selectMonth"></a>
                            </div>
                            <a class="selectBtn currentDay" href="javascript:;" onClick=""></a>
                        </div>
                        <div id="context" <!--{if $config['c_color']}-->style="border:1px solid {$config['c_color']};"<!--{/if}-->>
                             <div class="week" <!--{if $config['c_color']}-->style="background: {$config['c_color']};"<!--{/if}-->>
                                <h3> {lang qidou_assign:seven} </h3>

                                <h3> {lang qidou_assign:one} </h3>

                                <h3> {lang qidou_assign:two} </h3>

                                <h3> {lang qidou_assign:three} </h3>

                                <h3> {lang qidou_assign:four} </h3>

                                <h3> {lang qidou_assign:five} </h3>

                                <h3> {lang qidou_assign:six} </h3>
                            </div>
                            <div id="center">
                                <div id="centerMain">
                                    <div id="selectYearDiv"></div>
                                    <div id="centerCalendarMain">
                                        <div id="Container"></div>
                                    </div>
                                    <div id="selectMonthDiv"></div>
                                </div>
                            </div>
                           
                    </div>
                </div>
                      <div class="all_signintext clearfix">
                                <p><span class="num count">{$dates['totaltian']}<label style="color: #666;font-size: 13px">{lang qidou_assign:t}</label></span><span>{lang qidou_assign:ljqd}</span></p>

                                <p><span class="num">{$day_num}<label style="color: #666;font-size: 13px">{lang qidou_assign:ren}</label></span><span>{lang qidou_assign:jrqd}</span></p>

                                <p><span class="num">{$zt_num}<label style="color: #666;font-size: 13px">{lang qidou_assign:ren}</label></span><span>{lang qidou_assign:zrqd}</span></p>
                            </div>
                                                    <!--补签-->
                            <div class="bq_box">
                                <p class="has_bq">{lang qidou_assign:nhy} <span style="color: red">{$dates['buqian']}</span> {lang qidou_assign:zbqk}</p>
                                <!--todo 文案-->
                                <!--<p class="text">您这个月已签满！太勤劳啦！</p>
                                <p class="text">您这个月已签x天！继续坚持！</p>-->
                                 <a href="javascript:void(0)" class="btn_bq" id="gmbqk">{lang qidou_assign:gmbqk}</a>
                              </div>
                        </div>
            </div>
            
            <div>
                <div class="goods_good">
                    <span class="title">{lang qidou_assign:tjhw}</span>
                    <ul class="clearfix">
                        <!--{loop $goods $key $val}-->
                            <!--{if $val[0] && $val[1] && $val[2] && $val[3]}-->
                            <li>   
                                <a href="{$val[3]}">
                                    <img src="{$val[1]}" alt="{$val[0]}" />
                                </a>
                                <p><a href="{$val[3]}">{$val[0]}</a></p>
                                <span class="orange">{$val[2]}</span> 
                            </li>
                            <!--{/if}-->
                        <!--{/loop}--> 
                    </ul>
                </div>
            </div>
            
            <!--{if $config['zgd'] ||  $config['qdh']}-->
            <div class="bottom clearfix">
                <P class="bottom-line"></P>
                <!--{if $config['zgd'] }-->
                <a href="{$config['zgd']}" class="app"><p class="left fl"><span style="">{lang qidou_assign:zgd}</span></p></a>
                <!--{/if}-->
                <!--{if $config['qdh'] }-->
                <a href="{$config['qdh']}" class="app"><p class="right fl"><span style="">{lang qidou_assign:qdh}</span></p></a>
                <!--{/if}-->
            </div>
            <!--{/if}-->
            <!--签到弹出框-->
            <div class="ok_signinbox"  <!--{if $mysign['sign'] == 1}-->style="display: none;"<!--{/if}-->>
                 <div class="ok_signin">
                    <img src="{$assetsBaseUrlPath}/images/ok_signin.png" alt="">
                    <p class="get_exper">{lang qidou_assign:gxhd}+{$gold}{$_G['setting']['extcredits'][$config['type']]['title']}</p>
                    <a class="btn_konw">{lang qidou_assign:zdl}</a>
                </div>
            </div>
            <!--todo 签到规则-->
            <div class="sign_rulebox">
                <div class="sign_rulecon">
                    <p class="title">{lang qidou_assign:rules}</p>
                    <p class="close"></p>
                    <ul>
                        <li>
                            {$config['rules']}
                        </li>
                    </ul>
                </div>
            </div>
            <!--购买补签卡-->
            <div class="dialog_usebqbox buy">
                <div class="dialog_usebq">
                    <p class="close"></p>
                    <div class="text">
                        <p>{lang qidou_assign:bqkgm}{$config['buqian']}{$_G['setting']['extcredits'][$config['type']]['title']}{lang qidou_assign:bqkgm1}</p>
                    </div>
                    <div class="btn clearfix">	
                        <a class="btn_remove">{lang qidou_assign:qx}</a>
                        <a class="btn_ok" id="ljgm">{lang qidou_assign:ljgm}</a>
                    </div>
                </div>
            </div>
            <!--使用补签卡-->
            <div class="dialog_usebqbox use">
                <div class="dialog_usebq">
                    <p class="close"></p>
                    <div class="text">
                        <p>{lang qidou_assign:sybqk}</p>
                    </div>
                    <div class="btn clearfix">
                        <a class="btn_remove">{lang qidou_assign:qx}</a>
                        <a class="btn_ok" id="qrsy">{lang qidou_assign:qrsy}</a>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" id="butian" />
        <script type="text/javascript">
            function QFH5ready() {
                QFH5.setMenu(1);
                QFH5.setRefresh(0);
                QFH5.shouldUpdateGoldLevel();
            }
            var assignedDays;
            var requesting = false;
            $(function () {
                // 签到成功弹框处理
                $('.btn_konw').click(function () {
                    $('.ok_signinbox').hide();
                });
                $(".ok_signinbox").delay(5000).slideUp(600);

                // 签到规则
                $('.sign_rule').click(function () {
                    $('.sign_rulebox').show();
                });
                $('.sign_rulecon .close').click(function () {
                    $('.sign_rulebox').hide();
                });

                // todo 关于推荐好物最后一个li的显示问题
                var gsLiLen = $('.goods_good > ul > li').length;
                if (gsLiLen % 2 == 1) {
                    $('.goods_good > ul > li').last();
                }

                // 创建日历表
                assignedDays = [[{$dates['date']}],[{$dates['bu_date']}]];
                CalendarHandler.initialize(assignedDays);
                $('.month').click(function () {
                    CalendarHandler.CalculateLastMonthDays(assignedDays);
                });
                $('.currentDay').click(function () {
                    CalendarHandler.CreateCurrentCalendar(assignedDays);
                });
            });
            $(document).ready(function () {
                //滑动原点消除
                var slider_length = $('.dot span').length;
                if (slider_length < 2) {
                    $('.dot').hide();
                }
            });
            $('.buy > .dialog_usebq > .close, .buy > .dialog_usebq > .btn > .btn_remove').click(function () {
                $('.buy').hide();
            });

            $('.use > .dialog_usebq > .close, .use > .dialog_usebq > .btn > .btn_remove').click(function () {
                $('.use').hide();
            });

            $(function () {
                var number_index = $(".number_index");
                $("#slider_02").swipeSlide({
                    continuousScroll: true,
                    autoSwipe: true,
                    speed: 4000,
                    axisX: true,
                    firstCallback: function (i, sum, me) {
                        me.find(".dot").children().first().addClass("cur");
                        number_index.html(parseInt(i + 1) + "/" + sum);

                    },
                    callback: function (i, sum, me) {
                        me.find(".dot").children().eq(i).addClass("cur").siblings().removeClass("cur");
                        number_index.html(parseInt(i + 1) + "/" + sum);
                    }
                });
            });
            $(function () {
                //check 补签卡
                $(document).on('click',function (event) { 
                    var target = event.target;
                    
                    if(target.className.indexOf('btnBq')!=-1 || target.parentNode.className.indexOf('btnBq') !=-1){
                       var bu = target.getAttribute("data");
                        if(bu){
                            $("#butian").val(bu);  
                        }else{
                            bu = target.firstChild.getAttribute("data");
                            $("#butian").val(bu); 
                        }
                        $.ajax({
                            type: 'POST',
                            url: "{$_G['siteurl']}plugin.php?id=qidou_assign",
                            data: {act: 'checkbq', formhash: '{FORMHASH}'},
                            dataType: 'json',
                            success: function (data) {
                                if (data.status == 1) {
                                    $('.buy').hide();
                                    $('.use').show();
                                } else {
                                    $('.use').hide();
                                    $('.buy').show();
                                }
                            }
                        });
                    }
                });
//                $('.btnBq a').click(function () { 
//                 
//                    var bu = $(this).attr('data');
//                     
//                    $("#butian").val(bu);
//                    $.ajax({
//                        type: 'POST',
//                        url: "{$_G['siteurl']}plugin.php?id=qidou_assign",
//                        data: {act: 'checkbq', formhash: '{FORMHASH}'},
//                        dataType: 'json',
//                        success: function (data) {
//                            if (data.status == 1) {
//                                $('.buy').hide();
//                                $('.use').show();
//                            } else {
//                                $('.use').hide();
//                                $('.buy').show();
//                            }
//                        }
//                    });
//                });
                $("#gmbqk").click(function(){
                    $('.use').hide();
                     $('.buy').show();
                });
                //购买补签卡
                $('#ljgm').click(function () {
                    $.ajax({
                        type: 'POST',
                        url: "{$_G['siteurl']}plugin.php?id=qidou_assign",
                        data: {act: 'buy', formhash: '{FORMHASH}'},
                        dataType: 'json',
                        success: function (data) {
                            if (data.status == 1) {
                                $('.buy').hide();
                                alert(data.msg);
                                location.reload();
                               // $('.use').show();
                            } else {
                                $('.buy').hide();
                                alert(data.msg);
                            }
                        }

                    });
                });
                //补签
                $("#qrsy").click(function () {
                    
                    var butian = $("#butian").val();
                    $.ajax({
                        type: 'POST',
                        url: "{$_G['siteurl']}plugin.php?id=qidou_assign",
                        data: {act: 'buqian', formhash: '{FORMHASH}', bu: butian},
                        dataType: 'json',
                        success: function (data) {
                            if (data.status == 1) {
                                location.reload();
                                $('.use').hide();
                                alert(data.msg);
                            } else {
                                $('.use').hide();
                                alert(data.msg);
                            }
                        }

                    });
                });
            })
        </script>
    </body>
</html>
