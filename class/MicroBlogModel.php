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
use jc\mvc\model\db\orm\operators\Inserter;		//
use jc\mvc\model\db\orm\operators\Updater;		//
use jc\mvc\model\db\orm\PrototypeAssociationMap;	//
use oc\mvc\model\db\Model;						//

/**
 *   微博模型类
 *   @package    microblog
 *   @author     luwei
 *   @created    2011-06-28
 *   @history
 */
class MicroBlogModel extends Model {
	
	/**
	 *    构造方法
	 *    @param      Boolen $bAggregarion
	 *    @package    microblog
	 *    @return     null
	 *    @author     luwei
	 *    @created    2011-07-06
	 */	
	public function __construct($bAggregarion=false){
		
		//
		parent::__construct(PrototypeAssociationMap::singleton()->fragment('microblog',array('tag','at'), true),$bAggregarion);
	}
	
	/**
	 *    插入方法
	 *    @param      null
	 *    @package    microblog
	 *    @return     null
	 *    @author     luwei
	 *    @created    2011-07-06
	 */
	public function insert()
	{
		if(parent::insert())
		{
			$this->updateTagHot(true) ;
	
			return true ;
		}
	
		else
		{
			return false ;
		}
	}
	
	/**
	 *    删除方法
	 *    @param      null
	 *    @package    microblog
	 *    @return     null
	 *    @author     luwei
	 *    @created    2011-07-06
	 */
	public function delete()
	{
		$this->updateTagHot(false);
		if(parent::delete())
		{	
			return true ;
		}
	
		else
		{
			return false ;
		}
	}
	
	/**
	 *    热度云梯统计方法
	 *    @param      Boolen $bIncrease
	 *    @package    microblog
	 *    @return     null
	 *    @author     luwei
	 *    @created    2011-07-06
	 */
	public function updateTagHot($bIncrease=true)
	{
		if($bIncrease)
		{
			Db::singleton()->query("update microblog_mb_tag as t,microblog_mb_link as l set t.topnum=t.topnum+1 where t.mbtid = l.mbtid and l.mbid = ".$this->data('mbid'));
		}else{
			Db::singleton()->query("update microblog_mb_tag as t,microblog_mb_link as l set t.topnum=t.topnum-1 where t.mbtid = l.mbtid and l.mbid = ".$this->data('mbid'));
		}		
	}
}
?>