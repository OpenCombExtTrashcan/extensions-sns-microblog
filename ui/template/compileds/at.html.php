<?php
				$__foreach_Arr_var0 = eval("if(!isset(\$__uivar_theModel)){ \$__uivar_theModel=&\$aVariables->getRef('theModel') ;};
return \$__uivar_theModel->childIterator();");
				if(!empty($__foreach_Arr_var0)){ 
					$__foreach_idx_var3 = -1;
					foreach($__foreach_Arr_var0 as $__foreach_key_var2 => &$__foreach_item_var1){
						$__foreach_idx_var3++;
						 $aVariables->set("row",$__foreach_item_var1 ); ?>					
			<?php echo eval("if(!isset(\$__uivar_row)){ \$__uivar_row=&\$aVariables->getRef('row') ;};
return \$__uivar_row->child('user')->data('username');") ;?>:<?php echo eval("if(!isset(\$__uivar_row)){ \$__uivar_row=&\$aVariables->getRef('row') ;};
return \$__uivar_row->child('microblog')->data('text');") ;?>  <a href="?c=microblog.forward&id=<?php echo eval("if(!isset(\$__uivar_row)){ \$__uivar_row=&\$aVariables->getRef('row') ;};
return \$__uivar_row->child('microblog')->data('mbid');") ;?>">转发</a>    <a href="?c=microblog.review&id=<?php echo eval("if(!isset(\$__uivar_row)){ \$__uivar_row=&\$aVariables->getRef('row') ;};
return \$__uivar_row->child('microblog')->data('mbid');") ;?>">评论</a><br />
			<?php if(eval("if(!isset(\$__uivar_row)){ \$__uivar_row=&\$aVariables->getRef('row') ;};
return \$__uivar_row->child('microblog')->data('forward')!=0;")){ ?>				
					&nbsp;&nbsp;&nbsp;<?php echo eval("if(!isset(\$__uivar_row)){ \$__uivar_row=&\$aVariables->getRef('row') ;};
return \$__uivar_row->child('microblog')->child('forward')->child('userto')->data('username');") ;?>:<?php echo eval("if(!isset(\$__uivar_row)){ \$__uivar_row=&\$aVariables->getRef('row') ;};
return \$__uivar_row->child('microblog')->child('forward')->data('text');") ;?>  <a href="?c=microblog.forward&id=<?php echo eval("if(!isset(\$__uivar_row)){ \$__uivar_row=&\$aVariables->getRef('row') ;};
return \$__uivar_row->child('microblog')->child('forward')->data('mbid');") ;?>">原文转发</a>    <a href="?c=microblog.review&id=<?php echo eval("if(!isset(\$__uivar_row)){ \$__uivar_row=&\$aVariables->getRef('row') ;};
return \$__uivar_row->child('microblog')->child('forward')->data('mbid');") ;?>">原文评论</a><br />
					
			<?php } ?>
			
<?php 
					}
				}
			 		?>