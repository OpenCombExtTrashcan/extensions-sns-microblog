
<?php if(eval("if(!isset(\$__uivar_myMood)){ \$__uivar_myMood=&\$aVariables->getRef('myMood') ;};
return count(\$__uivar_myMood)>0;")){ ?>
今天心情：<?php echo eval("if(!isset(\$__uivar_myMood)){ \$__uivar_myMood=&\$aVariables->getRef('myMood') ;};
return (\$__uivar_myMood['type']=='1')?\"好\":((\$__uivar_myMood['type']=='2')?\"坏\":\"一般\");") ;?> <br />
&nbsp;&nbsp;我:<?php echo eval("if(!isset(\$__uivar_myMood)){ \$__uivar_myMood=&\$aVariables->getRef('myMood') ;};
return \$__uivar_myMood['text'];") ;?> <br />
相同心情的朋友：<br />
<?php
				$__foreach_Arr_var0 = eval("if(!isset(\$__uivar_theModel)){ \$__uivar_theModel=&\$aVariables->getRef('theModel') ;};
return \$__uivar_theModel->childIterator();");
				if(!empty($__foreach_Arr_var0)){ 
					$__foreach_idx_var3 = -1;
					foreach($__foreach_Arr_var0 as $__foreach_key_var2 => &$__foreach_item_var1){
						$__foreach_idx_var3++;
						 $aVariables->set("row",$__foreach_item_var1 );  $aVariables->set("idx",$__foreach_idx_var3 ); ?>	
	<?php if(eval("if(!isset(\$__uivar_myMood)){ \$__uivar_myMood=&\$aVariables->getRef('myMood') ;};
if(!isset(\$__uivar_row)){ \$__uivar_row=&\$aVariables->getRef('row') ;};
return \$__uivar_myMood['mid']!=\$__uivar_row->data('mid');")){ ?>				
			&nbsp;&nbsp;&nbsp;&nbsp;<?php echo eval("if(!isset(\$__uivar_row)){ \$__uivar_row=&\$aVariables->getRef('row') ;};
return \$__uivar_row->child('user')->data('username');") ;?>:<?php echo eval("if(!isset(\$__uivar_row)){ \$__uivar_row=&\$aVariables->getRef('row') ;};
return \$__uivar_row->data('text');") ;?>  <br />
	<?php } ?>
<?php 
					}
				}
			 		?>
<?php } ?>

<?php ob_flush() ;
$theView = $aVariables->get('theView') ;
foreach($theView->iterator() as $aChildView){
	$theView->outputStream()->write($aChildView->outputStream()) ;
}?>
