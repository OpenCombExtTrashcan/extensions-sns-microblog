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
use jc\mvc\model\db\orm\PrototypeAssociationMap;    //
use jc\db\DB;                                   //
use jc\db\PDODriver; 
use oc\ext\Extension;

/**
 *   微博配置类
 *   @package    microblog
 *   @author     luwei
 *   @created    2011-06-28
 *   @history     
 */
class MicroBlog extends Extension {

    /**
     *    加载方法
     *    @param      null
     *    @package    microblog 
     *    @return     null
     *    @author     luwei
     *    @created    2011-06-28
     */
    public function load() {
    	
		// 定义ORM
        $this->defineOrm(PrototypeAssociationMap::singleton()) ;
        
        //加载微博列表控制器
        $this->application()->accessRouter()->addController("oc\\ext\\microblog\\mlist",'mlist');
        
        //加载微博发布控制器
        $this->application()->accessRouter()->addController("oc\\ext\\microblog\\add",'add');
        
        //加载微博删除控制器
        $this->application()->accessRouter()->addController("oc\\ext\\microblog\\delete",'delete');
        
        $this->application()->accessRouter()->addController("oc\\ext\\microblog\\tag",'tag');
        $this->application()->accessRouter()->addController("oc\\ext\\microblog\\user",'user');
        
        //加载微博标签热度云梯（排名）控制器
        $this->application()->accessRouter()->addController("oc\\ext\\microblog\\taglist",'taglist');
        
        //加载微博标签列表(聚合)控制器
        $this->application()->accessRouter()->addController("oc\\ext\\microblog\\tagtop",'tagtop');
        
        //加载微博转发控制器
        $this->application()->accessRouter()->addController("oc\\ext\\microblog\\forward",'forward');
        
        //加载微博@提到我的控制器
        $this->application()->accessRouter()->addController("oc\\ext\\microblog\\at",'at');
        
        //加载微博评论制器
        $this->application()->accessRouter()->addController("oc\\ext\\microblog\\review",'review');
        
//        //加载微博相同心情的朋友控制器
//        $this->application()->accessRouter()->addController("oc\\ext\\microblog\\mood",'mood');
//        
//        //加载微博相同心情的朋友控制器
//        $this->application()->accessRouter()->addController("oc\\ext\\microblog\\expression",'expression');
    }

