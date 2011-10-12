<?php

namespace oc\ext\microblog;

//调用共通类
use jc\mvc\view\widget\Paginator;

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

Class TagtopPart extends Controller {

    protected function init() {
        
        

        //创建默认视图
        $this->createView("tagtop", "tagtopPart.html", true);
        
        $this->viewtagtop->addWidget(new Paginator("paginator",$this->aParams));
        
        //设定模型
        $this->viewtagtop->setModel(Model::fromFragment('mb_tag', array(), true));
    }
    
    public function process() {
    	
    	//载入
    	$this->viewtagtop->model()->criteria()->orders()->add("topnum",false) ;
    	$this->viewtagtop->model()->criteria()->setLimit(20);
    	$this->viewtagtop->model()->load();
    	
    }
}
?>
