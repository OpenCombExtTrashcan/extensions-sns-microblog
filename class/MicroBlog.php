<?php

// +----------------------------------------------------------------------
// | WeiBo 
// +----------------------------------------------------------------------
// | Copyright (c) 2011 http://www.sunmy.com.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.X )
// +----------------------------------------------------------------------
// | Author: luwei <solver.lu@gmail.com>
// +----------------------------------------------------------------------
// 1.0.0.1 

namespace oc\ext\microblog;

//调用共通类
use jc\mvc\model\db\orm\ModelAssociationMap;    //
use jc\db\DB;                                   //
use jc\db\PDODriver;                            //
use oc\ext\Extension;                           //

/**
 *   微博配置类
 *   @package    microblog
 *   @author     luwei
 *   @created    2011-06-28
 *   @history     
 */
class MicroBlog extends Extension {

    /**
     *    加载方法
     *    @param      null
     *    @package    microblog 
     *    @return     null
     *    @author     luwei
     *    @created    2011-06-28
     */
    public function load() {
        //模型关系实例
        $aAssocMap = ModelAssociationMap::singleton();
        //microblog模型关系
        $aAssocMap->addOrm(
                array(
                    'keys' => 'mbid', //主键
                    'table' => 'microblog', //模型名称                                    
                    
                    'belongsTo' => array(
                        //与user关系
                        array(
                            'prop' => 'userto', //属性名
                            'fromk' => 'uid', //主键
                            'tok' => 'uid', //外键
                            'model' => 'coreuser:user'  //模型名称
                        ),
                    ), 
                    'hasAndBelongsToMany' => array(
                        //与user关系
                        array(
                            'prop' => 'coreuser:user', //属性名
                            'fromk' => 'mbid', //主键
                            'btok' => 'mbid', //外键
                            'bfromk' => 'at_uid', //从主键
                            'tok' => 'uid', //从外键
                            'bridge' => 'at', //从模型名称
                            'model' => 'coreuser:user', //模型名称
                        ),
                        //与tag关系
                        array(
                            'prop' => 'tag', //属性名
                            'fromk' => 'mbid', //主键
                            'btok' => 'mbid', //外键
                            'bfromk' => 'mbtid', //从主键
                            'tok' => 'mbtid', //从外键
                            'bridge' => 'mb_link', //从模型名称
                            'model' => 'mb_tag', //模型名称
                        )
                    ),
                )
        );
        
        //tag模型关系
        $aAssocMap->addOrm(
                array(
                    'keys' => 'mbtid', //主键
                    'table' => 'mb_tag', //模型名称
                    
                    'hasAndBelongsToMany' => array(
                        //与microblog关系
                        array(
                            'prop' => 'microblog', //属性名
                            'fromk' => 'mbtid', //主键
                            'btok' => 'mbtid', //外键
                            'bfromk' => 'mbid', //从主键
                            'tok' => 'mbid', //从外键
                            'bridge' => 'mb_link', //从模型名称
                            'model' => 'microblog', //模型名称
                        )
                    ),
                )
        );        
        
        
        //加载微博列表控制器
        $this->application()->accessRouter()->addController("oc\\ext\\microblog\\MicroBlogList",'MicroBlogList');
        
        //加载微博发布控制器
        $this->application()->accessRouter()->addController("oc\\ext\\microblog\\MicroBlogAdd",'MicroBlogAdd');
        
        //加载微博删除控制器
        $this->application()->accessRouter()->addController("oc\\ext\\microblog\\MicroBlogDelete",'MicroBlogDelete');
    }

}

?>