<?php
/**
 * The header for theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Lincoln
 * @author  LunarTheme
 * @link	http://www.lunartheme.com
 */

// Get theme options
global $smof_data;

$classes = array();
$classRtl = array();
// Fixed header
if ( ! empty( $smof_data['fixed-header'] ) ) {
	$classes[] = 'fixed';
}
// Full width header
if ( ! empty( $smof_data['full-header'] ) ) {
	$classes[] = 'full';
}

if( isset( $smof_data['rtl_lang'] ) && $smof_data['rtl_lang'] == '1' ){
	$classRtl[] = 'rtl';
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> id="<?php echo esc_attr( implode( ' ', $classRtl ) ); ?>">

<?php if ( ! empty( $smof_data['pageloader'] ) ) : ?>
	<div id="loader-wrapper">
		<svg class="circular" height="50" width="50">
		  <circle class="path" cx="25" cy="25.2" r="19.9" fill="none" stroke-width="6" stroke-miterlimit="10" />
		</svg>
	</div>
<?php endif; ?>
	
<div class="k2t-container">

	<?php if ( ! is_404() ) : ?>
	<header class="k2t-header <?php echo esc_attr( implode( ' ', $classes ) ); ?>">
		
		<?php
			// Include top header layout
			if ( ! empty( $smof_data['use-top-header'] ) ) {
				include_once K2T_TEMPLATE_PATH . 'header/top.php';
			}

			// Include middle header layout
			if ( ! empty( $smof_data['use-mid-header'] ) ) {
				include_once K2T_TEMPLATE_PATH . 'header/mid.php';
			}

			// Include bottom header layout
			if ( ! empty( $smof_data['use-bot-header'] ) ) {
				include_once K2T_TEMPLATE_PATH . 'header/bot.php';
			}

			include_once K2T_TEMPLATE_PATH . 'header/responsive.php';
		?>

	</header><!-- .k2t-header -->
	<?php endif;?>

	<div class="k2t-body">

		<?php 
			if ( ! is_404() ) :
				if ( is_singular( 'post-k-event' ) || is_tax( 'k-event-category' ) || is_tax( 'k-event-tag' ) ) {
					get_template_part( 'templates/titlebar/event-title', 'bar' );
				} else if ( is_singular( 'post-k-teacher' ) || is_tax( 'k-teacher-category' ) ) {
					get_template_part( 'templates/titlebar/teacher-title', 'bar' );
				} else if ( is_singular( 'post-k-course' ) || is_tax( 'k-course-category' ) || is_tax( 'k-course-tag' ) ) {
					get_template_part( 'templates/titlebar/course-title', 'bar' );
				} else if ( is_singular( 'post-k-project' ) || is_tax( 'k-project-category' ) || is_tax( 'k-project-tag' ) ) {
					get_template_part( 'templates/titlebar/project-title', 'bar' );
				}elseif( is_singular('sfwd-courses') || is_singular('sfwd-lessons') || is_singular('sfwd-quiz') ){
					get_template_part( 'templates/titlebar/learndash-title', 'bar' );
				}
				else {
					get_template_part( 'templates/titlebar/title', 'bar' );
				}
			endif;
		?>