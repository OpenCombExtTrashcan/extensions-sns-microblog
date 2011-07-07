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
use oc\mvc\model\db\Model;                      //模型类
use jc\mvc\view\widget\Text;                    //文本组件类
use jc\mvc\model\db\orm\ModelAssociationMap;    //模型关系类
use jc\message\Message;                        //消息类
use jc\verifier\Length;                         //长度校验类
use jc\verifier\NotEmpty;                       //非空校验类
use jc\mvc\view\DataExchanger;                 //数据交换类
use jc\auth\IdManager;                          //用户SESSION类
use jc\mvc\controller\Relocater;                //回调类
use jc\db\DB;                                   //数据库类

