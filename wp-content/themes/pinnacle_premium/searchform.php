<?php global $pinnacle; if(!empty($pinnacle['search_placeholder_text'])) {$searchtext = $pinnacle['search_placeholder_text'];} else {$searchtext = __('Search', 'pinnacle');} ?>
<form role="search" method="get" class="form-search" action="<?php echo home_url('/'); ?>">
  <label>
  	<span class="screen-reader-text"><?php _e( 'Search for:', 'pinnacle' ); ?></span>
  	<input type="text" value="<?php if (is_search()) { echo get_search_query(); } ?>" name="s" class="search-query" placeholder="<?php echo $searchtext; ?>">
  </label>
  <button type="submit" class="search-icon"><i class="kt-icon-search4"></i></button>
</form>