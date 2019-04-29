//
//  QF.js
//
//  Created by qianfan on 2015/04/09.
//  Copyright (c) 2015年 qianfan. All rights reserved.
//  Version 1.0.
//

var QF = QF || {};

/**
 *  获取从app返回的json数据接口
 *
 *  @param json  JSON格式数据：{method:'getLoginUserInfo',params:{uid:123,username:'test'}}
 *
 *  @return <#return value description#>
 */
QF.getNativeData = function(json){
    QF[json.method](json.params);
};

/**
 *  后续扩展中
 */