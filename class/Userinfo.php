<?php

namespace oc\ext\microblog;

//调用共通类
use jc\mvc\controller\Relocater;

use oc\mvc\controller\Controller;               //控制器类
use oc\base\FrontFrame;                         //视图框架类
use jc\mvc\model\db\orm\PrototypeAssociationMap;    //模型关系类
use oc\mvc\model\db\Model;                      //模型类
use jc\auth\IdManager;                          //用户SESSION类

Class Userinfo extends Controller {

    protected function init() {
        //创建默认视图
        $this->createView("Userinfo", "userinfo.html", true);

        //设定模型
        $this->viewUserinfo->setModel(Model::fromFragment('coreuser:user', array('info')));
    }

    public function process() {
    	
        $this->requireLogined();
        
        $this->viewUserinfo->model()->load(IdManager::fromSession()->currentId()->userId(),"uid");     

        
        $model = Model::fromFragment('coreuser:subscribe');
        $model -> load(IdManager::fromSession()->currentId()->userId(),"uid");
        $this->viewUserinfo->model()->setData("gz",$model->totalCount());
        
        $model = Model::fromFragment('coreuser:subscribe');
        $model -> load(IdManager::fromSession()->currentId()->userId(),"subscribeid");
        $this->viewUserinfo->model()->setData("fs",$model->totalCount());
        
        $model = Model::fromFragment('microblog');
        $model -> load(IdManager::fromSession()->currentId()->userId(),"uid");
        $this->viewUserinfo->model()->setData("wb",$model->totalCount());
        //$this->viewUserinfo->model()->printStruct();
    }
}

?>
