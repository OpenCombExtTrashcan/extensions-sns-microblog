<?php

namespace oc\ext\microblog;

//调用共通类
use jc\mvc\view\widget\Paginator;

use oc\mvc\controller\Controller;               //控制器类
use oc\base\FrontFrame;                         //视图框架类
use jc\mvc\model\db\orm\PrototypeAssociationMap;    //模型关系类
use oc\mvc\model\db\Model;                      //模型类
use jc\auth\IdManager;                          //用户SESSION类

class Squarelist extends Controller {

    protected function init() {

        //创建默认视图
        $this->createView("Squarelist", "Squarelist.html", true);
    
        $this->viewSquarelist->addWidget(new Paginator("paginator",$this->aParams));
        
        //设定模型
        $this->viewSquarelist->setModel(Model::fromFragment('microblog', array('userto'=>array("info"),'forward'=>array('userto')), true));
    }

    public function process() {
    	
    	//过滤表情
    	$mood_pattern = "/\[([^\[\]|.]+)\]/";
    	
        //过滤话题的正则表达式
        $tag_pattern = "/\#([^\#|.]+)\#/";
        
        //过滤@用户的正则表达式
        $user_pattern = "/\@([a-zA-z0-9_]+)/";
        
       	$this->viewSquarelist->model()->criteria()->orders()->add("time",false) ;

       	//载入当前用户的所有微博
    	$this->viewSquarelist->model()->criteria()->restriction()->setLogic(false);
    	$this->viewSquarelist->model()->load();  
       	
       	
        //过滤话题和对象名       
        foreach ($this->viewSquarelist->model()->childIterator() as $row){        	
            $text = $row->data("text");
            $text = preg_replace($mood_pattern, '<a href=/?c=microblog.my&name=${0}>${0}</a>', $text);
            $text = preg_replace($user_pattern, '<a href=/?c=microblog.my&name=${1}>@${1}</a>', $text); 
            $text = preg_replace($tag_pattern, '<a href="?c=microblog.tag&tag=${1}">#${1}#</a>', $text);
            $row->setData("text",$text);
            if($row->data('forward')!=0){
            	$forward = $row->child('forward');
            	$text = $forward->data("text");
            	$text = preg_replace($mood_pattern, '<a href=/?c=microblog.my&name=${0}>${0}</a>', $text);
            	$text = preg_replace($user_pattern, '<a href=/?c=microblog.my&name=${1}>@${1}</a>', $text);
            	$text = preg_replace($tag_pattern, '<a href="?c=microblog.tag&tag=${1}">#${1}#</a>', $text);
            	$forward->setData("text",$text);
            }            
		}
		
		// $this->viewSquarelist->model()->printStruct();
    }

}

?>
