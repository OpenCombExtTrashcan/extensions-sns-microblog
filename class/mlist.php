<?php

namespace oc\ext\microblog;

//调用共通类
use jc\mvc\view\widget\Paginator;

use oc\mvc\controller\Controller;               //控制器类
use oc\base\FrontFrame;                         //视图框架类
use jc\mvc\model\db\orm\PrototypeAssociationMap;    //模型关系类
use oc\mvc\model\db\Model;                      //模型类
use jc\auth\IdManager;                          //用户SESSION类

class mlist extends Controller {

    protected function init() {

        //创建默认视图
        $this->createView("mlist", "mlist.html", true);
    
        $this->viewmlist->addWidget(new Paginator("paginator",$this->aParams));
        
        //设定模型
        $this->viewmlist->setModel(Model::fromFragment('microblog', array('userto'=>array("usersubscribe","info"),'forward'=>array('userto')), true));
    }

    public function process() {
    	
    	//过滤表情
    	$mood_pattern = "/\[([^\[\]|.]+)\]/";
    	
        //过滤话题的正则表达式
        $tag_pattern = "/\#([^\#|.]+)\#/";
        
        //过滤@用户的正则表达式
        $user_pattern = "/\@([a-zA-z0-9_]+)/";
        
       	$this->viewmlist->model()->criteria()->orders()->add("time",false) ;

       	//载入当前用户的所有微博
        $userList = IdManager::fromSession();
       	if($this->aParams->get('uid')!=""){
       		$this->viewmlist->model()->load($this->aParams->get('uid'), "uid");
       	}else{
        	$this->viewmlist->model()->load("15", "userto.usersubscribe.subscribeid");    
       	}
       	$this->viewmlist->model()->printStruct();
       	
        //过滤话题和对象名       
        foreach ($this->viewmlist->model()->childIterator() as $row){        	
            $text = $row->data("text");
            $text = preg_replace($mood_pattern, '<a href=/${0}>${0}</a>', $text);
            $text = preg_replace($user_pattern, '<a href=/${1}>@${1}</a>', $text); 
            $text = preg_replace($tag_pattern, '<a href="?c=microblog.tag&tag=${1}">#${1}#</a>', $text);
            $row->setData("text",$text);
            if($row->data('forward')!=0){
            	$forward = $row->child('forward');
            	$text = $forward->data("text");
            	$text = preg_replace($mood_pattern, '<a href=/${0}>${0}</a>', $text);
            	$text = preg_replace($user_pattern, '<a href=/${1}>@${1}</a>', $text);
            	$text = preg_replace($tag_pattern, '<a href="?c=microblog.tag&tag=${1}">#${1}#</a>', $text);
            	$forward->setData("text",$text);
            }            
		}
		
		// $this->viewmlist->model()->printStruct();
    }

}

?>
