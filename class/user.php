<?php

namespace oc\ext\microblog;

//调用共通类
use oc\mvc\controller\Controller;               //控制器类
use oc\base\FrontFrame;                         //视图框架类
use jc\mvc\model\db\orm\PrototypeAssociationMap;    //模型关系类
use oc\mvc\model\db\Model;                      //模型类
use jc\auth\IdManager;                          //用户SESSION类

class user extends Controller {

    protected function init() {

        //创建默认视图
        $this->createView("user", "user.html", true);

        //设定模型
        $this->viewuser->setModel(Model::fromFragment('microblog', array('userto'),true));
    }

    public function process() {
    	
        $this->viewuser->model()->load('1', "uid");
    }

}

?>
