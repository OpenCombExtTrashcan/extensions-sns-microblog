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
use jc\mvc\model\db\orm\PrototypeAssociationMap;    //模型关系类
use jc\message\Message;                        //消息类
use jc\verifier\Length;                         //长度校验类
use jc\verifier\NotEmpty;                       //非空校验类
use jc\mvc\view\DataExchanger;                 //数据交换类
use jc\auth\IdManager;                          //用户SESSION类
use jc\mvc\controller\Relocater;                //回调类
use jc\db\DB;                                   //数据库类

/**
 *   微博评论类
 *   @package    microblog
 *   @author     luwei
 *   @created    2011-07-07
 *   @history
 */
class review extends Controller {
	
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
		$this->createView("formView", "reviewform.html", true);
		
		//子视图创建
		$this->listView = new View('listView',"reviewlist.html") ;
		
		
		//绑定视图
		$this->formView->add($this->listView) ;	
		
		
		//为视图创建、添加textarea文本组件(Text::multiple 复文本) （Text::single 标准文本）
		$this->formView->addWidget(new Text("text", "内容", "", Text::multiple), 'text')
			->dataVerifiers()
			->add(Length::flyweight(array(0, 140)), "长度不能超过140个字")
			->add(NotEmpty::singleton(), "必须输入");
	
		//设定模型
		$this->formView->setModel(Model::fromFragment('review'));
		$this->listView->setModel(Model::fromFragment('review',array('microblog','user'),true));
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
		
		//转入评论数据
		$this->listView->model()->load($this->aParams->get("id"),'mbid');
		
		//回复评论
		if($this->aParams->get("rid")!=''){
			//遍历获取要回复的评论
			foreach ($this->listView->model()->childIterator() as $row){
				if($row['rid']==$this->aParams->get("rid")){
					//获取用户名
					$username=$row->child('user')->data('username');
				}
			
			}
			$this->formView->model()->setData('text', "回复@".$username.": ");
			//将视图组件的数据与模型交换
			$this->formView->exchangeData(DataExchanger::MODEL_TO_WIDGET) ;
		}
		//判断表单是否提交
        if ($this->formView->isSubmit($this->aParams)) {
			
            // 加载 视图组件的数据
            $this->formView->loadWidgets($this->aParams);

            // 校验 视图组件的数据
            if ($this->formView->verifyWidgets()) {

                //将视图组件的数据与模型交换
                $this->formView->exchangeData(DataExchanger::WIDGET_TO_MODEL);
				
                //
                $this->formView->model()->setData('mbid', $this->aParams->get("mbid"));
                
                //用户ID（IdManager::fromSession()->currentId()->userId() 取得用户ID）
                $this->formView->model()->setData('at_uid', IdManager::fromSession()->currentId()->userId());
				
                //回复状态
                if($this->aParams->get("rid")!=''){
                	$this->formView->model()->setData('reply', $this->aParams->get("rid"));
                }else{
                	$this->formView->model()->setData('reply', '0');
                }
                
                //发布时间
                $this->formView->model()->setData('time', time());

                try {
                	
                    //保存数据
                    if( $this->formView->model()->save() ){
                    	//$this->formView->model()->printStruct() ;
	                    //echo "<pre>".print_r(DB::singleton()->executeLog())."</pre>";
	                    //创建提示消息                    
	                    Relocater::locate("/?c=microblog.mlist", "发布成功！");
                    }
                   
                } catch (ExecuteException $e) {
                    throw $e;
                }
            }
        }
    }
}
