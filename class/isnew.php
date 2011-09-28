<?php

namespace oc\ext\microblog;

//调用共通类
use oc\mvc\controller\Controller;               //控制器类
use oc\base\FrontFrame;                         //视图框架类
use jc\mvc\model\db\orm\PrototypeAssociationMap;    //模型关系类
use oc\mvc\model\db\Model;                      //模型类
use jc\auth\IdManager;                          //用户SESSION类

Class isnew extends Controller {

    protected function init() {

        $this->model = Model::fromFragment('microblog', array(), true) ;
    }

    public function process()
    {
        
            
        if($this->aParams->get("time"))
        {
            $this->model->criteria()->restriction()->gt("time",$this->aParams->get("time")) ;
            echo $this->model->totalCount();
            exit;
        }else{
            
            $this->model->criteria()->orders()->add("time",false) ;
            $this->model->criteria()->setLimit(1);
            $this->model->load();
            echo $this->model->child(0)->data("time");
            exit;
        }
        
    }

}

?>
