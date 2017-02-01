<div class="wrap" id="of_container">

	<div id="of-popup-save" class="of-save-popup">
		<div class="of-save-save">Options Updated</div>
	</div>
	
	<div id="of-popup-reset" class="of-save-popup">
		<div class="of-save-reset">Options Reset</div>
	</div>
	
	<div id="of-popup-fail" class="of-save-popup">
		<div class="of-save-fail">Error!</div>
	</div>
	
	<span style="display: none;" id="hooks"><?php echo json_encode(of_get_header_classes_array()); ?></span>
	<input type="hidden" id="reset" value="<?php if(isset($_REQUEST['reset'])) echo ( $_REQUEST['reset'] ); ?>" />
	<input type="hidden" id="security" name="security" value="<?php echo wp_create_nonce('of_ajax_nonce'); ?>" />

	<form id="of_form" method="post" action="<?php echo esc_attr( $_SERVER['REQUEST_URI'] ) ?>" enctype="multipart/form-data" >
	
		<div id="header">
		
			<div class="logo">
				<?php k2t_logo('','','', 'h1_header_'); ?>
				<span class="version"><?php echo ('v'. THEMEVERSION); ?></span>
			</div>

			<div id="info_bar">
		
				<a>
					<div id="expand_options" class="expand">Expand</div>
				</a>

				<img style="display:none" src="<?php echo K2T_FRAMEWORK_URL; ?>assets/images/loading-bottom.gif" class="ajax-loading-img ajax-loading-img-bottom" alt="Working..." />

				<a class="k2t-btn supp" href="http://support.lunartheme.com/">Support Forum</a>
				<a class="k2t-btn docs" href="http://docs.lunartheme.com/lincoln/">Documentation</a>
	            
				<button id="of_save" type="button" class="button-primary">
					<?php esc_html_e('Save All Changes', 'k2t');?>
				</button>

				<div class="mm-nav-btn hamburger hamburger--slider js-hamburger">
	        		<div class="hamburger-box">
	          			<div class="hamburger-inner"></div>
	        		</div>
	      		</div>
				
			</div><!--.info_bar--> 	

		
    	</div>
		
		<div id="main">
		
			<div id="of-nav">
				<ul>
				  <?php echo ( $options_machine->Menu ); ?>
				</ul>
			</div>

			<div id="content">
		  		<?php echo ( $options_machine->Inputs ); /* Settings */ ?>
		  	</div>
		  	
			<div class="clear"></div>
			
		</div>
		
		<div class="save_bar"> 
		
			<img style="display:none" src="<?php echo K2T_FRAMEWORK_URL; ?>assets/images/loading-bottom.gif" class="ajax-loading-img ajax-loading-img-bottom" alt="Working..." />
			
			<button id ="of_save" type="button" class="button-primary"><?php esc_html_e('Save All Changes', 'k2t');?></button>			
			<button id ="of_reset" type="button" class="button submit-button reset-button" ><?php esc_html_e('Options Reset', 'k2t');?></button>
			
		</div><!--.save_bar--> 
 
	</form>
	
	<div style="clear:both;"></div>

</div><!--wrap-->