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
use oc\mvc\controller\Controller;               //控制器类
use oc\base\FrontFrame;                         //视图框架类
use jc\mvc\model\db\orm\PrototypeAssociationMap;    //模型关系类
use oc\mvc\model\db\Model;                      //模型类
use jc\mvc\controller\Relocater;                //回调类
use jc\auth\IdManager;                          //用户SESSION类

/**
 *   微博删除类
 *   @package    microblog
 *   @author     luwei
 *   @created    2011-06-30
 *   @history     
 */

class delete extends Controller {

    /**
     *    初始化方法
     *    @param      null
     *    @package    microblog 
     *    @return     null
     *    @author     luwei
     *    @created    2011-06-30
     */
    protected function init() {
        
        //是否登陆
		if(!IdManager::fromSession()->currentId())
		{
		    echo "请先登陆";
		}

        
        

        //设定模型
        $this->model=new MicroBlogModel();
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

        $this->requireLogined();
        
        $this->model->load($this->aParams->get("id"), "mbid");
        $this->model->delete();

        Relocater::locate("/?c=microblog.mlist", "删除成功");
    }

}

?>
