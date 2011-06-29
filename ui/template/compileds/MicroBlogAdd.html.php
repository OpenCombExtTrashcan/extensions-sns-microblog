
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
<form action="/?c=MicroBlogAdd" method="post">
    <div>       
		<?php $_aWidget = $aVariables->get('theView')->widget("text") ;
if($_aWidget){
	$_aWidget->display($this,null,$aDevice) ;
}else{
	echo '缺少 widget (id:'."text".')' ;
} ?>
       
	</div>
    
    <input type="submit" value="发布" />
<input type="hidden" name="<?php echo $aVariables->get('theView')->htmlFormSignature()?>" value="1" /></form><?php } ?>
