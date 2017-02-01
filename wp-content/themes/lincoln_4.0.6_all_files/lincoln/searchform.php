<?php
/**
 * Search form.
 *
 * @package Lincoln
 * @author  LunarTheme
 * @link	http://www.lunartheme.com
 */
?>
<form role="search" method="get" id="searchform" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div class="form-group">
		<input type="text" value="<?php echo get_search_query(); ?>" name="s" placeholder="<?php _e( 'Search keywords...', 'k2t' ); ?>" />
		<button type="submit" ><?php _e( 'Search', 'k2t' ); ?></button>
	</div>
</form>