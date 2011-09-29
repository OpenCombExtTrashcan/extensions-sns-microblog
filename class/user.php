<?php

namespace oc\ext\microblog;

//调用共通类
use jc\mvc\view\widget\Paginator;

use oc\mvc\controller\Controller;               //控制器类
use oc\base\FrontFrame;                         //视图框架类
use jc\mvc\model\db\orm\PrototypeAssociationMap;    //模型关系类
use oc\mvc\model\db\Model;                      //模型类
use jc\auth\IdManager;                          //用户SESSION类

class user extends Controller {

    protected function init() {

        //创建默认视图
        $this->createView("user", "user.html", true);

        $this->viewuser->addWidget(new Paginator("paginator",$this->aParams))->setPerPageCount(10);
        
        //设定模型
        $this->viewuser->setModel(Model::fromFragment('coreuser:user', array('info'),true));
    }

    public function process() {
    	
        if($this->aParams->get("username"))
        {
            $this->viewuser->model()->load($this->aParams->get("username"),"username");            
        }else {
            $this->viewuser->model()->load();
        }
        
    }

}

?>
