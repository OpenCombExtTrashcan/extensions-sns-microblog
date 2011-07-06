
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
<form action="/?c=microblog.MicroBlogForward" method="post">
    <div>       
		<?php $_aWidget = $aVariables->get('theView')->widget("text") ;
if($_aWidget){
	$_aWidget->display($this,null,$aDevice) ;
}else{
	echo '缺少 widget (id:'."text".')' ;
} ?>
       
	</div>   
    <input type="hidden" name="forward" value="<?php echo eval("if(!isset(\$__uivar_theRequest)){ \$__uivar_theRequest=&\$aVariables->getRef('theRequest') ;};
return \$__uivar_theRequest->get('id');") ;?>" />
    <input type="submit" value="转发" />
<input type="hidden" name="<?php echo $aVariables->get('theView')->htmlFormSignature()?>" value="1" /></form><?php } ?>
