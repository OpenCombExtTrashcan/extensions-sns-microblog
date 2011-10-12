<?php

namespace oc\ext\microblog;

//调用共通类
use jc\mvc\controller\Relocater;

use oc\mvc\controller\Controller;               //控制器类
use oc\base\FrontFrame;                         //视图框架类
use jc\mvc\model\db\orm\PrototypeAssociationMap;    //模型关系类
use oc\mvc\model\db\Model;                      //模型类
use jc\auth\IdManager;                          //用户SESSION类


Class index extends Controller {

    protected function init() {

        //创建默认视图
        $this->createView("index", "index.html", true);
        $this->add(new Userinfo);
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
        
        //热
        $model = Model::fromFragment('mb_tag', array(), true);
    	$model->criteria()->orders()->add("topnum",false) ;
    	$model->criteria()->setLimit(20);
    	$model->load();
    	$this->viewindex->variables()->set("tagModel",$model);
    	
    	//推荐关注
        $model = Model::fromFragment('coreuser:user', array("info"), true);
        $model->criteria()->setLimit(5);
    	$model->load();
    	$this->viewindex->variables()->set("userModel1",$model);
    	
    	//感兴趣的人
        $model = Model::fromFragment('coreuser:user', array("info"), true);
        $model->criteria()->setLimit(5);
    	$model->load();
    	$this->viewindex->variables()->set("userModel2",$model);
    	
    }

}

?>
