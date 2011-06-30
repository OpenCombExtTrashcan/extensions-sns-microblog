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
use jc\mvc\controller\Controller;               //控制器类
use oc\base\FrontFrame;                         //视图框架类
use jc\mvc\model\db\Model;                      //模型类
use jc\mvc\view\widget\Text;                    //文本组件类
use jc\mvc\model\db\orm\ModelAssociationMap;    //模型关系类
use jc\message\Message;                        //消息类
use jc\verifier\Length;                         //长度校验类
use jc\verifier\NotEmpty;                       //非空校验类
use jc\mvc\view\DataExchanger ;                 //数据交换类
use jc\auth\IdManager;                          //用户SESSION类
use jc\mvc\controller\Relocater;                //回调类

/**
 *   微博发布类
 *   @package    microblog
 *   @author     luwei
 *   @created    2011-06-28
 *   @history     
 */

class MicroBlogAdd extends Controller {

    /**
     *    初始化方法
     *    @param      null
     *    @package    microblog 
     *    @return     null
     *    @author     luwei
     *    @created    2011-06-28
     */
    protected function init() {
        // 加载视图框架
        $this->add(new FrontFrame());

        //创建默认视图
        $this->createView("defaultView", "MicroBlogAdd.html", true);

        //为视图创建、添加textarea文本组件(Text::multiple 复文本) （Text::single 标准文本）
        $this->defaultView->addWidget(new Text("text", "内容", "", Text::multiple), 'text')
                            ->dataVerifiers ()
                                ->add ( Length::flyweight(0,140),"长度不能超过140个字" )
                                ->add ( NotEmpty::singleton(), "必须输入" );
        
        /*
          // 为视图创建、添加images文本组件
          $this->defaultView->addWidget( new Text("images","图片"), 'images' );

          // 为视图创建、添加videos文本组件
          $this->defaultView->addWidget( new Text("videos","图片"), 'videos' );

          // 为视图创建、添加musics文本组件
          $this->defaultView->addWidget( new Text("musics","图片"), 'musics' );
         * 
         */

        //设定模型
        $this->defaultView->setModel(Model::fromFragment('microblog'));
    }

    /**
     *    业务逻辑处理
     *    @param      null
     *    @package    microblog 
     *    @return     null
     *    @author     luwei
     *    @created    2011-06-28
     */
    public function process() {
        //判断表单是否提交
        if ($this->defaultView->isSubmit($this->aParams)) {
            
            // 加载 视图组件的数据
            $this->defaultView->loadWidgets($this->aParams);
            
            // 校验 视图组件的数据
            if ($this->defaultView->verifyWidgets()) {
                
                //将视图组件的数据与模型交换
                $this->defaultView->exchangeData(DataExchanger::WIDGET_TO_MODEL) ;
                
                //用户ID（IdManager::fromSession()->currentId()->userId() 取得用户ID）
                $this->defaultView->model()->setData('uid', IdManager::fromSession()->currentId()->userId());

                //发布时间
                $this->defaultView->model()->setData('time', time());

                //客户端
                $this->defaultView->model()->setData('client', 'web');

                try {
                    
                    //保存数据
                    $this->defaultView->model()->save();
                    
                    //创建提示消息                    
                    Relocater::locate("/?c=MicroBlogList", "发布成功！");                    
                    
                } catch (ExecuteException $e) {
                    throw $e;
                }
            }
        }
    }

}

?>
