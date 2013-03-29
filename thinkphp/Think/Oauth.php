<?php
// +----------------------------------------------------------------------
// | TOPThink [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://topthink.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// $Id$
namespace Think;
// oauth登录接口
// <code>
// Oauth::connect(['oauth_type'=>'qq','app_key'=>'','app_secret'=>'','callback'=>'','authorize'=>'']); // 链接QQ登录
// Oauth::login(); // 跳转到授权登录页面 或者 Oauth::login($callbackUrl);
// Oauth::call('api','params'); // 调用API接口
// </code>
class Oauth {

    /**
     * 操作句柄
     * @var object
     * @access protected
     */
    static protected $handler  =    null;

    /**
     * 连接oauth
     * @access public
     * @param array $options  配置数组
     * @return object
     */
    static public function connect($options=[]) {
        $type   =   $options['oauth_type'];
        $class = 'Think\\Oauth\\Driver\\'.ucwords($type);
        if(class_exists($class)) {
            unset($options['oauth_type']);
            self::$handler = new $class($options);
            return self::$handler;
        }else{
            Error::halt('_CACHE_TYPE_INVALID_:'.$type);
        }
    }

    // 跳转到授权登录页面
    static public function login($callback=''){
        self::$handler->login($callback);
    }

    // 获取access_token
    static public function getAccessToken(){
        self::$handler->getAccessToken();
    }
    
    // 获取oauth用户信息
    static public function getOauthInfo(){
        return self::$handler->getOauthInfo();
    }

    // 获取oauth用户信息
    static public function getOpenId(){
        return self::$handler->getOpenId();
    }

    // 调用oauth接口API
    static public function call($api,$param='',$method='GET'){
        return self::$handler->call($api,$param,$method);
    }

}