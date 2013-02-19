<?php
/**
 * Custom Widgets
 */
require_once locate_template('/lib/widget-helper/wph-widget-class.php');

/**
 * Twitter Widget
 */

if (!class_exists('allt_widget_twitter')){
	class allt_widget_twitter extends WPH_Widget {

		function __construct() {

			// Configure widget array
			$args = array(
				'label' => __('allthem.es Tweets Widget', ALLT_TEXT_DOMAIN),
				'description' => __('Generates a list of latest tweets.', ALLT_TEXT_DOMAIN),
			);

			// Configure the widget fields
			// Example for: Title (text) and Amount of posts to show (select box)

			// fields array
			$args['fields'] = array(

				array(
					'name' => __('Title', ALLT_TEXT_DOMAIN),
					'desc' => __('Enter the widget title.', ALLT_TEXT_DOMAIN),
					'id' => 'title',
					'type' => 'text',
					'class' => 'widefat',
					'std' => __('Latest tweets', ALLT_TEXT_DOMAIN),
				),
				array(
					'name' => __('Username', ALLT_TEXT_DOMAIN),
					'desc' => __('Enter the twitter username (without @).', ALLT_TEXT_DOMAIN),
					'id' => 'username',
					'type' => 'text',
					'class' => 'widefat',
					'std' => __('_allthemes_', ALLT_TEXT_DOMAIN),
				),
				array(
					'name' => __('Number', ALLT_TEXT_DOMAIN),
					'desc' => __('Select how many tweets you want to show.', ALLT_TEXT_DOMAIN),
					'id' => 'number',
					'type' => 'text',
					'validate' => 'numeric',
					'number' => true,
					'std' => 5
				),
				array(
					'name' => __('Display tweets timestamp', ALLT_TEXT_DOMAIN),
					'id' => 'timestamp',
					'type' => 'checkbox',
					'std' => 1,
					'filter' => 'strip_tags|esc_attr'
				),
				array(
					'name' => __('Display "Follow" button after tweets', ALLT_TEXT_DOMAIN),
					'id' => 'follow_btn',
					'type' => 'checkbox',
					'std' => 1,
					'filter' => 'strip_tags|esc_attr'
				)
			);
			$this->create_widget($args);
		}

		function widget($args, $instance) {
			echo $args['before_widget'];

			echo $args['before_title'] . $instance['title'] . $args['after_title'];

			$username = (isset($instance['username'])) ? $instance['username'] : '_allthemes_';
			$number = (isset($instance['number'])) ? $instance['number'] : '5';
			$timestamp = (isset($instance['timestamp'])) ? $instance['timestamp'] : '1';
			$follow_btn = (isset($instance['follow_btn'])) ? $instance['follow_btn'] : '1';

			$transient_key = 'allt_widget_tweets_' . $username . '_' . $number;

			$tweets = get_transient($transient_key);

			if (!$tweets || $tweets->username != $username || $tweets->tweet_count != $number) {
				$tweets = wp_remote_get('http://api.twitter.com/1/statuses/user_timeline/' . $username . '.json?count=' . $number . '&callback=?');
				if (isset($tweets->error)) return false;
				$tweets = json_decode($tweets['body']);

				$tweets_data = new StdClass();
				$tweets_data->username = $username;
				$tweets_data->tweet_count = $number;

				foreach($tweets as $tweet) {
					if ($number-- === 0) break;
					$tweets_data->tweets[] = array(
						$this->parse_tweet($tweet->text),
						$tweet->created_at
					);
				}
				set_transient($transient_key, $tweets_data, 60*5);
				$tweets = $tweets_data;
			}

			echo '<ul class="tweets clearfix">';

			foreach ($tweets->tweets as $tweet) {
				echo '<li>' . $tweet[0];
				if ($timestamp == '1') echo ' <small class="date">' . allt_time_ago($tweet[1]) . '</small>';
				echo '</li>';
			}

			echo '</ul>';

			if ($follow_btn == '1') {
				$lang = 'en';
				$lang = apply_filters('allt_twitter_button_lang', 10);

				echo '<a href="https://twitter.com/' . $username . '" class="twitter-follow-button" data-lang="' . $lang . '" data-show-count="false" data-size="large">Robert Cacacazob</a>';
				echo '<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>';
			}

			echo $args['after_widget'];
		}

		private function parse_tweet($tweet) {
			$tweet = preg_replace('/(http[^\s]+)/im', '<a href="$1">$1</a>', $tweet);
			$tweet = preg_replace('/@([^\s]+)/i', '<a href="http://twitter.com/$1">@$1</a>', $tweet);
			return $tweet;
		}

	}

	if (!function_exists('allt_register_widget_twitter')) {
		function allt_register_widget_twitter() {
			register_widget('allt_widget_twitter');
		}
		add_action('widgets_init', 'allt_register_widget_twitter', 1);
	}
}