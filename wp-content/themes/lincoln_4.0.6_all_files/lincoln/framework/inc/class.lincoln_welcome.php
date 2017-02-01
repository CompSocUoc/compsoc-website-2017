<?php


class lincoln_welcome {
	/**
	 * Variable to hold the initialization state.
	 *
	 * @var  boolean
	 */
	protected static $initialized = false;

	/**
	 * Initialize welcome functions.
	 *
	 * @return  void
	 */
	public static function initialize() {
		// Do nothing if pluggable functions already initialized.
		if ( self::$initialized ) {
			return;
		}

		// Add action to enqueue scripts.
		add_action( 'admin_enqueue_scripts'		 			    , array( __CLASS__, 'enqueue_scripts' ) );
		add_action( 'admin_head'				 			    , array( __CLASS__, 'lincoln_install_plugin_js') );
	}

	/**
	 * Render custom style.
	 *
	 * @return  void
	 */
	public static function enqueue_scripts() {
		global $pagenow;

		if ( $pagenow == 'admin.php' && isset( $_GET['page'] ) && $_GET['page'] == 'lincoln-welcome' ) {
			// Load ThickBox.

			add_thickbox();

			wp_enqueue_style( 'admin-style', K2T_FRAMEWORK_URL . 'assets/css/admin-style.css' );

			wp_enqueue_style ( 'lincoln-welcome-css'	, get_template_directory_uri()  . '/framework/assets/css/welcome.min.css' );

			wp_enqueue_style ( 'lincoln-icon', get_template_directory_uri()  . '/assets/css/vendor/font-awesome.min.css' );

			wp_enqueue_script( 'lincoln-welcome-js'	, get_template_directory_uri()  . '/framework/assets/js/welcome.js'		, array( 'jquery' ) 	, false, true );
			wp_enqueue_script( 'smof'				, get_template_directory_uri()  . '/framework/assets/js/smof.js'			, array( 'jquery' )		, false, true );
			wp_enqueue_script( 'cookie'				, K2T_FRAMEWORK_URL 		. 'assets/js/cookie.js'						, array()				, '', true );
			wp_enqueue_script( 'jquery-isotope'		, K2T_THEME_URL 			. '/assets/js/vendor/isotope.pkgd.min.js'	, array()				, '', true );

			// Enqueue colorpicker scripts for versions below 3.5 for compatibility
			if ( ! wp_script_is( 'wp-color-picker', 'registered' ) ) {
				wp_register_script( 'iris', K2T_FRAMEWORK_URL .'assets/js/iris.min.js', array( 'jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch' ), false, 1 );
				wp_register_script( 'wp-color-pick er', K2T_FRAMEWORK_URL .'assets/js/color-picker.min.js', array( 'jquery', 'iris' ) );
			}

			wp_enqueue_script( 'wp-color-picker' );

		}
	}

	/**
	 * home url 
	 *
	 * @return  void
	 */

	public static function lincoln_install_plugin_js() { 
		global $pagenow;

		if ( $pagenow == 'admin.php' && isset( $_GET['page'] ) && $_GET['page'] == 'lincoln-welcome' ) {
			echo '<scr' . 'ipt>';
			echo 'var home_url = "' . esc_url( site_url() ) . '";';
			echo '</scr' . 'ipt>';
		}
	}

