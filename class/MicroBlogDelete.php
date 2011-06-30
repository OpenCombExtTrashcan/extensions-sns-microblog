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
use jc\mvc\controller\Controller;               //控制器类
use oc\base\FrontFrame;                         //视图框架类
use jc\mvc\model\db\orm\ModelAssociationMap;    //模型关系类
use jc\mvc\model\db\Model;                      //模型类

/**
 *   微博删除类
 *   @package    microblog
 *   @author     luwei
 *   @created    2011-06-30
 *   @history     
 */

class MicroBlogDelete extends Controller {

    /**
     *    初始化方法
     *    @param      null
     *    @package    microblog 
     *    @return     null
     *    @author     luwei
     *    @created    2011-06-30
     */
    protected function init() {

        // 加载视图框架
        $this->add(new FrontFrame());

        //设定模型
        $this->defaultView->setModel(Model::fromFragment('microblog'));
    }

    /**
     *    业务逻辑处理
     *    @param      null
     *    @package    microblog 
     *    @return     null
     *    @author     luwei
     *    @created    2011-06-20
     */
    public function process() {

        $this->defaultView->model()->load($this->aParams->get("id"), "bid");
        $this->defaultView->model()->delete();

        Relocater::locate("/?c=MicroBlogList", "删除成功");
    }

}

?>
