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
use oc\mvc\model\db\Model;                      //模型类
use jc\mvc\view\widget\Text;                    //文本组件类
use jc\mvc\model\db\orm\PrototypeAssociationMap;    //模型关系类
use jc\message\Message;                        //消息类
use jc\verifier\Length;                         //长度校验类
use jc\verifier\NotEmpty;                       //非空校验类
use jc\mvc\view\DataExchanger;                 //数据交换类
use jc\auth\IdManager;                          //用户SESSION类
use jc\mvc\controller\Relocater;                //回调类
use jc\db\DB;                                   //数据库类

/**
 *   微博标签列表类
 *   @package    microblog
 *   @author     luwei
 *   @created    2011-07-04
 *   @history     
 */

class taglist extends Controller {
    
    /**
     *    初始化方法
     *    @param      null
     *    @package    microblog 
     *    @return     null
     *    @author     luwei
     *    @created    2011-07-04
     */
    protected function init() {
        // 加载视图框架
        $this->add(new FrontFrame());

        //创建默认视图
        $this->createView("defaultView", "taglist.html", true);
        
        //设定模型
        $this->defaultView->setModel(Model::fromFragment('mb_tag', array(), true));        
    }
    
    /**
     *    业务逻辑处理
     *    @param      null
     *    @package    microblog 
     *    @return     null
     *    @author     luwei
     *    @created    2011-07-04
     */
    public function process() {
        
        //载入数据
        $this->defaultView->model()->load();
    }
}
?>
