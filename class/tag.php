<?php

namespace oc\ext\microblog;

//调用共通类
use oc\mvc\controller\Controller;               //控制器类
use oc\base\FrontFrame;                         //视图框架类
use jc\mvc\model\db\orm\PrototypeAssociationMap;    //模型关系类
use oc\mvc\model\db\Model;                      //模型类
use jc\auth\IdManager;                          //用户SESSION类

class tag extends Controller {

    protected function init() {

        //创建默认视图
        $this->createView("tag", "tag.html", true);

        //设定模型
        $this->viewtag->setModel(Model::fromFragment('mb_tag', array('microblog')));
    }

    public function process() {
    	
        $this->viewtag->model()->load($this->aParams->get('tag'), "tag");
    }

}

?>
