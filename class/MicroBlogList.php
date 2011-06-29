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
use jc\auth\IdManager;                          //用户SESSION类

/**
 *   微博列表类
 *   @package    microblog
 *   @author     luwei
 *   @created    2011-06-29
 *   @history     
 */
class MicroBlogList extends Controller {
    
    /**
     *    初始化方法
     *    @param      null
     *    @package    microblog 
     *    @return     null
     *    @author     luwei
     *    @created    2011-06-29
     */
    protected function init() {
        
        // 加载视图框架
        $this->add(new FrontFrame());
        
        //创建默认视图
        $this->createView("defaultView", "MicroBlogList.html", true);
        
        //设定模型
        $this->defaultView->setModel(Model::fromFragment('microblog'));
        
    }
    
    /**
     *    业务逻辑处理
     *    @param      null
     *    @package    microblog 
     *    @return     null
     *    @author     luwei
     *    @created    2011-06-29
     */
    public function process() {
        
        //载入当前用户的所有微博
        $userList = IdManager::fromSession();
        $this->defaultView->model()->load($userList->currentId()->userId(),"uid");
        var_dump($this->defaultView->model());
       
    }
}

?>
