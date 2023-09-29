<?php

/**
 * Prints the Koko Analytics tracking script.
 *
 * You should only need to call this manually if your theme does not use the `wp_head()` and `wp_footer()` functions.
 *
 * @since 1.0.25
 */
function koko_analyics_tracking_script() {
	$script_loader = new KokoAnalytics\Script_Loader();
	$script_loader->maybe_enqueue_script( true );
}

/**
 * Returns an array of the most viewed posts/pages or other post types.
 *
 * Arguments:
 *  `number`    => The number of results to return
 *  `post_type` => A single post type or an array of post types to return
 *  `days`      => Specified the last X number of days for which the most viewed posts should be returned
 *
 * @param array $args
 * @return array
 * @since 1.1
 */
function koko_analytics_get_most_viewed_posts(array $args = array()) : array {
	return KokoAnalytics\get_most_viewed_posts($args);
}


/**
 * Returns the number of realtime pageviews, eg in the last hour or in the last 5 minutes.
 *
 * Examples:
 *  koko_analytics_get_realtime_pageview_count('-5 minutes');
 *  koko_analytics_get_realtime_pageview_count('-1 hour');
 *
 * @param string|int $since
 * @return int
 * @since 1.1
 */
function koko_analytics_get_realtime_pageview_count($since = null) : int {
	if (is_string($since)) {
		$since = strtotime($since);
	}

	return KokoAnalytics\get_realtime_pageview_count($since);
}

/**
 * Writes a new pageview to the buffer file, to be aggregated during the next time `koko_analytics_aggregate_stats` runs.
 *
 * @param int $post_id The post ID to increment the pageviews count for.
 * @param bool $new_visitor Whether this is a new site visitor.
 * @param bool $unique_pageview Whether this was an unique pageview. (Ie the first time this visitor views this page today).
 * @param string $referrer_url External URL that this visitor came from, or empty string if direct traffic or coming from internal link.
 * @return false|int
 * @since 1.1
 */
function koko_analytics_track_pageview(int $post_id, bool $new_visitor = false, bool $unique_pageview = false, string $referrer_url = '') {
	$data = array(
		'p',
		$post_id,
		(int) $new_visitor,
		(int) $unique_pageview,
		$referrer_url,
	);
	return KokoAnalytics\collect_in_file($data);
}