	/**
	 * Render HTML of intro tab.
	 *
	 * @return  string
	 */
	public static function html() {

		// Link 4 iconbox

		$doc = 'http://docs.lunartheme.com/lincoln';
		$video = '#';
		$changelog = 'http://lunartheme.com/change-logs-lincoln-wordpress/';
		$knowledge = 'http://lunartheme.com/faqs/';
		$support = 'http://support.lunartheme.com/';


		?>
		<div class="wrap before-start">
			<h1></h1>
		</div>

		<div class="wrap ln-wrap">
			<?php 

			?>
			<div class="ln-banner">
				<img class="logo" src="<?php echo K2T_FRAMEWORK_URL . 'assets/images/logo-x3.png'; ?>" alt="logo" />
				<h1 class="intro-title">
					<?php echo esc_html__('Welcome to', 'k2t');  ?>
					<span>	<?php echo esc_html__('Lincoln WP Theme', 'k2t');  ?> </span>
				</h1>
				<div id="k2t_social-2" class="widget social"><ul class="align-left"><li class="twitter"><a target="_blank" href="https://twitter.com/lunartheme"><i class="fa fa-twitter"></i></a></li><li class="facebook"><a target="_blank" href="https://facebook.com/lunartheme"><i class="fa fa-facebook"></i></a></li><li class="instagram"><a target="_blank" href="https://instagram.com/lunar.theme"><i class="fa fa-instagram"></i></a></li><li class="google"><a target="_blank" href="https://plus.google.com/106928793355725105766/"><i class="fa fa-google-plus"></i></a></li><li class="pinterest"><a target="_blank" href="https://pinterest.com/lunartheme"><i class="fa fa-pinterest"></i></a></li></ul></div>
			</div>

			<div class="ln-content">

				<div class="ln-intro row">

					<!-- Left content -->

					<div class="col-md-6 left">

						<div class="row">

							<div class="col-md-4">
								<div class="icon-box">
									<img src="<?php echo K2T_FRAMEWORK_URL . 'assets/images/wl-icon/document.png'; ?>" alt="icon">
									<h3><a class="anchor" href="#demos" title="support-link">Install Demo</a></h3>
									<span>Get your website installed like demo</span>
								</div>
							</div>
							<!-- End col -->

							<div class="col-md-4">
								<div class="icon-box">
									<img src="<?php echo K2T_FRAMEWORK_URL . 'assets/images/wl-icon/document.png'; ?>" alt="icon">
									<h3><a href="<?php echo $doc;?>" title="document-link">Documentation</a></h3>
									<span> Providing detailed & helpful guides</span>
								</div>
							</div>
							<!-- End col -->

							<div class="col-md-4">
								<div class="icon-box video">
									<img src="<?php echo K2T_FRAMEWORK_URL . 'assets/images/wl-icon/video.png'; ?>" alt="icon">
									<h3><a href="<?php echo $video;?>" title="video-link">Video tutorial</a></h3>
									<span>Watch informative tutorial videos</span>
								</div>
							</div>
							<!-- End col -->

							<div class="col-md-4">
								<div class="icon-box">
									<img src="<?php echo K2T_FRAMEWORK_URL . 'assets/images/wl-icon/knowledge-base.png'; ?>" alt="icon">
									<h3><a href="<?php echo $knowledge;?>" title="knowledge-link">Knowledge base</a></h3>
									<span>Clear up all theme questions</span>
								</div>
							</div>
							<!-- End col -->

							<div class="col-md-4">
								<div class="icon-box">
									<img src="<?php echo K2T_FRAMEWORK_URL . 'assets/images/wl-icon/change-log.png'; ?>" alt="icon">
									<h3><a href="<?php echo $changelog;?>" title="changelog-link">View changelog detail</a></h3>
									<span>See all the history of theme updates</span>
								</div>
							</div>
							<!-- End col -->

							<div class="col-md-4">
								<div class="icon-box">
									<img src="<?php echo K2T_FRAMEWORK_URL . 'assets/images/wl-icon/document.png'; ?>" alt="icon">
									<h3><a href="<?php echo $support;?>" title="support-link">Ticket system</a></h3>
									<span>Meet our technicians for supports</span>
								</div>
							</div>
							<!-- End col -->

						</div> <!-- .row -->

					</div>

					<!-- Right content -->

					<div class="col-md-6 right">

						<div class="row">

							<div class="col-md-6">
								<div class="info">
									<h3> Get started </h3>
									<p> <a href="<?php echo admin_url( 'admin.php?page=optionsframework' ) ?>"> Edit your site ( go to Theme option ) </a> </p>
									<p> <a class="anchor" href="#demos"> Install Sample Data like our demo </a> </p>
									<p> <a href="<?php echo admin_url( 'admin.php?page=tgmpa-install-plugins&plugin_status=install' ); ?>"> Install all plugins  </a> </p>
									<p> <a href="http://lunartheme.com/lincoln-promotions-month/"> Subscribe newsletters to receive the latest promotion </a> </p>
									<h3> Next Steps </h3>
									<p> <a href="http://docs.lunartheme.com/lincoln"> Read our Documentation </a> </p>
									<p> <a href="http://support.lunartheme.com/"> Request Support </a> </p>
									<p> <a href="http://lunartheme.com/faqs/"> Our Knowledge Base </a> </p>
									<p> <a href="http://lunartheme.com/change-logs-lincoln-wordpress/"> View Changelog Details </a> </p>
								</div>
							</div>

							<div class="col-md-6">
								<div class="logo-banner" style="background-image: url('<?php echo esc_url( K2T_FRAMEWORK_URL . "assets/images/plugins/logo-banner.png" );?>'" >
								</div>
							</div>
						</div> <!-- .row -->

					</div>

				</div> <!-- End ln intro -->

			</div><!-- .ln-content -->


			<div id="tabs-container" role="tabpanel">
				<h2 class="nav-tab-wrapper">
					<a class="nav-tab active" href="#demos"><?php esc_html_e( 'Sample Data', 'k2t' ); ?></a>
					<a class="nav-tab" href="#plugins-required"><?php esc_html_e( 'Plugins Required', 'k2t' ); ?></a>
					<a class="nav-tab" href="#plugins-3rd"><?php esc_html_e( 'Plugins Recommended', 'k2t' ); ?></a>
					<a class="nav-tab" href="#promotion"><?php esc_html_e( 'Promotion', 'k2t' ); ?></a>
				</h2>
				<div class="tab-content">
					<?php
					self::install_demos_html();
					self::install_plugins_html();
					self::promotion_html();
					//self::registration_html();
					//self::support_html();
					?>
				</div><!-- .tab-content -->
			</div>
		</div><!-- .lincoln-wrap -->
		<?php
	}

