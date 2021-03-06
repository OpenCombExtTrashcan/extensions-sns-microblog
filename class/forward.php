<?php


namespace oc\ext\microblog;

//调用共通类
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


class forward extends Controller {
	
	protected function init() {
	
		//创建默认视图
		$this->createView("forward", "forward.html", true);				
		
		//为视图创建、添加textarea文本组件(Text::multiple 复文本) （Text::single 标准文本）
		$this->viewforward->addWidget(new Text("newMtext", "内容", "", Text::multiple), 'text')
			->dataVerifiers()
			->add(Length::flyweight(array(0, 140)), "长度不能超过140个字");
		
		
		//设定模型
		$this->viewforward->setModel(new MicroBlogModel());	
		
	}
	
	public function process() {		
		
	    
		$this->viewforward->model()->load($this->aParams->get("id"),'mbid');
		
		//var_dump($this->viewforward->model());
		//转发判断
		$forward = $this->viewforward->model()->data('forward');
		$uid = $this->viewforward->model()->data('uid');
		$ftext = $this->viewforward->model()->data('text');
		//转发过
		if($forward!=0){
			//取得用户名
		    $aModleForwardMb = Model::fromFragment('microblog', array("userto")) ;
		    $aModleForwardMb->load($forward,"mbid");
		    if($aModleForwardMb->data("userto.username"))
		    {
                $this->viewforward->model()->setData('text', " //@".$aModleForwardMb->data("userto.username").":".$ftext);		        
		    }
			
			$this->viewforward->variables()->set('forward',$forward);
			//将视图组件的数据与模型交换
			$this->viewforward->exchangeData(DataExchanger::MODEL_TO_WIDGET) ;
		}else{		
			$this->viewforward->variables()->set('forward',0);
		}
		//插入false 更新true
		$this->viewforward->model()->setSerialized(false) ;
		//清除主键
		$this->viewforward->model()->setData('mbid',null) ;
		
		
		//过滤话题的正则表达式
		$tag_pattern = "/\#([^\#|.]+)\#/";
	
		//过滤@用户的正则表达式
		$user_pattern = "/\@([a-zA-z0-9_]+)/";
	
		//判断表单是否提交
		if ($this->viewforward->isSubmit($this->aParams) || $this->aParams->get("ajax")) {
		
            if(!IdManager::fromSession()->currentId())
            {
                echo "请先登陆";exit;
            }
            
			// 加载 视图组件的数据
			$this->viewforward->loadWidgets($this->aParams);
	
			// 校验 视图组件的数据
			if ($this->viewforward->verifyWidgets()) {
	
				//将视图组件的数据与模型交换
				$this->viewforward->exchangeData(DataExchanger::WIDGET_TO_MODEL);
	
				//用户ID（IdManager::fromSession()->currentId()->userId() 取得用户ID）
				$this->viewforward->model()->setData('uid', IdManager::fromSession()->currentId()->userId());
	
				//发布时间
				$this->viewforward->model()->setData('time', time());
	
				//客户端
				$this->viewforward->model()->setData('client', 'web');
				
				//转发ID
				$this->viewforward->model()->setData('forward', $this->aParams->get("forward"));
				
				//内容为空设置
				$text = $this->viewforward->model()->data('text');				
				if(empty($text)){
					$this->viewforward->model()->setData('text', '转发微博');
				}
			
	
				//过滤标签
				preg_match_all($tag_pattern, $this->viewforward->model()->data('text'), $tagsarr);
				//判断标签个数
				if (count($tagsarr[1]) > 1) {
					//遍历标签
					for ($i = 0; $i < count($tagsarr[1]); $i++) {
						//绑定标签数据
						$this->viewforward->model()->child('tag')->buildChild($tagsarr[1][$i], "tag");
					}
				} elseif (count($tagsarr[1]) > 0)  {
					$this->viewforward->model()->child('tag')->buildChild($tagsarr[1], "tag");
				}
	
				//过滤用户
				preg_match_all($user_pattern, $this->viewforward->model()->data('text'), $usersarr);
				//判断标签个数
				if (count($usersarr[1]) > 1) {
					//遍历标签
					for ($i = 0; $i < count($usersarr[1]); $i++) {
						//加载用户数据
						$this->viewforward->model()->child('at')->loadChild($usersarr[1][$i], "username");
					}
				} elseif (count($usersarr[1]) > 0)  {
					$this->viewforward->model()->child('at')->loadChild($usersarr[1], "username");
				}
	
				try {
	
					//保存数据
					$this->viewforward->model()->save();
					//echo "<pre>".print_r(DB::singleton()->executeLog())."</pre>";
					//创建提示消息
					//Relocater::locate("/?c=microblog.mlist", "发布成功！");
				} catch (ExecuteException $e) {
					throw $e;
				}
			}
		}
	}
}
?>