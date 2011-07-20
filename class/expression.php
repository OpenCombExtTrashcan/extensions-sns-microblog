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
use jc\db\DB;									//
use oc\mvc\controller\Controller;               //控制器类
use oc\base\FrontFrame;                         //视图框架类
use jc\mvc\model\db\orm\ModelAssociationMap;    //模型关系类
use oc\mvc\model\db\Model;                      //模型类
use jc\auth\IdManager;                          //用户SESSION类

class expression extends Controller {

	/**
	 *    初始化方法
	 *    @param      null
	 *    @package    microblog
	 *    @return     null
	 *    @author     luwei
	 *    @created    2011-07-08
	 */
	protected function init() {

		
		

		//创建默认视图
		$this->createView("expression", "expression.html", true);

		//设定模型
		//$this->viewexpression->setModel(Model::fromFragment('microblog', array('userto','forward'=>array('userto')), true));
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
		
		 
		//过滤表情
		$mood_pattern = "/\[([^\[\]|.]+)\]/";
		 
		//过滤话题的正则表达式
		$tag_pattern = "/\#([^\#|.]+)\#/";

		//过滤@用户的正则表达式
		$user_pattern = "/\@([a-zA-z0-9_]+)/";
		
		$aEid=Db::singleton()->query("select eid from microblog_expression where mbid in ('".$this->aParams->get('mbid')."') and insdate > '".date('Y-m-d')."'");
		$eidarr = array();
		foreach($aEid->iterator() as $v){
			array_push($eidarr,$v['eid']) ;
		}
		//var_dump($eidarr);

		$eidstr = implode(',', $eidarr);
		$sql = "select m.*,c.username from microblog_microblog m left join coreuser_user c on m.uid=c.uid where mbid in (select mbid from microblog_expression where eid in ('".$eidstr."'))";
		$aElist = Db::singleton()->query($sql);
		$elistarr= array();
		foreach($aElist->iterator() as $v){
			$v['text'] = preg_replace($mood_pattern, '<a href=/${0}>${0}</a>', $v['text']);
			$v['text'] = preg_replace($user_pattern, '<a href=/${1}>@${1}</a>',$v['text']);
			$v['text'] = preg_replace($tag_pattern, '<a href="/k/${1}">#${1}#</a>', $v['text']);
			array_push($elistarr,$v) ;
		}
		$this->viewexpression->variables()->set('elistarr',$elistarr);
	}

}