	/**
	 * Render HTML of sample data tab.
	 *
	 * @return  string
	 */

	protected static function promotion_html() { 

		$promotion = 'http://lunartheme.com/lincoln-promotions-month/';?>

		<div id="promotion" class="tab-pane" role="tabpanel">
			<div class="welcome-panel panel-small">
				<p><?php 
					echo wp_kses_post( 'Promotion: In this "Promotion" section, we provide all the fixed promotions for our existing customers and also other amazing offers for anyone interested in participating.', 'k2t' ); 
					echo '<a href="' . esc_url( 'http://lunartheme.com/lincoln-promotions-month/' ) . '"> ' . esc_html__('Subscribe to our newsletters', 'k2t') . '</a>' . esc_html__( 'to unlock the gifts. For the Free 3 months Hosting Promotion, besides subscribe to our newsletters, you also need to send us the  information of your account (admin & password) and which domain hosting you want to install your website. 
There will be a steady stream of promotions throughout the year, 2016 has been and will continue to be a busy year for us and we value your support.', 'k2t');
					?>
				</p>
			</div>
			<div class="row">
				<div class="col-md-12">
					<a class="button-primary" href="http://lunartheme.com/lincoln-promotions-month/"><?php esc_html_e( 'Get Promotion', 'k2t'); ?></a>
				</div>
			</div> <!-- .row -->

			<div class="row">

				<div class="col-md-3">
					<img src="http://main.lunartheme.com/images/lincoln/promotion-2.jpg" atl="promotion-2">
				</div> <!-- .col-md-4 -->

				<div class="col-md-3">
					<img src="http://main.lunartheme.com/images/lincoln/promotion-4.jpg" atl="promotion-4">
				</div> <!-- .col-md-4 -->

				<div class="col-md-3">
					<img src="http://main.lunartheme.com/images/lincoln/promotion-1.jpg" atl="promotion-1">
				</div> <!-- .col-md-4 -->

				<div class="col-md-3">
					<img src="http://main.lunartheme.com/images/lincoln/promotion-3.jpg" atl="promotion-3">
				</div> <!-- .col-md-4 -->

			</div> <!-- .row -->
		</div><!-- #plugins required --> <?php
	}

	/**
	 * Render HTML of sample data tab.
	 *
	 * @return  string
	 */
	protected static function install_demos_html() { 

		$link_demo = array( 
			array( 
				'Lite Database Version',
				'http://demo.lunartheme.com/lincoln/',
				'Placeholder',
			),
			array(
				'Full Database Version',
				'http://demo.lunartheme.com/lincoln/',
				'Linked Images',
			)
		);


		?>

		<div id="demos" class="tab-pane active" role="tabpanel"> 

			<div class="welcome-panel panel-small">
				<p>Install Demo Data: If you're interested in installing your website exactly like our demo, then to make your WordPress site journey using our theme even more easier, we now provide you One-click Install - Get your Fitness WP Theme installed in just one click! With the help of our Oneclick Install, you can quickly duplicate your site as our demo. The demo content includes all posts, pages, widgets, theme options settings and menus. The process is seamless and just takes few minutes.</p>
			</div>

		<?php 
		 /* format setting outer wrapper */
			$link_content_backup = K2T_FRAMEWORK_URL . "assets/images/lincoln_data";
			$data_demo = json_decode( '{"vers_cats":{"lincoln":"Lincoln"},"versions":{"lincoln_1":{"home_id":5,"title":"Lincoln Lite Database","cat":"lincoln"},"lincoln_2":{"home_id":5,"title":"Lincoln Full Database","cat":"lincoln"}}}' );
			$vers_cats = !empty( $data_demo->vers_cats ) ? $data_demo->vers_cats : '';
			$versions = !empty( $data_demo->versions ) ? $data_demo->versions : '';
			//print_r($vers_cats);
			$output = '
			<div class="format-setting type-backup">';
			$demo_data_installed = get_option('k2t_demo_data_installed');
			$button_label = esc_html__('Install base demo content', 'k2t');
			if($demo_data_installed != 'yes') {
				$output .= '<a href="javascript:void(0)" class="button" id="k2t_install_demo_pages" >'. $button_label .'</a>';
				$output .= '								<div class="advance_import_export_popup" style="display:block">

							<div class="advance_backup_data_popup" id="advance_backup_data_popup_for_advance_backup_section_2" advance_backup-options-popup-name="advance_backup_section_2">

								<div class="notice_popup">
									<p>Choise one type : </p>
									<select class="notice_popup_choise">
										<option value="save_to_back_up_list">Save to Backup list</option>
										<option value="restore">Restore</option>
										<option value="restore_and_save_to_backup_list">Restore and Save to Backup list</option>
									</select>
									<button style="margin:0;margin-left:0px; margin-top:10px;" class="button notice_popup_choise_cancel" type="button" onclick="">Cancel</button>
									<button style="margin:0;margin-left:0px; margin-top:10px;" class="button-primary notice_popup_choise_accept" type="button" onclick="">Accept</button>
								</div>

								<div class="advance_backup_data_popup_content">
									<!--
									POPUP CLOSE
									-->
									<div class="k2t_advance_backup_data_popup_control_close"><i class="fa fa-close"></i></div>

									<!--
									POPUP FOR LIST
									-->
									<div class="k2t_advance_backup_data_popup_content_list" style="display:block">
										<!--
										POPUP LOADING
										-->
										<div class="head_data_popup_loading"></div>
										<h3 class="advance_backup_data_popup_content_heading">Install Sample Data</h3>
										<div class="advance_backup_data_popup_step_1" style="display:block">
											<p>This installation will make your website look the same as <a href="http://demo.lunartheme.com/lincoln">Lincoln WordPress Theme for Education</a></p>
											<div class="advance_backup_data_wrong">
												<span class="advance_backup_data_hilight_red">Important Information</span>
												<ul>
													<li><i class="dashicons dashicons-arrow-right" style="color: #056b16;margin-right:5px;"></i>The installation process will delete all data on this website.</li>
													<li><i class="dashicons dashicons-arrow-right" style="color: #056b16;margin-right:5px;"></i>It\'s not recommended to install sample data on production website.</li>
													<li><i class="dashicons dashicons-arrow-right" style="color: #056b16;margin-right:5px;"></i>All required plugins of this theme will be automatically installed and activated.</li>
													<li><i class="dashicons dashicons-arrow-right" style="color: #056b16;margin-right:5px;"></i>During the installation process, please do not close window.</li>
												<ul>

											</div>
											<div style="margin-bottom:10px;display:none;">
												<input style="width:inherit;margin-bottom:0px !important" class="drop_all_old_data" type="checkbox" onclick="" value="0" id="drop_all_old_data" checked><label for = "drop_all_old_data">Enable Drop All Old Data</label>
											</div>
											<div style="margin-bottom:30px;">
												<input style="width:15px;height:15px;margin-bottom:0px !important" class="agree" type="checkbox" onclick="" value="0" id="agree_backup_args"><label for = "agree_backup_args">I agree with all alert information and backup data</label>
											</div>
										</div>
										<div class="advance_backup_data_popup_step_2" style="display:none">
											<p>Installing!!! Please Don\'t close web browser before install finish.</p>
											<div class="advance_backup_data_wrong">
												<span class="advance_backup_data_hilight_green">Installing Process : </span>
												<ul>
													<li id="process_install_active_plugin"  style="display:none"><i class="dashicons dashicons-yes" style="color: #056b16;margin-right:5px;"></i>Installed and Actived all require plugins...</li>
													<li id="process_backup_theme_options"  style="display:none"><i class="dashicons dashicons-yes" style="color: #056b16;margin-right:5px;"></i>Backup theme options done...</li>
													<li id="process_backup_widget"  style="display:none"><i class="dashicons dashicons-yes" style="color: #056b16;margin-right:5px;"></i>Backup widget done..</li>
													<li  id="process_upload_database"  style="display:none"><i class="dashicons dashicons-yes" style="color: #056b16;margin-right:5px;"></i>Uploading Database....</li>
													<li  id="process_upload_asset"  style="display:none"><i class="dashicons dashicons-yes" style="color: #056b16;margin-right:5px;"></i>Uploading Asset....</li>
													<li id="process_reconfig_setting"  style="display:none"><i class="dashicons dashicons-yes" style="color: #056b16;margin-right:5px;"></i>Reconfig setting and clear cache...</li>
													<li  id="proces_done"  style="display:none"><i class="dashicons dashicons-yes" style="color: #056b16;margin-right:5px;"></i>Backup Finish.Go click <a href="'.esc_url( site_url() ).'" target"_blank">Here</a> to see your site...</li>
												<ul>

											</div>
										</div>

									</div>
									<style>
										.dashicons.dashicons-update{
												color: #056b16;margin-right:5px;
												-moz-animation: spinoff .5s infinite linear;
												-webkit-animation: spinoff .5s infinite linear;
										}
									</style>
									<div class="advance_backup_data_popup_control" style="">
										<div class="abop_control" style="float:left;">
											<div class="process_percent_container" style="display:none;">
												<div class="process_percent" style="width:0%;"><span>Installing... 0%</span></div>
											</div>
										</div>
										<div class="abop_control" style="float:right;">
											<button style="margin:0;margin-top:10px; margin-right:10px;" class="button submit-button advance_backup_data_popup_control_start" type="button" onclick="">Start importing now</button>
											<button style="margin:0;margin-top:10px; margin-right:10px; display:none" class="button submit-button advance_backup_data_popup_control_cancel" type="button" onclick="">Close</button>
										</div>
									</div>
								</div>
							</div>
						</div>';
			}
			else {
				$output .= '
				<div class="clear"></div>
				<br />
				<p>' . wp_kses(_e('<strong>Note:</strong> You have already installed base demo content.', 'k2t'), array( 'strong' => array() ) ) .'</p>';
			}
			$output .= '
			<div class="clear"></div>
			<br />
			<div class="format-setting-label"><h3 class="label">Set up one of our theme versions</h3></div>
			<div class="ver-install-result"></div>
			<div class="sort_data_ver">
			<ul class="versions-filters">
				<li>
					<a class="anchor-link" href="#" data-filter="*" class="button active">All</a>
				</li>';
				if ( count( $vers_cats ) > 0 ){

					foreach($vers_cats as $slug => $name):
						$output .= '
						<li>
							<a href="#" data-filter=".sort-'.$slug.'" class="button">'.$name.'</a>
						</li>';
					endforeach;
				}
			$output .= '</ul>';
			$output .= '<div class="k2t-theme-versions">';
				if (  count( $versions ) > 0 ){
					$i = 0;
					foreach($versions as $key => $v):
						$desc = '';
						if ( !empty( $link_demo[$i][2] ) ) $desc = '<span class="des">' . $link_demo[$i][2] . '</span>';

						$output .= ' <div class="col-md-4 theme-ver sort-'.$v->cat.'"><div class="wrap-inner">';
							$output .= '<a class="link-demo" target="_blank" href="' . $link_demo[ $i ][1] . '"><img src="'.esc_url( $link_content_backup.'/lincoln/'.$key.'/'.$key.'.jpg' ) .'"><span class="ver">' . $link_demo[ $i ][0] . '</span> ' . $desc . ' </a>';
							$output .= '<button class="button-primary install-ver" data-type_name="' . $v->cat . '"  data-ver="'.$key.'" data-home_id="'.$v->home_id.'">Install</button>';
							$output .= '<h4>'.$v->title.'</h4>';
						$output .= '</div></div>';
						$i++;
					endforeach;
				}
			$output .= '</div></div>';

			$output .= '</div>'; 

			echo $output;
			?>

		</div>
		<?php
	}

	/**
	 * Render HTML of plugins tab.
	 *
	 * @return  string
	 */

	protected static function install_plugins_html() {

		$activate_nonce = wp_create_nonce( 'tgmpa-activate' );

		$install_nonce = wp_create_nonce( 'tgmpa-install' );

		$uninstall_nonce = wp_create_nonce( 'uninstall-nonce' );	

		$plugins = array(
			array(
				'name'           => esc_html__( 'Visual Composer','k2t' ),
				'slug'           => 'js_composer',
				'source'         => K2T_FRAMEWORK_PATH . 'extensions/plugins/js_composer.zip',
				'required'       => true,
				'file'	         => 'js_composer.php',
				'activate_nonce' => $activate_nonce,
				'install_nonce'  => $install_nonce,
				'uninstall_nonce'=> $uninstall_nonce,
	            'redirect'       => true,
	            'thumb'			 => 'vc.jpg',
	            'link'			 => '',
			),
			array(
				'name'           => esc_html__( 'Advanced Custom Fields Pro','k2t' ),
				'slug'           => 'advanced-custom-fields-pro',
				'source'         => K2T_FRAMEWORK_PATH . 'extensions/plugins/advanced-custom-fields-pro.zip',
				'required'       => true,
				'file'	         => 'acf.php',
				'activate_nonce' => $activate_nonce,
				'install_nonce'  => $install_nonce,
				'uninstall_nonce'=> $uninstall_nonce,
				'thumb'			 => 'acf.jpg',
				'link'			 => '',
			),
			array(
				'name'           => esc_html__( 'Envato Market','k2t' ),
				'slug'           => 'envato-market',
				'source'         => K2T_FRAMEWORK_PATH . 'extensions/plugins/envato-market.zip',
				'required'       => true,
				'file'	         => 'envato-market.php',
				'activate_nonce' => $activate_nonce,
				'install_nonce'  => $install_nonce,
				'uninstall_nonce'=> $uninstall_nonce,
				'thumb'			 => 'envato.jpg',
				'link'			 => '',
			),
			array(
				'name'           => esc_html__( 'K Shortcodes','k2t' ),
				'slug'           => 'k-shortcodes',
				'source'         => K2T_FRAMEWORK_PATH . 'extensions/plugins/k-shortcodes.zip',
				'required'       => true,
				'file'	         => 'init.php',
				'activate_nonce' => $activate_nonce,
				'install_nonce'  => $install_nonce,
				'uninstall_nonce'=> $uninstall_nonce,
				'thumb'			 => '',
				'icon'			 => 'fa fa-code',
				'link'			 => '',
			),
			array(
				'name'     		 => esc_html__( 'K Teacher','k2t' ),
				'slug'     		 => 'k-teacher',
				'source'   		 => K2T_FRAMEWORK_PATH . 'extensions/plugins/k-teacher.zip',
				'required' 		 => false,
				'file'	         => 'hooks.php',
				'activate_nonce' => $activate_nonce,
				'install_nonce'  => $install_nonce,
				'uninstall_nonce'=> $uninstall_nonce,
				'thumb'			 => '',
				'icon'			 => 'fa awesome-users',
				'link'			 => '',
			),
			array(
				'name'     		 => esc_html__( 'K Courses','k2t' ),
				'slug'     		 => 'k-course',
				'source'   		 => K2T_FRAMEWORK_PATH . 'extensions/plugins/k-course.zip',
				'required' 		 => false,
				'file'	         => 'hooks.php',
				'activate_nonce' => $activate_nonce,
				'install_nonce'  => $install_nonce,
				'uninstall_nonce'=> $uninstall_nonce,
				'thumb'			 => '',
				'icon'			 => 'fa awesome-leanpub',
				'link'			 => '',
			),
			array(
				'name'     		 => esc_html__( 'K Event','k2t' ),
				'slug'     		 => 'k-event',
				'source'   		 => K2T_FRAMEWORK_PATH . 'extensions/plugins/k-event.zip',
				'required' 		 => false,
				'file'	         => 'hooks.php',
				'activate_nonce' => $activate_nonce,
				'install_nonce'  => $install_nonce,
				'uninstall_nonce'=> $uninstall_nonce,
				'thumb'			 => '',
				'icon'			 => 'fa awesome-calendar',
				'link'			 => '',
			),
			array(
				'name'     		 => esc_html__( 'K Gallery','k2t' ),
				'slug'     		 => 'k-gallery',
				'source'   		 => K2T_FRAMEWORK_PATH . 'extensions/plugins/k-gallery.zip',
				'required' 		 => false,
				'file'	         => 'init.php',
				'activate_nonce' => $activate_nonce,
				'install_nonce'  => $install_nonce,
				'uninstall_nonce'=> $uninstall_nonce,
				'thumb'			 => '',
				'icon'			 => 'fa fa-picture-o',
				'link'			 => '',
			),
			array(
				'name'     		 => 'K Project',
				'slug'     		 => 'k-project',
				'source'   		 => K2T_FRAMEWORK_PATH . 'extensions/plugins/k-project.zip',
				'required' 		 => false,
				'file'	         => 'init.php',
				'activate_nonce' => $activate_nonce,
				'install_nonce'  => $install_nonce,
				'uninstall_nonce'=> $uninstall_nonce,
				'thumb'			 => '',
				'icon'			 => 'fa fa-tasks',
				'link'			 => '',
			),
			array(
				'name'           => esc_html__( 'Revolution Slider','k2t' ),
				'slug'           => 'revslider',
				'source'         => K2T_FRAMEWORK_PATH . 'extensions/plugins/revslider.zip',
				'required'       => false,
				'file'	         => 'revslider.php',
				'activate_nonce' => $activate_nonce,
				'install_nonce'  => $install_nonce,
				'uninstall_nonce'=> $uninstall_nonce,
				'thumb'			 => 'rev.jpg',
				'link'			 => '',
			),

			array(
				'name'           => esc_html__( 'WooCommerce','k2t' ),
				'slug'           => 'woocommerce',
				'required'       => false,
				'file'	         => 'woocommerce.php',
				'activate_nonce' => $activate_nonce,
				'install_nonce'  => $install_nonce,
				'uninstall_nonce'=> $uninstall_nonce,
				'source'         => '',
	            'redirect'       => true,
	            'thumb'			 => 'wc.jpg',
	            'link'			 => '',
			),
			array(
				'name'           => esc_html__( 'YITH WooCommerce Wishlist','k2t' ),
				'slug'           => 'yith-woocommerce-wishlist',
				'required'       => false,
				'file'	         => 'init.php',
				'activate_nonce' => $activate_nonce,
				'install_nonce'  => $install_nonce,
				'uninstall_nonce'=> $uninstall_nonce,
				'source'         => '',
				'thumb'			 => 'wl.jpg',
				'link'			 => '',
				'redirect'		 => true,
			),
			array(
				'name'   	     => esc_html__( 'Instagram Feed','k2t' ),
				'slug'    		 => 'instagram-feed',
				'required' 		 => false,
				'file'	         => 'instagram-feed.php',
				'activate_nonce' => $activate_nonce,
				'install_nonce'  => $install_nonce,
				'uninstall_nonce'=> $uninstall_nonce,
				'source'         => '',
				'thumb'			 => 'instargram.jpg',
				'link'			 => '',
				'redirect'		 => true,
			),
			array(
				'name'     		 => esc_html__( 'Contact form 7','k2t' ),
				'slug'     		 => 'contact-form-7',
				'required' 		 => false,
				'file'	         => 'wp-contact-form-7.php',
				'activate_nonce' => $activate_nonce,
				'install_nonce'  => $install_nonce,
				'uninstall_nonce'=> $uninstall_nonce,
				'source'         => '',
				'thumb'			 => 'contact-7.jpg',
				'link'			 => '',
				'redirect'		 => true,
			),
		);

		?>
		<div id="plugins-required" class="tab-pane" role="tabpanel">
			<div class="welcome-panel panel-small">
				<p><?php echo wp_kses_post( 'Once you\'re done with activating theme, you need to install all the recommended plugins. Below you can see the list of some important plugins that will need to be installed and activated. They were made especially for Lincoln theme and others from 3rd party developers: K Shortcodes, Visual Composer, Advanced Custom Fields Pro. They are required for the theme to work, it contains all of our theme features like shortcodes and shortcode generator, page builder, etc.', 'k2t' ); ?></p>
				<?php echo sprintf( '<a target="_blank" class="button button-primary install-all-plugin" href="%s">' . __( 'Install All Plugins', 'k2t' ) . '</a>', admin_url( 'admin.php?page=tgmpa-install-plugins&plugin_status=install' ) ); ?>
			</div>

			<div class="row isotope">
				<?php self::listing_plugins( $plugins, true ); ?>
			</div> <!-- .row -->
		</div><!-- #plugins required -->


		<div id="plugins-3rd" class="tab-pane" role="tabpanel">
			<div class="welcome-panel panel-small">
				<p><?php echo wp_kses_post( 'Once you have installed and activated all the required plugins, the theme is now working but not fully functional. You will be prompted to install recommended plugins. Just click the "Install" button down below for each plugin to begin installing all the recommended plugins for your website. When you install Lincoln, you will get a notification message in your WordPress admin telling you of the required and recommended plugins.', 'k2t' ); ?></p>
				<?php echo sprintf( '<a target="_blank" class="button button-primary install-all-plugin" href="%s">' . __( 'Install All Recommended Plugins', 'k2t' ) . '</a>', admin_url( 'admin.php?page=tgmpa-install-plugins&plugin_status=install' ) ); ?>
			</div>

			<div class="row isotope ">
				<?php self::listing_plugins( $plugins, false ); ?>
			</div> <!-- .row -->
		</div><!-- #plugins required -->

		<?php
	}

	/**
	 * Render HTML of plugins required or 3rd party.
	 *
	 * @return  void
	 */

		protected static function listing_plugins( $plugins, $required = false ) {
		$output = '';

		foreach ( $plugins as $key => $plugin) : 

			if ( ( $required && !empty( $plugin['required'] ) ) || ( ! $required && ( !isset( $plugin['required'] ) || empty( $plugin['required'] ) ) ) ) :

				$is_active = ! is_plugin_active( $plugin["slug"]. '/' . $plugin["file"] )  ? 'install' : 'uninstall';

				$data_attr = '';

				foreach ($plugin as $key => $value) {	
					$data_attr .= 'data-' . $key . '="' . $value . '" ';
				}

				$thumb_html = '<img src="' . K2T_FRAMEWORK_URL . 'assets/images/plugins/' .  ( !empty( $plugin['thumb'] ) ? $plugin['thumb'] : 'place-holder.jpg' ) . '" alt="plugin-thumb">';
				$icon_html  =  isset( $plugin['icon'] ) && !empty( $plugin['icon'] ) ? '<div class="wrap-icon"><span class="' . $plugin['icon'] . '"></span><span class="name">' . $plugin['name'] . '</span></div>' : '';

				$is_active .=  isset($plugin['thumb']) || empty($plugin['thumb']) ? ' no-thumb' : '';
				// out put 

				$output .= '<div class="col-md-3">';
					$output .= '<div class="plugin-item ' . $is_active . '"' . $data_attr . '>';

						$output .= '<div class="thumb">';
							$output .= !empty( $plugin['link'] ) ? '<a href="' . $plugin['link'] . '" >' : '';
							$output .= $thumb_html . $icon_html ;
							$output .= !empty( $plugin['link'] ) ? '</a>' : '';
						$output .= '</div>';							// End thumb

						$output .= '<div class="wrap-info">';

							$output .= '<h3>' . $plugin['name'] . '</h3>';

							$output .= '<div class="wrap-btn">';
								$output .= '<button class="button button-primary plugin-install install" data-plugin="' . $plugin['slug'] . '">' . esc_html__('Install') . '</button>';
								$output .= '<button class="button button-primary plugin-install" data-plugin="' . $plugin['slug'] . '">' . esc_html__('Uninstall') . '</button>';
								$output .= '<span class="spinner"></span>';
							$output .= '</div>';						// wrap btn 
						$output .= '</div>';							// wrap info

					$output .= '</div>'; 								// End plugin Item
				$output .= '</div>'; 									// End col 

			endif;

		endforeach;

		echo $output;
	}

}