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
use oc\mvc\view\View;

use oc\mvc\controller\Controller;               //控制器类
use oc\base\FrontFrame;                         //视图框架类
use oc\mvc\model\db\Model;                      //模型类
use jc\mvc\view\widget\Text;                    //文本组件类
use jc\mvc\view\widget\RadioGroup;				//单选按钮组件类
use jc\mvc\model\db\orm\ModelAssociationMap;    //模型关系类
use jc\message\Message;                        //消息类
use jc\verifier\Length;                         //长度校验类
use jc\verifier\NotEmpty;                       //非空校验类
use jc\mvc\view\DataExchanger;                 //数据交换类
use jc\auth\IdManager;                          //用户SESSION类
use jc\mvc\controller\Relocater;                //回调类
use jc\db\DB;                                   //数据库类

/**
 *   微博相同心情的朋友类
 *   @package    microblog
 *   @author     luwei
 *   @created    2011-07-08
 *   @history
 */
class MricoBlogMood extends Controller {
	
	/**
	 *    初始化方法
	 *    @param      null
	 *    @package    microblog
	 *    @return     null
	 *    @author     luwei
	 *    @created    2011-07-08
	 */
	protected function init() {
		
		// 加载视图框架
		$this->add(new FrontFrame());
	
		//创建默认视图
		$this->createView("listView", "MicroBlogMoodList.html", true);
	
		//子视图创建
		$this->formView = new View('formView',"MicroBlogMoodForm.html") ;
	
	
		//绑定视图
		$this->listView->add($this->formView) ;
		
		//为视图创建、添加单选按钮组件
		$this->formView->addWidget ( new RadioGroup('type'), 'type' )
		->createRadio('好','1',true)
		->createRadio('坏','2')
		->createRadio('一般','3') ;
		
		//为视图创建、添加textarea文本组件(Text::multiple 复文本) （Text::single 标准文本）
		$this->formView->addWidget(new Text("text", "内容", "", Text::multiple), 'text')
		->dataVerifiers()
		->add(Length::flyweight(0, 140), "长度不能超过140个字")
		->add(NotEmpty::singleton(), "必须输入");
	
		//设定模型
		$this->formView->setModel(Model::fromFragment('mood'));
		$this->listView->setModel(Model::fromFragment('mood',array('user','type'=>array('date')),true));
	}
	
	/**
	 *    业务逻辑处理
	 *    @param      null
	 *    @package    microblog
	 *    @return     null
	 *    @author     luwei
	 *    @created    2011-07-08
	 */
	public function process() {
	
		//转入心情数据
		$userList = IdManager::fromSession();
		$this->listView->model()->load(array($userList->currentId()->userId(),date('Y-m-d')),array('uid','update'));
		
		$this->listView->model()->printStruct() ;		
		
		
	}
}