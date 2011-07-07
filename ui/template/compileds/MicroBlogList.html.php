<?php
				$__foreach_Arr_var0 = eval("if(!isset(\$__uivar_theModel)){ \$__uivar_theModel=&\$aVariables->getRef('theModel') ;};
return \$__uivar_theModel->childIterator();");
				if(!empty($__foreach_Arr_var0)){ 
					$__foreach_idx_var3 = -1;
					foreach($__foreach_Arr_var0 as $__foreach_key_var2 => &$__foreach_item_var1){
						$__foreach_idx_var3++;
						 $aVariables->set("row",$__foreach_item_var1 ); ?>					
			<?php echo eval("if(!isset(\$__uivar_row)){ \$__uivar_row=&\$aVariables->getRef('row') ;};
return \$__uivar_row->child('userto')->data('username');") ;?>:<?php echo eval("if(!isset(\$__uivar_row)){ \$__uivar_row=&\$aVariables->getRef('row') ;};
return \$__uivar_row->data('text');") ;?>  <a href="?c=microblog.MicroBlogDelete&id=<?php echo eval("if(!isset(\$__uivar_row)){ \$__uivar_row=&\$aVariables->getRef('row') ;};
return \$__uivar_row->data('mbid');") ;?>">删除</a>   <a href="?c=microblog.MicroBlogForward&id=<?php echo eval("if(!isset(\$__uivar_row)){ \$__uivar_row=&\$aVariables->getRef('row') ;};
return \$__uivar_row->data('mbid');") ;?>">转发</a>    <a href="?c=microblog.MicroBlogReview&id=<?php echo eval("if(!isset(\$__uivar_row)){ \$__uivar_row=&\$aVariables->getRef('row') ;};
return \$__uivar_row->data('mbid');") ;?>">评论</a><br />
			<?php if(eval("if(!isset(\$__uivar_row)){ \$__uivar_row=&\$aVariables->getRef('row') ;};
return \$__uivar_row->data('forward')!=0;")){ ?>
				<?php
				$__foreach_Arr_var4 = eval("if(!isset(\$__uivar_theModel)){ \$__uivar_theModel=&\$aVariables->getRef('theModel') ;};
return \$__uivar_theModel->childIterator();");
				if(!empty($__foreach_Arr_var4)){ 
					$__foreach_idx_var7 = -1;
					foreach($__foreach_Arr_var4 as $__foreach_key_var6 => &$__foreach_item_var5){
						$__foreach_idx_var7++;
						 $aVariables->set("row1",$__foreach_item_var5 ); ?>
					<?php if(eval("if(!isset(\$__uivar_row)){ \$__uivar_row=&\$aVariables->getRef('row') ;};
if(!isset(\$__uivar_row1)){ \$__uivar_row1=&\$aVariables->getRef('row1') ;};
return \$__uivar_row->data('forward')==\$__uivar_row1->data('mbid');")){ ?>
					&nbsp;&nbsp;&nbsp;<?php echo eval("if(!isset(\$__uivar_row1)){ \$__uivar_row1=&\$aVariables->getRef('row1') ;};
return \$__uivar_row1->child('userto')->data('username');") ;?>:<?php echo eval("if(!isset(\$__uivar_row1)){ \$__uivar_row1=&\$aVariables->getRef('row1') ;};
return \$__uivar_row1->data('text');") ;?>  <a href="?c=microblog.MicroBlogForward&id=<?php echo eval("if(!isset(\$__uivar_row1)){ \$__uivar_row1=&\$aVariables->getRef('row1') ;};
return \$__uivar_row1->data('mbid');") ;?>">原文转发</a>    <a href="?c=microblog.MicroBlogReview&id=<?php echo eval("if(!isset(\$__uivar_row1)){ \$__uivar_row1=&\$aVariables->getRef('row1') ;};
return \$__uivar_row1->data('mbid');") ;?>">原文评论</a><br />
					<?php } ?>
				<?php 
					}
				}
			 		?>
			<?php } ?>
			
<?php 
					}
				}
			 		?>