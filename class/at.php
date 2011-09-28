<?php

// +----------------------------------------------------------------------
// | WeiBo 
// +----------------------------------------------------------------------
// | Copyright (c) 2011 http://www.sunmy.com.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.X )
// +----------------------------------------------------------------------
// | Author: luwei <solver.lu@gmail.com>
// +----------------------------------------------------------------------
// 1.0.0.1

namespace oc\ext\microblog;

//调用共通类
use oc\mvc\controller\Controller;               //控制器类
use oc\base\FrontFrame;                         //视图框架类
use jc\mvc\model\db\orm\PrototypeAssociationMap;    //模型关系类
use oc\mvc\model\db\Model;                      //模型类
use jc\auth\IdManager;                          //用户SESSION类

/**
 *   微博@提到我的类
 *   @package    microblog
 *   @author     luwei
 *   @created    2011-07-07
 *   @history     
 */

class at extends Controller {

    /**
     *    初始化方法
     *    @param      null
     *    @package    microblog 
     *    @return     null
     *    @author     luwei
     *    @created    2011-07-07
     */
    protected function init() {

        
        

        //创建默认视图
        $this->createView("at", "at.html", true);

        //设定模型
        $this->viewat->setModel(Model::fromFragment('at', array('microblog'=>array('forward'=>array('userto')),'user'), true));
    }

    /**
     *    业务逻辑处理
     *    @param      null
     *    @package    microblog 
     *    @return     null
     *    @author     luwei
     *    @created    2011-07-07
     */
    public function process() {
        
        /*
          微博中过滤话题和对象名的实例
          =============================================================================================================================
          $post_content = "@oschina和@twitter在研究用#PHP#的#正则表达式#过滤话题和对象名";

          $tag_pattern = "/\#([^\#|.]+)\#/";
          preg_match_all($tag_pattern, $post_content, $tagsarr);
          var_dump($tagsarr);
          $tags = implode(',', $tagsarr[1]);
          echo $tags;
          $user_pattern = "/\@([a-zA-z0-9_]+)/";
          $post_content = preg_replace($user_pattern, '<a href="http://twitter.com/${1}">@${1}</a>', $post_content);
          $post_content = preg_replace($tag_pattern, '<a href="http://twitter.com/search?q=#${1}">#${1}#</a>', $post_content);

          echo $post_content;
          ===============================================================================================================================
         */

        //过滤话题的正则表达式
        $tag_pattern = "/\#([^\#|.]+)\#/";
        
        //过滤@用户的正则表达式
        $user_pattern = "/\@([a-zA-z0-9_]+)/";
        
        //载入当前用户的所有微博
        $userList = IdManager::fromSession();
        $this->viewat->model()->load($userList->currentId()->userId(), "at_uid");    
            
        //显示数据结构
        //$this->viewat->model()->printStruct() ;
        
        //过滤话题和对象名       
        foreach ($this->viewat->model()->childIterator() as $row){        	
            $text = $row->child('microblog')->data("text");
            $text = preg_replace($user_pattern, '<a href=/${1}>@${1}</a>', $text); 
            $text = preg_replace($tag_pattern, '<a href="?c=microblog.tag&tag=${1}">#${1}#</a>', $text);
            $row->child('microblog')->setData("text",$text);            
		}
		
		//$this->viewat->model()->printStruct();
    }

}

?>
