
<?php if(eval("if(!isset(\$__uivar_myMood)){ \$__uivar_myMood=&\$aVariables->getRef('myMood') ;};
return count(\$__uivar_myMood)==0;")){ ?>
今日心情<br />
<?php 
$__ui_msgqueue = eval("if(!isset(\$__uivar_theView)){ \$__uivar_theView=&\$aVariables->getRef('theView') ;};
return \$__uivar_theView;") ;
if( $__ui_msgqueue instanceof \jc\message\IMessageQueueHolder )
{ $__ui_msgqueue = $__ui_msgqueue->messageQueue() ; }
\jc\lang\Assert::type( '\\jc\\message\\IMessageQueue',$__ui_msgqueue);
if( $__ui_msgqueue->count() ){ 
	$__ui_msgqueue->display($this,$aDevice) ;
} ?>

<?php if( !($aVariables->get('theView') instanceof \jc\mvc\view\FormView) or $aVariables->get('theView')->isShowForm() ) { ?>
<form action="/?c=microblog.mood" method="post">	
	<div>
		心　情：<?php $_aWidget = $aVariables->get('theView')->widget("type:1") ;
if($_aWidget){
	$_aWidget->display($this,null,$aDevice) ;
}else{
	echo '缺少 widget (id:'."type:1".')' ;
} ?>
 <?php $_aWidget = $aVariables->get('theView')->widget("type:2") ;
if($_aWidget){
	$_aWidget->display($this,null,$aDevice) ;
}else{
	echo '缺少 widget (id:'."type:2".')' ;
} ?>
 <?php $_aWidget = $aVariables->get('theView')->widget("type:3") ;
if($_aWidget){
	$_aWidget->display($this,null,$aDevice) ;
}else{
	echo '缺少 widget (id:'."type:3".')' ;
} ?>

		<?php 
$__ui_msgqueue = eval("if(!isset(\$__uivar_theView)){ \$__uivar_theView=&\$aVariables->getRef('theView') ;};
return \$__uivar_theView->widget('type');") ;
if( $__ui_msgqueue instanceof \jc\message\IMessageQueueHolder )
{ $__ui_msgqueue = $__ui_msgqueue->messageQueue() ; }
\jc\lang\Assert::type( '\\jc\\message\\IMessageQueue',$__ui_msgqueue);
if( $__ui_msgqueue->count() ){ 
	$__ui_msgqueue->display($this,$aDevice) ;
} ?>

	</div>
	<div>       
		<?php $_aWidget = $aVariables->get('theView')->widget("text") ;
if($_aWidget){
	$_aWidget->display($this,null,$aDevice) ;
}else{
	echo '缺少 widget (id:'."text".')' ;
} ?>
       
	</div>
	<input type="hidden" name="mbid" value="<?php echo eval("if(!isset(\$__uivar_theRequest)){ \$__uivar_theRequest=&\$aVariables->getRef('theRequest') ;};
return \$__uivar_theRequest->get('id');") ;?>" /> 
	<?php if(eval("if(!isset(\$__uivar_theRequest)){ \$__uivar_theRequest=&\$aVariables->getRef('theRequest') ;};
return \$__uivar_theRequest->get('rid')!='';")){ ?>
	<input type="hidden" name="rid" value="<?php echo eval("if(!isset(\$__uivar_theRequest)){ \$__uivar_theRequest=&\$aVariables->getRef('theRequest') ;};
return \$__uivar_theRequest->get('rid');") ;?>" /> 
	<?php } ?>   
    <input type="submit" value="评论" />
<input type="hidden" name="<?php echo $aVariables->get('theView')->htmlFormSignature()?>" value="1" /></form><?php } ?>

<?php } ?>
