<?php

namespace oc\ext\microblog;

//调用共通类
use oc\mvc\controller\Controller;               //控制器类
use oc\base\FrontFrame;                         //视图框架类
use jc\mvc\model\db\orm\PrototypeAssociationMap;    //模型关系类
use oc\mvc\model\db\Model;                      //模型类
use jc\auth\IdManager;                          //用户SESSION类


Class My extends Controller {

    protected function init() {

        //创建默认视图
        $this->createView("My", "My.html", true);
        
        $this->viewMy->setModel(Model::fromFragment('coreuser:user', array('info')));
    }

    public function process() {
    	
        $this->viewMy->model()->load($this->aParams->get("uid"),"uid");    
        
        $model = Model::fromFragment('coreuser:subscribe');
        $model -> load($this->aParams->get("id"),"uid");
        $this->viewMy->model()->setData("gz",$model->totalCount());
        
        $model = Model::fromFragment('coreuser:subscribe');
        $model -> load($this->aParams->get("id"),"subscribeid");
        $this->viewMy->model()->setData("fs",$model->totalCount());
        
        $model = Model::fromFragment('microblog');
        $model -> load($this->aParams->get("id"),"uid");
        $this->viewMy->model()->setData("wb",$model->totalCount());
        
    }

}

?>