	public function defineOrm(PrototypeAssociationMap $aAssocMap)
	{
        //microblog模型关系
        $aAssocMap->addOrm(
                array(
                    'keys' => 'mbid', //主键
                    'table' => 'microblog', //模型名称              
			        
                    'hasOne' => array(
                    	//与forward关系
        				array(
        					'prop' => 'forward', //属性名
        					'fromk' => 'forward', //主键
        					'tok' => 'mbid', //外键
                            'model' => 'microblog'  //模型名称
        				)
                    ),                    
                    'belongsTo' => array(
                        //与user关系
                        array(
                            'prop' => 'userto', //属性名
                            'fromk' => 'uid', //主键
                            'tok' => 'uid', //外键
                            'model' => 'coreuser:user'  //模型名称
                        ),
                    ), 
                    'hasAndBelongsToMany' => array(
                        //与at关系
                        array(
                            'prop' => 'at', //属性名
                            'fromk' => 'mbid', //主键
                            'btok' => 'mbid', //外键
                            'bfromk' => 'at_uid', //从主键
                            'tok' => 'uid', //从外键
                            'bridge' => 'at', //从模型名称
                            'model' => 'coreuser:user', //模型名称
                        ),
                        //与tag关系
                        array(
                            'prop' => 'tag', //属性名
                            'fromk' => 'mbid', //主键
                            'btok' => 'mbid', //外键
                            'bfromk' => 'mbtid', //从主键
                            'tok' => 'mbtid', //从外键
                            'bridge' => 'mb_link', //从模型名称
                            'model' => 'mb_tag', //模型名称
                        ),				        
				        //与expressions关系
				        array(
                             'prop' => 'expression', //属性名
                             'fromk' => 'mbid', //主键
                             'btok' => 'mbid', //外键
                             'bfromk' => 'eid', //从主键
                             'tok' => 'eid', //从外键
                             'bridge' => 'expression', //从模型名称
                             'model' => 'expressions', //模型名称
        				)
                    ),
                )
        );
        
        //Expression模型关系
        $aAssocMap->addOrm(
        		array(
        			'keys' => 'eid',
        			'table' => 'expressions',
        			
        			'hasAndBelongsToMany' => array(
                        //与microblog关系
                        array(
                            'prop' => 'microblog', //属性名
                            'fromk' => 'eid', //主键
                            'btok' => 'eid', //外键
                            'bfromk' => 'mbid', //从主键
                            'tok' => 'mbid', //从外键
                            'bridge' => 'expression', //从模型名称
                            'model' => 'microblog', //模型名称
                        )
					)
        		)
        );
        
        //tag模型关系
        $aAssocMap->addOrm(
                array(
                    'keys' => 'mbtid', //主键
                    'table' => 'mb_tag', //模型名称
                    
                    'hasAndBelongsToMany' => array(
                        //与microblog关系
                        array(
                            'prop' => 'microblog', //属性名
                            'fromk' => 'mbtid', //主键
                            'btok' => 'mbtid', //外键
                            'bfromk' => 'mbid', //从主键
                            'tok' => 'mbid', //从外键
                            'bridge' => 'mb_link', //从模型名称
                            'model' => 'microblog', //模型名称
                        )
                    ),
                )
        );        
        
        //link模型关系
        $aAssocMap->addOrm(
        		array(
        			'keys' => 'lid',
        			'table' => 'mb_link',
        			
        			'belongsTo' => array(
        				array(
        					'prop' => 'microblog' ,	//属性名
                			'fromk' => 'mbid' ,		//主键
                			'tok' => 'mbid' ,		//外键
                			'model' => 'microblog'	//模型名称
        				),
        				array(
                			'prop' => 'mb_tag' ,	//属性名
                        	'fromk' => 'mbtid' ,	//主键
                        	'tok' => 'mbtid' ,		//外键
                        	'model' => 'mb_tag'		//模型名称
        				)
        			),
        			
        		)
    	);
        
        //expression模型关系
        $aAssocMap->addOrm(
        		array(
        			'keys' => 'aid',
        			'table' => 'at',

        			'belongsTo' => array(
        				array(
        					'prop' => 'microblog' ,	//属性名
                			'fromk' => 'mbid' ,		//主键
                			'tok' => 'mbid' ,		//外键
                			'model' => 'microblog'	//模型名称        					
        				),
        				array(
        					'prop' => 'user' ,	//属性名
                        	'fromk' => 'at_uid' ,		//主键
                        	'tok' => 'uid' ,		//外键
                        	'model' => 'coreuser:user'	//模型名称          					
        				)
        			)
        		)
        );        
        
        //
        $aAssocMap->addOrm(
        		array(
        			'keys' => 'elid',
        			'table' => 'expression',
        			
        			'belongsTo' => array(
                		array(
                			'prop' => 'microblog' ,	//属性名
                        	'fromk' => 'mbid' ,		//主键
                        	'tok' => 'mbid' ,		//外键
                        	'model' => 'microblog'	//模型名称    
    					),
        				array(
                			'prop' => 'expressions' ,	//属性名
                          	'fromk' => 'eid' ,		//主键
                           	'tok' => 'eid' ,		//外键
                           	'model' => 'expressions'	//模型名称
                        )
                    )
        		)
        );
        
        //review模型关系
        $aAssocMap->addOrm(
	        	array(
	            	'keys' => 'rid',
	            	'table' => 'review',
	        
	            	'belongsTo' => array(
				        array(
				             'prop' => 'microblog' ,	//属性名
				             'fromk' => 'mbid' ,		//主键
				             'tok' => 'mbid' ,		//外键
				             'model' => 'microblog'	//模型名称        					
				        ),
				        array(
				             'prop' => 'user' ,	//属性名
				             'fromk' => 'at_uid' ,		//主键
				             'tok' => 'uid' ,		//外键
				             'model' => 'coreuser:user'	//模型名称          					
				        )
		        	)
	        	)
        );
        
        //mood模型关系
        $aAssocMap->addOrm(
        		array(
        			'keys' => 'mid',
        			'table' => 'mood',      			
        			
        			'belongsTo'=>array(
        				array(
        					'prop' => 'user',
        					'fromk' => 'uid',
        					'tok' => 'uid',
        					'model' => 'coreuser:user'
        				)
        			)
        		)
        );		
	}
}

?>