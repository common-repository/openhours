<?php
/*
Plugin Name: OpenHours
Plugin URI: https://www.upsource.be/scripts/openhours-wordpress
Description: This plugin displays your office(s) opening hours in real time.
Text Domain: openhours
Domain Path: /languages
Version: 1.0
Author: Upsource
Author URI: https://www.upsource.be
License: GPL2
*/

class OH_Openhours_Widget extends WP_Widget {

  public function __construct() {
  	parent::__construct(
  		'openhours', __('OpenHours', 'openhours'),
  		array(
  			'customize_selective_refresh' => true,
        'description' => __( "Display your office(s) opening hours in real time." ),
  		)
  	);
  }

  public function form($oh_instance) {
  	$oh_defaults = array(
  		'oh_title'              => '',
  		'oh_text_opened'  => '',
    	'oh_text_closed'  => '',
      'oh_monday_checkbox'    => '',
      'oh_monday_time1o'      => '',
      'oh_monday_time1c'      => '',
      'oh_tuesday_checkbox'   => '',
      'oh_tuesday_time1o'     => '',
      'oh_tuesday_time1c'     => '',
      'oh_wednesday_checkbox' => '',
      'oh_wednesday_time1o'   => '',
      'oh_wednesday_time1c'   => '',
      'oh_thursday_checkbox'  => '',
      'oh_thursday_time1o'    => '',
      'oh_thursday_time1c'    => '',
      'oh_friday_checkbox'    => '',
      'oh_friday_time1o'      => '',
      'oh_friday_time1c'      => '',
      'oh_saturday_checkbox'  => '',
      'oh_saturday_time1o'    => '',
      'oh_saturday_time1c'    => '',
      'oh_sunday_checkbox'    => '',
      'oh_sunday_time1o'      => '',
      'oh_sunday_time1c'      => '',
  		'oh_display_mode'       => '',
  		'oh_clock_adjustment'   => '',
  		'oh_clocktime_format'   => '',
  	);
    extract( wp_parse_args((array) $oh_instance, $oh_defaults));
  ?>

  <?php
    $oh_today = date('l');
    $oh_now = current_time('H:i');
  ?>
  <p>
  	<label for="<?php echo esc_attr($this->get_field_id('oh_title')); ?>"><?php _e('Widget Title', 'openhours'); ?></label>
  	<input class="widefat" id="<?php echo esc_attr($this->get_field_id('oh_title')); ?>" name="<?php echo esc_attr($this->get_field_name('oh_title')); ?>" type="text" value="<?php echo esc_attr($oh_title); ?>" />
  </p>
  <p>
  	<label for="<?php echo esc_attr($this->get_field_id('oh_display_mode')); ?>"><?php _e('Display mode', 'openhours'); ?></label>
  	<select name="<?php echo esc_attr($this->get_field_name('oh_display_mode')); ?>" id="<?php echo esc_attr($this->get_field_id('oh_display_mode')); ?>" class="widefat">
  	<?php
    	$oh_options = array(
    		''  => __('Please select', 'openhours'),
    		'status_only' => __('Dynamic Open/Closed text', 'openhours'),
    		'timetable_full' => __('Opening hours timetable (with closed days)', 'openhours'),
    		'timetable_light' => __('Opening hours timetable (without closed days)', 'openhours'),
    	);
    	foreach ($oh_options as $key => $name) {
    		echo '<option value="' . esc_attr($key) . '" id="' . esc_attr($key) . '" '. selected($oh_display_mode, $key, false) . '>'. $name . '</option>';
    	}
    ?>
  	</select>
  </p>
  <p>
  	<label for="<?php echo esc_attr($this->get_field_id('oh_clock_adjustment')); ?>"><?php _e('Current local time', 'openhours'); ?></label>
  	<select name="<?php echo esc_attr($this->get_field_name('oh_clock_adjustment')); ?>" id="<?php echo esc_attr($this->get_field_id('oh_clock_adjustment')); ?>" class="widefat">
  	<?php
    	$oh_options = array(
    		''         => __('Please select', 'openhours'),
        '-12 hour' => __( date( get_option('time_format'), strtotime(current_time('H:i')) - 43200).' (wordpress local time -12:00)', 'openhours'),
        '-11 hour' => __( date( get_option('time_format'), strtotime(current_time('H:i')) - 39600).' (wordpress local time -11:00)', 'openhours'),
        '-10 hour' => __( date( get_option('time_format'), strtotime(current_time('H:i')) - 36000).' (wordpress local time -10:00)', 'openhours'),
        '-9 hour'  => __( date( get_option('time_format'), strtotime(current_time('H:i')) - 32400).' (wordpress local time -9:00)', 'openhours'),
        '-8 hour'  => __( date( get_option('time_format'), strtotime(current_time('H:i')) - 28800).' (wordpress local time -8:00)', 'openhours'),
        '-7 hour'  => __( date( get_option('time_format'), strtotime(current_time('H:i')) - 25200).' (wordpress local time -7:00)', 'openhours'),
        '-6 hour'  => __( date( get_option('time_format'), strtotime(current_time('H:i')) - 21600).' (wordpress local time -6:00)', 'openhours'),
        '-5 hour'  => __( date( get_option('time_format'), strtotime(current_time('H:i')) - 18000).' (wordpress local time -5:00)', 'openhours'),
        '-4 hour'  => __( date( get_option('time_format'), strtotime(current_time('H:i')) - 14400).' (wordpress local time -4:00)', 'openhours'),
        '-3 hour'  => __( date( get_option('time_format'), strtotime(current_time('H:i')) - 10800).' (wordpress local time -3:00)', 'openhours'),
        '-2 hour'  => __( date( get_option('time_format'), strtotime(current_time('H:i')) - 7200 ).' (wordpress local time -2:00)', 'openhours'),
        '-1 hour'  => __( date( get_option('time_format'), strtotime(current_time('H:i')) - 3600 ).' (wordpress local time -1:00)', 'openhours'),
        '0 hour'   => __(current_time(get_option('time_format')), 'openhours'),
        '1 hour'   => __( date( get_option('time_format'), strtotime(current_time('H:i')) + 3600 ).' (wordpress local time +1:00)', 'openhours'),
        '2 hour'   => __( date( get_option('time_format'), strtotime(current_time('H:i')) + 7200 ).' (wordpress local time +2:00)', 'openhours'),
        '3 hour'   => __( date( get_option('time_format'), strtotime(current_time('H:i')) + 10800).' (wordpress local time +3:00)', 'openhours'),
        '4 hour'   => __( date( get_option('time_format'), strtotime(current_time('H:i')) + 14400).' (wordpress local time +4:00)', 'openhours'),
        '5 hour'   => __( date( get_option('time_format'), strtotime(current_time('H:i')) + 18000).' (wordpress local time +5:00)', 'openhours'),
        '6 hour'   => __( date( get_option('time_format'), strtotime(current_time('H:i')) + 21600).' (wordpress local time +6:00)', 'openhours'),
        '7 hour'   => __( date( get_option('time_format'), strtotime(current_time('H:i')) + 25200).' (wordpress local time +7:00)', 'openhours'),
        '8 hour'   => __( date( get_option('time_format'), strtotime(current_time('H:i')) + 28800).' (wordpress local time +8:00)', 'openhours'),
        '9 hour'   => __( date( get_option('time_format'), strtotime(current_time('H:i')) + 32400).' (wordpress local time +9:00)', 'openhours'),
        '10 hour'  => __( date( get_option('time_format'), strtotime(current_time('H:i')) + 36000).' (wordpress local time +10:00)', 'openhours'),
        '11 hour'  => __( date( get_option('time_format'), strtotime(current_time('H:i')) + 39600).' (wordpress local time +11:00)', 'openhours'),
        '12 hour'  => __( date( get_option('time_format'), strtotime(current_time('H:i')) + 43200).' (wordpress local time +12:00)', 'openhours'),
    	);
    	foreach ($oh_options as $key => $name) {
    		echo '<option value="' . esc_attr($key) . '" id="' . esc_attr($key) . '" '. selected($oh_clock_adjustment, $key, false) . '>'. $name . '</option>';
    	}
    ?>
  	</select>
  </p>
  <p>
  	<label for="<?php echo esc_attr($this->get_field_id('oh_clocktime_format')); ?>"><?php _e('Time format display', 'openhours'); ?></label>
  	<select name="<?php echo esc_attr($this->get_field_name('oh_clocktime_format')); ?>" id="<?php echo esc_attr($this->get_field_id('oh_clocktime_format')); ?>" class="widefat">
  	<?php
  		$oh_options = array(
  			''  => __('Please select', 'openhours'),
  			'g:iA'    => __('g:i A (eg: 5:00PM)', 'openhours'),
  			'g:ia'    => __('g:i a (eg: 5:00pm)', 'openhours'),
  			'gA'      => __('g A (eg: 5PM)', 'openhours'),
  			'ga'      => __('g A (eg: 5pm)', 'openhours'),
  			'H:i'     => __('H:i (eg: 17:00)', 'openhours'),
  			'H.i'     => __('H.i (eg: 17.00)', 'openhours'),
  		);
  		foreach ($oh_options as $key => $name) {
  			echo '<option value="' . esc_attr($key) . '" id="' . esc_attr($key) . '" '. selected($oh_clocktime_format, $key, false) . '>'. $name . '</option>';
  		}
    ?>
  	</select>
  </p>
  <p>
  	<label for="<?php echo esc_attr($this->get_field_id('oh_text_opened')); ?>"><?php _e('Text/Html (status = open):', 'openhours'); ?></label>
  	<input class="widefat" id="<?php echo esc_attr($this->get_field_id('oh_text_opened')); ?>" name="<?php echo esc_attr($this->get_field_name('oh_text_opened')); ?>" type="text" value="<?php echo esc_attr($oh_text_opened ); ?>" />
  </p>
  <p>
  	<label for="<?php echo esc_attr($this->get_field_id('oh_text_closed')); ?>"><?php _e('Text/Html (status = closed):', 'openhours'); ?></label>
  	<input class="widefat" id="<?php echo esc_attr($this->get_field_id('oh_text_closed')); ?>" name="<?php echo esc_attr($this->get_field_name('oh_text_closed')); ?>" type="text" value="<?php echo esc_attr($oh_text_closed ); ?>" />
  </p>
  <?php
    $oh_options_o = array(
			''       =>  __('From', 'openhours'),
			'00:00'  =>  '12:00 AM / 00:00',
			'00:05'  =>  '12:05 AM / 00:05',
			'00:10'  =>  '12:10 AM / 00:10',
			'00:15'  =>  '12:15 AM / 00:15',
      '00:20'  =>  '12:20 AM / 00:20',
			'00:25'  =>  '12:25 AM / 00:25',
			'00:30'  =>  '12:30 AM / 00:30',
			'00:35'  =>  '12:35 AM / 00:35',
      '00:40'  =>  '12:40 AM / 00:40',
			'00:45'  =>  '12:45 AM / 00:45',
			'00:50'  =>  '12:50 AM / 00:50',
			'00:55'  =>  '12:55 AM / 00:55',
      '01:00'  =>  '01:00 AM / 01:00',
			'01:05'  =>  '01:05 AM / 01:05',
			'01:10'  =>  '01:10 AM / 01:10',
			'01:15'  =>  '01:15 AM / 01:15',
      '01:20'  =>  '01:20 AM / 01:20',
			'01:25'  =>  '01:25 AM / 01:25',
			'01:30'  =>  '01:30 AM / 01:30',
			'01:35'  =>  '01:35 AM / 01:35',
      '01:40'  =>  '01:40 AM / 01:40',
			'01:45'  =>  '01:45 AM / 01:45',
			'01:50'  =>  '01:50 AM / 01:50',
			'01:55'  =>  '01:55 AM / 01:55',
      '02:00'  =>  '02:00 AM / 02:00',
			'02:05'  =>  '02:05 AM / 02:05',
			'02:10'  =>  '02:10 AM / 02:10',
			'02:15'  =>  '02:15 AM / 02:15',
      '02:20'  =>  '02:20 AM / 02:20',
			'02:25'  =>  '02:25 AM / 02:25',
			'02:30'  =>  '02:30 AM / 02:30',
			'02:35'  =>  '02:35 AM / 02:35',
      '02:40'  =>  '02:40 AM / 02:40',
			'02:45'  =>  '02:45 AM / 02:45',
  		'02:50'  =>  '02:50 AM / 02:50',
  		'02:55'  =>  '02:55 AM / 02:55',
      '03:00'  =>  '03:00 AM / 03:00',
  		'03:05'  =>  '03:05 AM / 03:05',
  		'03:10'  =>  '03:10 AM / 03:10',
  		'03:15'  =>  '03:15 AM / 03:15',
      '03:20'  =>  '03:20 AM / 03:20',
  		'03:25'  =>  '03:25 AM / 03:25',
  		'03:30'  =>  '03:30 AM / 03:30',
  		'03:35'  =>  '03:35 AM / 03:35',
      '03:40'  =>  '03:40 AM / 03:40',
  		'03:45'  =>  '03:45 AM / 03:45',
  		'03:50'  =>  '03:50 AM / 03:50',
  		'03:55'  =>  '03:55 AM / 03:55',
      '04:00'  =>  '04:00 AM / 04:00',
  		'04:05'  =>  '04:05 AM / 04:05',
  		'04:10'  =>  '04:10 AM / 04:10',
  		'04:15'  =>  '04:15 AM / 04:15',
      '04:20'  =>  '04:20 AM / 04:20',
  		'04:25'  =>  '04:25 AM / 04:25',
  		'04:30'  =>  '04:30 AM / 04:30',
  		'04:35'  =>  '04:35 AM / 04:35',
      '04:40'  =>  '04:40 AM / 04:40',
  		'04:45'  =>  '04:45 AM / 04:45',
  		'04:50'  =>  '04:50 AM / 04:50',
  		'04:55'  =>  '04:55 AM / 04:55',
      '05:00'  =>  '05:00 AM / 05:00',
      '05:05'  =>  '05:05 AM / 05:05',
      '05:10'  =>  '05:10 AM / 05:10',
      '05:15'  =>  '05:15 AM / 05:15',
      '05:20'  =>  '05:20 AM / 05:20',
      '05:25'  =>  '05:25 AM / 05:25',
      '05:30'  =>  '05:30 AM / 05:30',
      '05:35'  =>  '05:35 AM / 05:35',
      '05:40'  =>  '05:40 AM / 05:40',
      '05:45'  =>  '05:45 AM / 05:45',
      '05:50'  =>  '05:50 AM / 05:50',
      '05:55'  =>  '05:55 AM / 05:55',
      '06:00'  =>  '06:00 AM / 06:00',
  		'06:05'  =>  '06:05 AM / 06:05',
  		'06:10'  =>  '06:10 AM / 06:10',
  		'06:15'  =>  '06:15 AM / 06:15',
      '06:20'  =>  '06:20 AM / 06:20',
  		'06:25'  =>  '06:25 AM / 06:25',
  		'06:30'  =>  '06:30 AM / 06:30',
  		'06:35'  =>  '06:35 AM / 06:35',
      '06:40'  =>  '06:40 AM / 06:40',
  		'06:45'  =>  '06:45 AM / 06:45',
  		'06:50'  =>  '06:50 AM / 06:50',
  		'06:55'  =>  '06:55 AM / 06:55',
      '07:00'  =>  '07:00 AM / 07:00',
  		'07:05'  =>  '07:05 AM / 07:05',
  		'07:10'  =>  '07:10 AM / 07:10',
  		'07:15'  =>  '07:15 AM / 07:15',
      '07:20'  =>  '07:20 AM / 07:20',
  		'07:25'  =>  '07:25 AM / 07:25',
  		'07:30'  =>  '07:30 AM / 07:30',
  		'07:35'  =>  '07:35 AM / 07:35',
      '07:40'  =>  '07:40 AM / 07:40',
  		'07:45'  =>  '07:45 AM / 07:45',
  		'07:50'  =>  '07:50 AM / 07:50',
  		'07:55'  =>  '07:55 AM / 07:55',
      '08:00'  =>  '08:00 AM / 08:00',
  		'08:05'  =>  '08:05 AM / 08:05',
  		'08:10'  =>  '08:10 AM / 08:10',
  		'08:15'  =>  '08:15 AM / 08:15',
      '08:20'  =>  '08:20 AM / 08:20',
  		'08:25'  =>  '08:25 AM / 08:25',
  		'08:30'  =>  '08:30 AM / 08:30',
  		'08:35'  =>  '08:35 AM / 08:35',
      '08:40'  =>  '08:40 AM / 08:40',
  		'08:45'  =>  '08:45 AM / 08:45',
  		'08:50'  =>  '08:50 AM / 08:50',
  		'08:55'  =>  '08:55 AM / 08:55',
      '09:00'  =>  '09:00 AM / 09:00',
  		'09:05'  =>  '09:05 AM / 09:05',
  		'09:10'  =>  '09:10 AM / 09:10',
  		'09:15'  =>  '09:15 AM / 09:15',
      '09:20'  =>  '09:20 AM / 09:20',
  		'09:25'  =>  '09:25 AM / 09:25',
  		'09:30'  =>  '09:30 AM / 09:30',
  		'09:35'  =>  '09:35 AM / 09:35',
      '09:40'  =>  '09:40 AM / 09:40',
  		'09:45'  =>  '09:45 AM / 09:45',
  		'09:50'  =>  '09:50 AM / 09:50',
  		'09:55'  =>  '09:55 AM / 09:55',
      '10:00'  =>  '10:00 AM / 10:00',
  		'10:05'  =>  '10:05 AM / 10:05',
  		'10:10'  =>  '10:10 AM / 10:10',
  		'10:15'  =>  '10:15 AM / 10:15',
      '10:20'  =>  '10:20 AM / 10:20',
  		'10:25'  =>  '10:25 AM / 10:25',
  		'10:30'  =>  '10:30 AM / 10:30',
  		'10:35'  =>  '10:35 AM / 10:35',
      '10:40'  =>  '10:40 AM / 10:40',
  		'10:45'  =>  '10:45 AM / 10:45',
  		'10:50'  =>  '10:50 AM / 10:50',
  		'10:55'  =>  '10:55 AM / 10:55',
      '11:00'  =>  '11:00 AM / 11:00',
  		'11:05'  =>  '11:05 AM / 11:05',
  		'11:10'  =>  '11:10 AM / 11:10',
  		'11:15'  =>  '11:15 AM / 11:15',
      '11:20'  =>  '11:20 AM / 11:20',
  		'11:25'  =>  '11:25 AM / 11:25',
  		'11:30'  =>  '11:30 AM / 11:30',
  		'11:35'  =>  '11:35 AM / 11:35',
      '11:40'  =>  '11:40 AM / 11:40',
  		'11:45'  =>  '11:45 AM / 11:45',
  		'11:50'  =>  '11:50 AM / 11:50',
  		'11:55'  =>  '11:55 AM / 11:55',
      '12:00'  =>  '12:00 PM / 12:00',
  		'12:05'  =>  '12:05 PM / 12:05',
  		'12:10'  =>  '12:10 PM / 12:10',
  		'12:15'  =>  '12:15 PM / 12:15',
      '12:20'  =>  '12:20 PM / 12:20',
  		'12:25'  =>  '12:25 PM / 12:25',
  		'12:30'  =>  '12:30 PM / 12:30',
  		'12:35'  =>  '12:35 PM / 12:35',
      '12:40'  =>  '12:40 PM / 12:40',
  		'12:45'  =>  '12:45 PM / 12:45',
  		'12:50'  =>  '12:50 PM / 12:50',
  		'12:55'  =>  '12:55 PM / 12:55',
      '13:00'  =>  '01:00 PM / 13:00',
  		'13:05'  =>  '01:05 PM / 13:05',
  		'13:10'  =>  '01:10 PM / 13:10',
  		'13:15'  =>  '01:15 PM / 13:15',
      '13:20'  =>  '01:20 PM / 13:20',
  		'13:25'  =>  '01:25 PM / 13:25',
  		'13:30'  =>  '01:30 PM / 13:30',
  		'13:35'  =>  '01:35 PM / 13:35',
      '13:40'  =>  '01:40 PM / 13:40',
  		'13:45'  =>  '01:45 PM / 13:45',
  		'13:50'  =>  '01:50 PM / 13:50',
  		'13:55'  =>  '01:55 PM / 13:55',
      '14:00'  =>  '02:00 PM / 14:00',
  		'14:05'  =>  '02:05 PM / 14:05',
  		'14:10'  =>  '02:10 PM / 14:10',
  		'14:15'  =>  '02:15 PM / 14:15',
      '14:20'  =>  '02:20 PM / 14:20',
  		'14:25'  =>  '02:25 PM / 14:25',
  		'14:30'  =>  '02:30 PM / 14:30',
  		'14:35'  =>  '02:35 PM / 14:35',
      '14:40'  =>  '02:40 PM / 14:40',
  		'14:45'  =>  '02:45 PM / 14:45',
  		'14:50'  =>  '02:50 PM / 14:50',
  		'14:55'  =>  '02:55 PM / 14:55',
      '15:00'  =>  '03:00 PM / 15:00',
  		'15:05'  =>  '03:05 PM / 15:05',
  		'15:10'  =>  '03:10 PM / 15:10',
  		'15:15'  =>  '03:15 PM / 15:15',
      '15:20'  =>  '03:20 PM / 15:20',
  		'15:25'  =>  '03:25 PM / 15:25',
  		'15:30'  =>  '03:30 PM / 15:30',
  		'15:35'  =>  '03:35 PM / 15:35',
      '15:40'  =>  '03:40 PM / 15:40',
  		'15:45'  =>  '03:45 PM / 15:45',
  		'15:50'  =>  '03:50 PM / 15:50',
  		'15:55'  =>  '03:55 PM / 15:55',
      '16:00'  =>  '04:00 PM / 16:00',
  		'16:05'  =>  '04:05 PM / 16:05',
  		'16:10'  =>  '04:10 PM / 16:10',
  		'16:15'  =>  '04:15 PM / 16:15',
      '16:20'  =>  '04:20 PM / 16:20',
  		'16:25'  =>  '04:25 PM / 16:25',
  		'16:30'  =>  '04:30 PM / 16:30',
  		'16:35'  =>  '04:35 PM / 16:35',
      '16:40'  =>  '04:40 PM / 16:40',
  		'16:45'  =>  '04:45 PM / 16:45',
  		'16:50'  =>  '04:50 PM / 16:50',
  		'16:55'  =>  '04:55 PM / 16:55',
      '17:00'  =>  '05:00 PM / 17:00',
  		'17:05'  =>  '05:05 PM / 17:05',
  		'17:10'  =>  '05:10 PM / 17:10',
  		'17:15'  =>  '05:15 PM / 17:15',
      '17:20'  =>  '05:20 PM / 17:20',
  		'17:25'  =>  '05:25 PM / 17:25',
  		'17:30'  =>  '05:30 PM / 17:30',
  		'17:35'  =>  '05:35 PM / 17:35',
      '17:40'  =>  '05:40 PM / 17:40',
  		'17:45'  =>  '05:45 PM / 17:45',
  		'17:50'  =>  '05:50 PM / 17:50',
  		'17:55'  =>  '05:55 PM / 17:55',
      '18:00'  =>  '06:00 PM / 18:00',
  		'18:05'  =>  '06:05 PM / 18:05',
  		'18:10'  =>  '06:10 PM / 18:10',
  		'18:15'  =>  '06:15 PM / 18:15',
      '18:20'  =>  '06:20 PM / 18:20',
  		'18:25'  =>  '06:25 PM / 18:25',
  		'18:30'  =>  '06:30 PM / 18:30',
  		'18:35'  =>  '06:35 PM / 18:35',
      '18:40'  =>  '06:40 PM / 18:40',
  		'18:45'  =>  '06:45 PM / 18:45',
  		'18:50'  =>  '06:50 PM / 18:50',
  		'18:55'  =>  '06:55 PM / 18:55',
      '19:00'  =>  '07:00 PM / 19:00',
  		'19:05'  =>  '07:05 PM / 19:05',
  		'19:10'  =>  '07:10 PM / 19:10',
  		'19:15'  =>  '07:15 PM / 19:15',
      '19:20'  =>  '07:20 PM / 19:20',
  		'19:25'  =>  '07:25 PM / 19:25',
  		'19:30'  =>  '07:30 PM / 19:30',
  		'19:35'  =>  '07:35 PM / 19:35',
      '19:40'  =>  '07:40 PM / 19:40',
  		'19:45'  =>  '07:45 PM / 19:45',
  		'19:50'  =>  '07:50 PM / 19:50',
  		'19:55'  =>  '07:55 PM / 19:55',
      '20:00'  =>  '08:00 PM / 20:00',
  		'20:05'  =>  '08:05 PM / 20:05',
  		'20:10'  =>  '08:10 PM / 20:10',
  		'20:15'  =>  '08:15 PM / 20:15',
      '20:20'  =>  '08:20 PM / 20:20',
  		'20:25'  =>  '08:25 PM / 20:25',
  		'20:30'  =>  '08:30 PM / 20:30',
  		'20:35'  =>  '08:35 PM / 20:35',
      '20:40'  =>  '08:40 PM / 20:40',
  		'20:45'  =>  '08:45 PM / 20:45',
  		'20:50'  =>  '08:50 PM / 20:50',
  		'20:55'  =>  '08:55 PM / 20:55',
      '21:00'  =>  '09:00 PM / 21:00',
  		'21:05'  =>  '09:05 PM / 21:05',
  		'21:10'  =>  '09:10 PM / 21:10',
  		'21:15'  =>  '09:15 PM / 21:15',
      '21:20'  =>  '09:20 PM / 21:20',
  		'21:25'  =>  '09:25 PM / 21:25',
  		'21:30'  =>  '09:30 PM / 21:30',
  		'21:35'  =>  '09:35 PM / 21:35',
      '21:40'  =>  '09:40 PM / 21:40',
  		'21:45'  =>  '09:45 PM / 21:45',
  		'21:50'  =>  '09:50 PM / 21:50',
  		'21:55'  =>  '09:55 PM / 21:55',
      '22:00'  =>  '10:00 PM / 22:00',
  		'22:05'  =>  '10:05 PM / 22:05',
  		'22:10'  =>  '10:10 PM / 22:10',
  		'22:15'  =>  '10:15 PM / 22:15',
      '22:20'  =>  '10:20 PM / 22:20',
  		'22:25'  =>  '10:25 PM / 22:25',
  		'22:30'  =>  '10:30 PM / 22:30',
  		'22:35'  =>  '10:35 PM / 22:35',
      '22:40'  =>  '10:40 PM / 22:40',
  		'22:45'  =>  '10:45 PM / 22:45',
  		'22:50'  =>  '10:50 PM / 22:50',
  		'22:55'  =>  '10:55 PM / 22:55',
      '23:00'  =>  '11:00 PM / 23:00',
  		'23:05'  =>  '11:05 PM / 23:05',
  		'23:10'  =>  '11:10 PM / 23:10',
  		'23:15'  =>  '11:15 PM / 23:15',
      '23:20'  =>  '11:20 PM / 23:20',
  		'23:25'  =>  '11:25 PM / 23:25',
  		'23:30'  =>  '11:30 PM / 23:30',
  		'23:35'  =>  '11:35 PM / 23:35',
      '23:40'  =>  '11:40 PM / 23:40',
  		'23:45'  =>  '11:45 PM / 23:45',
  		'23:50'  =>  '11:50 PM / 23:50',
  		'23:55'  =>  '11:55 PM / 23:55',
  	);

    $oh_options_c = array(
   		''       =>  __('To', 'openhours'),
      '00:00'  =>  '12:00 AM / 00:00',
  		'00:05'  =>  '12:05 AM / 00:05',
  		'00:10'  =>  '12:10 AM / 00:10',
  		'00:15'  =>  '12:15 AM / 00:15',
      '00:20'  =>  '12:20 AM / 00:20',
  		'00:25'  =>  '12:25 AM / 00:25',
  		'00:30'  =>  '12:30 AM / 00:30',
  		'00:35'  =>  '12:35 AM / 00:35',
      '00:40'  =>  '12:40 AM / 00:40',
  		'00:45'  =>  '12:45 AM / 00:45',
  		'00:50'  =>  '12:50 AM / 00:50',
  		'00:55'  =>  '12:55 AM / 00:55',
      '01:00'  =>  '01:00 AM / 01:00',
  		'01:05'  =>  '01:05 AM / 01:05',
  		'01:10'  =>  '01:10 AM / 01:10',
  		'01:15'  =>  '01:15 AM / 01:15',
      '01:20'  =>  '01:20 AM / 01:20',
  		'01:25'  =>  '01:25 AM / 01:25',
  		'01:30'  =>  '01:30 AM / 01:30',
  		'01:35'  =>  '01:35 AM / 01:35',
      '01:40'  =>  '01:40 AM / 01:40',
  		'01:45'  =>  '01:45 AM / 01:45',
  		'01:50'  =>  '01:50 AM / 01:50',
  		'01:55'  =>  '01:55 AM / 01:55',
      '02:00'  =>  '02:00 AM / 02:00',
  		'02:05'  =>  '02:05 AM / 02:05',
  		'02:10'  =>  '02:10 AM / 02:10',
  		'02:15'  =>  '02:15 AM / 02:15',
      '02:20'  =>  '02:20 AM / 02:20',
  		'02:25'  =>  '02:25 AM / 02:25',
  		'02:30'  =>  '02:30 AM / 02:30',
  		'02:35'  =>  '02:35 AM / 02:35',
      '02:40'  =>  '02:40 AM / 02:40',
  		'02:45'  =>  '02:45 AM / 02:45',
    	'02:50'  =>  '02:50 AM / 02:50',
    	'02:55'  =>  '02:55 AM / 02:55',
      '03:00'  =>  '03:00 AM / 03:00',
    	'03:05'  =>  '03:05 AM / 03:05',
    	'03:10'  =>  '03:10 AM / 03:10',
    	'03:15'  =>  '03:15 AM / 03:15',
      '03:20'  =>  '03:20 AM / 03:20',
    	'03:25'  =>  '03:25 AM / 03:25',
    	'03:30'  =>  '03:30 AM / 03:30',
    	'03:35'  =>  '03:35 AM / 03:35',
      '03:40'  =>  '03:40 AM / 03:40',
    	'03:45'  =>  '03:45 AM / 03:45',
    	'03:50'  =>  '03:50 AM / 03:50',
    	'03:55'  =>  '03:55 AM / 03:55',
      '04:00'  =>  '04:00 AM / 04:00',
    	'04:05'  =>  '04:05 AM / 04:05',
    	'04:10'  =>  '04:10 AM / 04:10',
    	'04:15'  =>  '04:15 AM / 04:15',
      '04:20'  =>  '04:20 AM / 04:20',
    	'04:25'  =>  '04:25 AM / 04:25',
    	'04:30'  =>  '04:30 AM / 04:30',
    	'04:35'  =>  '04:35 AM / 04:35',
      '04:40'  =>  '04:40 AM / 04:40',
    	'04:45'  =>  '04:45 AM / 04:45',
    	'04:50'  =>  '04:50 AM / 04:50',
    	'04:55'  =>  '04:55 AM / 04:55',
      '05:00'  =>  '05:00 AM / 05:00',
      '05:05'  =>  '05:05 AM / 05:05',
      '05:10'  =>  '05:10 AM / 05:10',
      '05:15'  =>  '05:15 AM / 05:15',
      '05:20'  =>  '05:20 AM / 05:20',
      '05:25'  =>  '05:25 AM / 05:25',
      '05:30'  =>  '05:30 AM / 05:30',
      '05:35'  =>  '05:35 AM / 05:35',
      '05:40'  =>  '05:40 AM / 05:40',
      '05:45'  =>  '05:45 AM / 05:45',
      '05:50'  =>  '05:50 AM / 05:50',
      '05:55'  =>  '05:55 AM / 05:55',
      '06:00'  =>  '06:00 AM / 06:00',
    	'06:05'  =>  '06:05 AM / 06:05',
    	'06:10'  =>  '06:10 AM / 06:10',
    	'06:15'  =>  '06:15 AM / 06:15',
      '06:20'  =>  '06:20 AM / 06:20',
    	'06:25'  =>  '06:25 AM / 06:25',
    	'06:30'  =>  '06:30 AM / 06:30',
    	'06:35'  =>  '06:35 AM / 06:35',
      '06:40'  =>  '06:40 AM / 06:40',
    	'06:45'  =>  '06:45 AM / 06:45',
    	'06:50'  =>  '06:50 AM / 06:50',
    	'06:55'  =>  '06:55 AM / 06:55',
      '07:00'  =>  '07:00 AM / 07:00',
    	'07:05'  =>  '07:05 AM / 07:05',
    	'07:10'  =>  '07:10 AM / 07:10',
    	'07:15'  =>  '07:15 AM / 07:15',
      '07:20'  =>  '07:20 AM / 07:20',
    	'07:25'  =>  '07:25 AM / 07:25',
    	'07:30'  =>  '07:30 AM / 07:30',
    	'07:35'  =>  '07:35 AM / 07:35',
      '07:40'  =>  '07:40 AM / 07:40',
    	'07:45'  =>  '07:45 AM / 07:45',
    	'07:50'  =>  '07:50 AM / 07:50',
    	'07:55'  =>  '07:55 AM / 07:55',
      '08:00'  =>  '08:00 AM / 08:00',
    	'08:05'  =>  '08:05 AM / 08:05',
    	'08:10'  =>  '08:10 AM / 08:10',
    	'08:15'  =>  '08:15 AM / 08:15',
      '08:20'  =>  '08:20 AM / 08:20',
    	'08:25'  =>  '08:25 AM / 08:25',
    	'08:30'  =>  '08:30 AM / 08:30',
    	'08:35'  =>  '08:35 AM / 08:35',
      '08:40'  =>  '08:40 AM / 08:40',
    	'08:45'  =>  '08:45 AM / 08:45',
    	'08:50'  =>  '08:50 AM / 08:50',
    	'08:55'  =>  '08:55 AM / 08:55',
      '09:00'  =>  '09:00 AM / 09:00',
    	'09:05'  =>  '09:05 AM / 09:05',
    	'09:10'  =>  '09:10 AM / 09:10',
    	'09:15'  =>  '09:15 AM / 09:15',
      '09:20'  =>  '09:20 AM / 09:20',
    	'09:25'  =>  '09:25 AM / 09:25',
    	'09:30'  =>  '09:30 AM / 09:30',
    	'09:35'  =>  '09:35 AM / 09:35',
      '09:40'  =>  '09:40 AM / 09:40',
    	'09:45'  =>  '09:45 AM / 09:45',
    	'09:50'  =>  '09:50 AM / 09:50',
    	'09:55'  =>  '09:55 AM / 09:55',
      '10:00'  =>  '10:00 AM / 10:00',
    	'10:05'  =>  '10:05 AM / 10:05',
    	'10:10'  =>  '10:10 AM / 10:10',
    	'10:15'  =>  '10:15 AM / 10:15',
      '10:20'  =>  '10:20 AM / 10:20',
    	'10:25'  =>  '10:25 AM / 10:25',
    	'10:30'  =>  '10:30 AM / 10:30',
    	'10:35'  =>  '10:35 AM / 10:35',
      '10:40'  =>  '10:40 AM / 10:40',
    	'10:45'  =>  '10:45 AM / 10:45',
    	'10:50'  =>  '10:50 AM / 10:50',
    	'10:55'  =>  '10:55 AM / 10:55',
      '11:00'  =>  '11:00 AM / 11:00',
    	'11:05'  =>  '11:05 AM / 11:05',
    	'11:10'  =>  '11:10 AM / 11:10',
    	'11:15'  =>  '11:15 AM / 11:15',
      '11:20'  =>  '11:20 AM / 11:20',
    	'11:25'  =>  '11:25 AM / 11:25',
    	'11:30'  =>  '11:30 AM / 11:30',
    	'11:35'  =>  '11:35 AM / 11:35',
      '11:40'  =>  '11:40 AM / 11:40',
    	'11:45'  =>  '11:45 AM / 11:45',
    	'11:50'  =>  '11:50 AM / 11:50',
    	'11:55'  =>  '11:55 AM / 11:55',
      '12:00'  =>  '12:00 PM / 12:00',
    	'12:05'  =>  '12:05 PM / 12:05',
    	'12:10'  =>  '12:10 PM / 12:10',
    	'12:15'  =>  '12:15 PM / 12:15',
      '12:20'  =>  '12:20 PM / 12:20',
    	'12:25'  =>  '12:25 PM / 12:25',
    	'12:30'  =>  '12:30 PM / 12:30',
    	'12:35'  =>  '12:35 PM / 12:35',
      '12:40'  =>  '12:40 PM / 12:40',
    	'12:45'  =>  '12:45 PM / 12:45',
    	'12:50'  =>  '12:50 PM / 12:50',
    	'12:55'  =>  '12:55 PM / 12:55',
      '13:00'  =>  '01:00 PM / 13:00',
    	'13:05'  =>  '01:05 PM / 13:05',
    	'13:10'  =>  '01:10 PM / 13:10',
    	'13:15'  =>  '01:15 PM / 13:15',
      '13:20'  =>  '01:20 PM / 13:20',
    	'13:25'  =>  '01:25 PM / 13:25',
    	'13:30'  =>  '01:30 PM / 13:30',
    	'13:35'  =>  '01:35 PM / 13:35',
      '13:40'  =>  '01:40 PM / 13:40',
    	'13:45'  =>  '01:45 PM / 13:45',
    	'13:50'  =>  '01:50 PM / 13:50',
    	'13:55'  =>  '01:55 PM / 13:55',
      '14:00'  =>  '02:00 PM / 14:00',
    	'14:05'  =>  '02:05 PM / 14:05',
    	'14:10'  =>  '02:10 PM / 14:10',
    	'14:15'  =>  '02:15 PM / 14:15',
      '14:20'  =>  '02:20 PM / 14:20',
    	'14:25'  =>  '02:25 PM / 14:25',
    	'14:30'  =>  '02:30 PM / 14:30',
    	'14:35'  =>  '02:35 PM / 14:35',
      '14:40'  =>  '02:40 PM / 14:40',
    	'14:45'  =>  '02:45 PM / 14:45',
    	'14:50'  =>  '02:50 PM / 14:50',
    	'14:55'  =>  '02:55 PM / 14:55',
      '15:00'  =>  '03:00 PM / 15:00',
    	'15:05'  =>  '03:05 PM / 15:05',
    	'15:10'  =>  '03:10 PM / 15:10',
    	'15:15'  =>  '03:15 PM / 15:15',
      '15:20'  =>  '03:20 PM / 15:20',
    	'15:25'  =>  '03:25 PM / 15:25',
    	'15:30'  =>  '03:30 PM / 15:30',
    	'15:35'  =>  '03:35 PM / 15:35',
      '15:40'  =>  '03:40 PM / 15:40',
    	'15:45'  =>  '03:45 PM / 15:45',
    	'15:50'  =>  '03:50 PM / 15:50',
    	'15:55'  =>  '03:55 PM / 15:55',
      '16:00'  =>  '04:00 PM / 16:00',
    	'16:05'  =>  '04:05 PM / 16:05',
    	'16:10'  =>  '04:10 PM / 16:10',
    	'16:15'  =>  '04:15 PM / 16:15',
      '16:20'  =>  '04:20 PM / 16:20',
    	'16:25'  =>  '04:25 PM / 16:25',
    	'16:30'  =>  '04:30 PM / 16:30',
    	'16:35'  =>  '04:35 PM / 16:35',
      '16:40'  =>  '04:40 PM / 16:40',
    	'16:45'  =>  '04:45 PM / 16:45',
    	'16:50'  =>  '04:50 PM / 16:50',
    	'16:55'  =>  '04:55 PM / 16:55',
      '17:00'  =>  '05:00 PM / 17:00',
    	'17:05'  =>  '05:05 PM / 17:05',
    	'17:10'  =>  '05:10 PM / 17:10',
    	'17:15'  =>  '05:15 PM / 17:15',
      '17:20'  =>  '05:20 PM / 17:20',
    	'17:25'  =>  '05:25 PM / 17:25',
    	'17:30'  =>  '05:30 PM / 17:30',
    	'17:35'  =>  '05:35 PM / 17:35',
      '17:40'  =>  '05:40 PM / 17:40',
    	'17:45'  =>  '05:45 PM / 17:45',
    	'17:50'  =>  '05:50 PM / 17:50',
    	'17:55'  =>  '05:55 PM / 17:55',
      '18:00'  =>  '06:00 PM / 18:00',
    	'18:05'  =>  '06:05 PM / 18:05',
    	'18:10'  =>  '06:10 PM / 18:10',
    	'18:15'  =>  '06:15 PM / 18:15',
      '18:20'  =>  '06:20 PM / 18:20',
    	'18:25'  =>  '06:25 PM / 18:25',
    	'18:30'  =>  '06:30 PM / 18:30',
    	'18:35'  =>  '06:35 PM / 18:35',
      '18:40'  =>  '06:40 PM / 18:40',
    	'18:45'  =>  '06:45 PM / 18:45',
    	'18:50'  =>  '06:50 PM / 18:50',
    	'18:55'  =>  '06:55 PM / 18:55',
      '19:00'  =>  '07:00 PM / 19:00',
    	'19:05'  =>  '07:05 PM / 19:05',
    	'19:10'  =>  '07:10 PM / 19:10',
    	'19:15'  =>  '07:15 PM / 19:15',
      '19:20'  =>  '07:20 PM / 19:20',
    	'19:25'  =>  '07:25 PM / 19:25',
    	'19:30'  =>  '07:30 PM / 19:30',
    	'19:35'  =>  '07:35 PM / 19:35',
      '19:40'  =>  '07:40 PM / 19:40',
    	'19:45'  =>  '07:45 PM / 19:45',
    	'19:50'  =>  '07:50 PM / 19:50',
    	'19:55'  =>  '07:55 PM / 19:55',
      '20:00'  =>  '08:00 PM / 20:00',
    	'20:05'  =>  '08:05 PM / 20:05',
    	'20:10'  =>  '08:10 PM / 20:10',
    	'20:15'  =>  '08:15 PM / 20:15',
      '20:20'  =>  '08:20 PM / 20:20',
    	'20:25'  =>  '08:25 PM / 20:25',
    	'20:30'  =>  '08:30 PM / 20:30',
    	'20:35'  =>  '08:35 PM / 20:35',
      '20:40'  =>  '08:40 PM / 20:40',
    	'20:45'  =>  '08:45 PM / 20:45',
    	'20:50'  =>  '08:50 PM / 20:50',
    	'20:55'  =>  '08:55 PM / 20:55',
      '21:00'  =>  '09:00 PM / 21:00',
    	'21:05'  =>  '09:05 PM / 21:05',
    	'21:10'  =>  '09:10 PM / 21:10',
    	'21:15'  =>  '09:15 PM / 21:15',
      '21:20'  =>  '09:20 PM / 21:20',
    	'21:25'  =>  '09:25 PM / 21:25',
    	'21:30'  =>  '09:30 PM / 21:30',
    	'21:35'  =>  '09:35 PM / 21:35',
      '21:40'  =>  '09:40 PM / 21:40',
    	'21:45'  =>  '09:45 PM / 21:45',
    	'21:50'  =>  '09:50 PM / 21:50',
    	'21:55'  =>  '09:55 PM / 21:55',
      '22:00'  =>  '10:00 PM / 22:00',
    	'22:05'  =>  '10:05 PM / 22:05',
    	'22:10'  =>  '10:10 PM / 22:10',
    	'22:15'  =>  '10:15 PM / 22:15',
      '22:20'  =>  '10:20 PM / 22:20',
    	'22:25'  =>  '10:25 PM / 22:25',
    	'22:30'  =>  '10:30 PM / 22:30',
    	'22:35'  =>  '10:35 PM / 22:35',
      '22:40'  =>  '10:40 PM / 22:40',
    	'22:45'  =>  '10:45 PM / 22:45',
      '22:50'  =>  '10:50 PM / 22:50',
    	'22:55'  =>  '10:55 PM / 22:55',
      '23:00'  =>  '11:00 PM / 23:00',
    	'23:05'  =>  '11:05 PM / 23:05',
    	'23:10'  =>  '11:10 PM / 23:10',
    	'23:15'  =>  '11:15 PM / 23:15',
      '23:20'  =>  '11:20 PM / 23:20',
    	'23:25'  =>  '11:25 PM / 23:25',
    	'23:30'  =>  '11:30 PM / 23:30',
    	'23:35'  =>  '11:35 PM / 23:35',
      '23:40'  =>  '11:40 PM / 23:40',
    	'23:45'  =>  '11:45 PM / 23:45',
    	'23:50'  =>  '11:50 PM / 23:50',
    	'23:55'  =>  '11:55 PM / 23:55',
   	);
  ?>

  <?php // Text Field ?>
    <p>
      <input id="<?php echo esc_attr($this->get_field_id('oh_monday_checkbox')); ?>" name="<?php echo esc_attr($this->get_field_name('oh_monday_checkbox')); ?>" type="checkbox" value="1" <?php checked('1', $oh_monday_checkbox ); ?> />
		  <label for="<?php echo esc_attr($this->get_field_id('oh_monday_checkbox')); ?>"><?php _e('Monday', 'openhours'); ?></label>
    </p>
    <select name="<?php echo esc_attr($this->get_field_name('oh_monday_time1o')); ?>" id="<?php echo esc_attr($this->get_field_id('oh_monday_time1o')); ?>" class="widefat">
		<?php
  		foreach ($oh_options_o as $key => $name) {
  			echo '<option value="' . esc_attr($key) . '" id="' . esc_attr($key) . '" '. selected($oh_monday_time1o, $key, false) . '>'. $name . '</option>';
  		}
    ?>
		</select>
    <select name="<?php echo esc_attr($this->get_field_name('oh_monday_time1c')); ?>" id="<?php echo esc_attr($this->get_field_id('oh_monday_time1c')); ?>" class="widefat">
		<?php
  		foreach ($oh_options_c as $key => $name) {
  			echo '<option value="' . esc_attr($key) . '" id="' . esc_attr($key) . '" '. selected($oh_monday_time1c, $key, false) . '>'. $name . '</option>';
  		}
    ?>
		</select>
    <p>
      <input id="<?php echo esc_attr($this->get_field_id('oh_tuesday_checkbox')); ?>" name="<?php echo esc_attr($this->get_field_name('oh_tuesday_checkbox')); ?>" type="checkbox" value="1" <?php checked('1', $oh_tuesday_checkbox ); ?> />
		  <label for="<?php echo esc_attr($this->get_field_id('oh_tuesday_checkbox')); ?>"><?php _e('Tuesday', 'openhours'); ?></label>
    </p>
    <select name="<?php echo esc_attr($this->get_field_name('oh_tuesday_time1o')); ?>" id="<?php echo esc_attr($this->get_field_id('oh_tuesday_time1o')); ?>" class="widefat">
		<?php
  		foreach ($oh_options_o as $key => $name) {
  			echo '<option value="' . esc_attr($key) . '" id="' . esc_attr($key) . '" '. selected($oh_tuesday_time1o, $key, false) . '>'. $name . '</option>';
  		}
    ?>
		</select>
    <select name="<?php echo esc_attr($this->get_field_name('oh_tuesday_time1c')); ?>" id="<?php echo esc_attr($this->get_field_id('oh_tuesday_time1c')); ?>" class="widefat">
		<?php
  		foreach ($oh_options_c as $key => $name) {
  			echo '<option value="' . esc_attr($key) . '" id="' . esc_attr($key) . '" '. selected($oh_tuesday_time1c, $key, false) . '>'. $name . '</option>';
  		}
    ?>
		</select>
    <p>
      <input id="<?php echo esc_attr($this->get_field_id('oh_wednesday_checkbox')); ?>" name="<?php echo esc_attr($this->get_field_name('oh_wednesday_checkbox')); ?>" type="checkbox" value="1" <?php checked('1', $oh_wednesday_checkbox ); ?> />
		  <label for="<?php echo esc_attr($this->get_field_id('oh_wednesday_checkbox')); ?>"><?php _e('Wednesday', 'openhours'); ?></label>
    </p>
    <select name="<?php echo esc_attr($this->get_field_name('oh_wednesday_time1o')); ?>" id="<?php echo esc_attr($this->get_field_id('oh_wednesday_time1o')); ?>" class="widefat">
		<?php
  		foreach ($oh_options_o as $key => $name) {
  			echo '<option value="' . esc_attr($key) . '" id="' . esc_attr($key) . '" '. selected($oh_wednesday_time1o, $key, false) . '>'. $name . '</option>';
  		}
    ?>
		</select>
    <select name="<?php echo esc_attr($this->get_field_name('oh_wednesday_time1c')); ?>" id="<?php echo esc_attr($this->get_field_id('oh_wednesday_time1c')); ?>" class="widefat">
		<?php
  		foreach ($oh_options_c as $key => $name) {
  			echo '<option value="' . esc_attr($key) . '" id="' . esc_attr($key) . '" '. selected($oh_wednesday_time1c, $key, false) . '>'. $name . '</option>';
  		}
    ?>
		</select>
    <p>
      <input id="<?php echo esc_attr($this->get_field_id('oh_thursday_checkbox')); ?>" name="<?php echo esc_attr($this->get_field_name('oh_thursday_checkbox')); ?>" type="checkbox" value="1" <?php checked('1', $oh_thursday_checkbox ); ?> />
		  <label for="<?php echo esc_attr($this->get_field_id('oh_thursday_checkbox')); ?>"><?php _e('Thursday', 'openhours'); ?></label>
    </p>
    <select name="<?php echo esc_attr($this->get_field_name('oh_thursday_time1o')); ?>" id="<?php echo esc_attr($this->get_field_id('oh_thursday_time1o')); ?>" class="widefat">
		<?php
  		foreach ($oh_options_o as $key => $name) {
  			echo '<option value="' . esc_attr($key) . '" id="' . esc_attr($key) . '" '. selected($oh_thursday_time1o, $key, false) . '>'. $name . '</option>';
  		}
    ?>
		</select>
    <select name="<?php echo esc_attr($this->get_field_name('oh_thursday_time1c')); ?>" id="<?php echo esc_attr($this->get_field_id('oh_thursday_time1c')); ?>" class="widefat">
		<?php
  		foreach ($oh_options_c as $key => $name) {
  			echo '<option value="' . esc_attr($key) . '" id="' . esc_attr($key) . '" '. selected($oh_thursday_time1c, $key, false) . '>'. $name . '</option>';
  		}
    ?>
		</select>
    <p>
      <input id="<?php echo esc_attr($this->get_field_id('oh_friday_checkbox')); ?>" name="<?php echo esc_attr($this->get_field_name('oh_friday_checkbox')); ?>" type="checkbox" value="1" <?php checked('1', $oh_friday_checkbox ); ?> />
		  <label for="<?php echo esc_attr($this->get_field_id('oh_friday_checkbox')); ?>"><?php _e('Friday', 'openhours'); ?></label>
    </p>
    <select name="<?php echo esc_attr($this->get_field_name('oh_friday_time1o')); ?>" id="<?php echo esc_attr($this->get_field_id('oh_friday_time1o')); ?>" class="widefat">
		<?php
  		foreach ($oh_options_o as $key => $name) {
  			echo '<option value="' . esc_attr($key) . '" id="' . esc_attr($key) . '" '. selected($oh_friday_time1o, $key, false) . '>'. $name . '</option>';
  		} ?>
		</select>
    <select name="<?php echo esc_attr($this->get_field_name('oh_friday_time1c')); ?>" id="<?php echo esc_attr($this->get_field_id('oh_friday_time1c')); ?>" class="widefat">
		<?php
  		foreach ($oh_options_c as $key => $name) {
  			echo '<option value="' . esc_attr($key) . '" id="' . esc_attr($key) . '" '. selected($oh_friday_time1c, $key, false) . '>'. $name . '</option>';
  		}
    ?>
		</select>
    <p>
      <input id="<?php echo esc_attr($this->get_field_id('oh_saturday_checkbox')); ?>" name="<?php echo esc_attr($this->get_field_name('oh_saturday_checkbox')); ?>" type="checkbox" value="1" <?php checked('1', $oh_saturday_checkbox ); ?> />
		  <label for="<?php echo esc_attr($this->get_field_id('oh_saturday_checkbox')); ?>"><?php _e('Saturday', 'openhours'); ?></label>
    </p>
    <select name="<?php echo esc_attr($this->get_field_name('oh_saturday_time1o')); ?>" id="<?php echo esc_attr($this->get_field_id('oh_saturday_time1o')); ?>" class="widefat">
		<?php
  		foreach ($oh_options_o as $key => $name) {
  			echo '<option value="' . esc_attr($key) . '" id="' . esc_attr($key) . '" '. selected($oh_saturday_time1o, $key, false) . '>'. $name . '</option>';
  		}
    ?>
		</select>
    <select name="<?php echo esc_attr($this->get_field_name('oh_saturday_time1c')); ?>" id="<?php echo esc_attr($this->get_field_id('oh_saturday_time1c')); ?>" class="widefat">
		<?php
  		foreach ($oh_options_c as $key => $name) {
  			echo '<option value="' . esc_attr($key) . '" id="' . esc_attr($key) . '" '. selected($oh_saturday_time1c, $key, false) . '>'. $name . '</option>';
  		}
    ?>
		</select>
    <p>
      <input id="<?php echo esc_attr($this->get_field_id('oh_sunday_checkbox')); ?>" name="<?php echo esc_attr($this->get_field_name('oh_sunday_checkbox')); ?>" type="checkbox" value="1" <?php checked('1', $oh_sunday_checkbox ); ?> />
		  <label for="<?php echo esc_attr($this->get_field_id('oh_sunday_checkbox')); ?>"><?php _e('Sunday', 'openhours'); ?></label>
    </p>
    <select name="<?php echo esc_attr($this->get_field_name('oh_sunday_time1o')); ?>" id="<?php echo esc_attr($this->get_field_id('oh_sunday_time1o')); ?>" class="widefat">
		<?php
  		foreach ($oh_options_o as $key => $name) {
  			echo '<option value="' . esc_attr($key) . '" id="' . esc_attr($key) . '" '. selected($oh_sunday_time1o, $key, false) . '>'. $name . '</option>';
  		}
    ?>
		</select>
    <select name="<?php echo esc_attr($this->get_field_name('oh_sunday_time1c')); ?>" id="<?php echo esc_attr($this->get_field_id('oh_sunday_time1c')); ?>" class="widefat">
		<?php
  		foreach ($oh_options_c as $key => $name) {
  			echo '<option value="' . esc_attr($key) . '" id="' . esc_attr($key) . '" '. selected($oh_sunday_time1c, $key, false) . '>'. $name . '</option>';
  		}
    ?>
		</select>
  <?php }

  public function update($new_instance, $old_instance) {
  	$oh_instance = $old_instance;
  	$oh_instance['oh_title']              = isset($new_instance['oh_title']) ? wp_strip_all_tags($new_instance['oh_title']) : '';
  	$oh_instance['oh_display_mode']       = isset($new_instance['oh_display_mode']) ? wp_strip_all_tags($new_instance['oh_display_mode']) : '';
    $oh_instance['oh_clock_adjustment']   = isset($new_instance['oh_clock_adjustment']) ? wp_strip_all_tags($new_instance['oh_clock_adjustment']) : '';
    $oh_instance['oh_clocktime_format']   = isset($new_instance['oh_clocktime_format']) ? wp_strip_all_tags($new_instance['oh_clocktime_format']) : '';
    $oh_instance['oh_text_opened']        = isset($new_instance['oh_text_opened']) ? ($new_instance['oh_text_opened']) : '';
  	$oh_instance['oh_text_closed']        = isset($new_instance['oh_text_closed']) ? ($new_instance['oh_text_closed']) : '';
  	$oh_instance['oh_monday_checkbox']    = isset($new_instance['oh_monday_checkbox']) ? 1 : false;
  	$oh_instance['oh_monday_time1o']      = isset($new_instance['oh_monday_time1o']) ? wp_strip_all_tags($new_instance['oh_monday_time1o']) : '';
  	$oh_instance['oh_monday_time1c']      = isset($new_instance['oh_monday_time1c']) ? wp_strip_all_tags($new_instance['oh_monday_time1c']) : '';
    $oh_instance['oh_tuesday_checkbox']   = isset($new_instance['oh_tuesday_checkbox']) ? 1 : false;
  	$oh_instance['oh_tuesday_time1o']     = isset($new_instance['oh_tuesday_time1o']) ? wp_strip_all_tags($new_instance['oh_tuesday_time1o']) : '';
  	$oh_instance['oh_tuesday_time1c']     = isset($new_instance['oh_tuesday_time1c']) ? wp_strip_all_tags($new_instance['oh_tuesday_time1c']) : '';
    $oh_instance['oh_wednesday_checkbox'] = isset($new_instance['oh_wednesday_checkbox']) ? 1 : false;
  	$oh_instance['oh_wednesday_time1o']   = isset($new_instance['oh_wednesday_time1o']) ? wp_strip_all_tags($new_instance['oh_wednesday_time1o']) : '';
  	$oh_instance['oh_wednesday_time1c']   = isset($new_instance['oh_wednesday_time1c']) ? wp_strip_all_tags($new_instance['oh_wednesday_time1c']) : '';
    $oh_instance['oh_thursday_checkbox']  = isset($new_instance['oh_thursday_checkbox']) ? 1 : false;
  	$oh_instance['oh_thursday_time1o']    = isset($new_instance['oh_thursday_time1o']) ? wp_strip_all_tags($new_instance['oh_thursday_time1o']) : '';
  	$oh_instance['oh_thursday_time1c']    = isset($new_instance['oh_thursday_time1c']) ? wp_strip_all_tags($new_instance['oh_thursday_time1c']) : '';
    $oh_instance['oh_friday_checkbox']    = isset($new_instance['oh_friday_checkbox']) ? 1 : false;
  	$oh_instance['oh_friday_time1o']      = isset($new_instance['oh_friday_time1o']) ? wp_strip_all_tags($new_instance['oh_friday_time1o']) : '';
  	$oh_instance['oh_friday_time1c']      = isset($new_instance['oh_friday_time1c']) ? wp_strip_all_tags($new_instance['oh_friday_time1c']) : '';
    $oh_instance['oh_saturday_checkbox']  = isset($new_instance['oh_saturday_checkbox']) ? 1 : false;
  	$oh_instance['oh_saturday_time1o']    = isset($new_instance['oh_saturday_time1o']) ? wp_strip_all_tags($new_instance['oh_saturday_time1o']) : '';
  	$oh_instance['oh_saturday_time1c']    = isset($new_instance['oh_saturday_time1c']) ? wp_strip_all_tags($new_instance['oh_saturday_time1c']) : '';
    $oh_instance['oh_sunday_checkbox']    = isset($new_instance['oh_sunday_checkbox']) ? 1 : false;
  	$oh_instance['oh_sunday_time1o']      = isset($new_instance['oh_sunday_time1o']) ? wp_strip_all_tags($new_instance['oh_sunday_time1o']) : '';
  	$oh_instance['oh_sunday_time1c']      = isset($new_instance['oh_sunday_time1c']) ? wp_strip_all_tags($new_instance['oh_sunday_time1c']) : '';
	return $oh_instance;
  }

  public function widget($args, $oh_instance) {
  	extract($args );
  	$oh_title              = isset($oh_instance['oh_title']) ? apply_filters('widget_title', $oh_instance['oh_title']) : '';
  	$oh_text_opened        = isset($oh_instance['oh_text_opened']) ? $oh_instance['oh_text_opened'] : '';
  	$oh_text_closed        = isset($oh_instance['oh_text_closed']) ? $oh_instance['oh_text_closed'] : '';
  	$oh_display_mode       = isset($oh_instance['oh_display_mode']) ? $oh_instance['oh_display_mode'] : '';
  	$oh_clock_adjustment   = isset($oh_instance['oh_clock_adjustment']) ? $oh_instance['oh_clock_adjustment'] : '';
  	$oh_clocktime_format   = isset($oh_instance['oh_clocktime_format']) ? $oh_instance['oh_clocktime_format'] : '';
  	$oh_monday_checkbox    = ! empty($oh_instance['oh_monday_checkbox']) ? $oh_instance['oh_monday_checkbox'] : false;
  	$oh_monday_time1o      = isset($oh_instance['oh_monday_time1o']) ? $oh_instance['oh_monday_time1o'] : '';
  	$oh_monday_time1c      = isset($oh_instance['oh_monday_time1c']) ? $oh_instance['oh_monday_time1c'] : '';
    $oh_tuesday_checkbox   = ! empty($oh_instance['oh_tuesday_checkbox']) ? $oh_instance['oh_tuesday_checkbox'] : false;
  	$oh_tuesday_time1o     = isset($oh_instance['oh_tuesday_time1o']) ? $oh_instance['oh_tuesday_time1o'] : '';
  	$oh_tuesday_time1c     = isset($oh_instance['oh_tuesday_time1c']) ? $oh_instance['oh_tuesday_time1c'] : '';
    $oh_wednesday_checkbox = ! empty($oh_instance['oh_wednesday_checkbox']) ? $oh_instance['oh_wednesday_checkbox'] : false;
  	$oh_wednesday_time1o   = isset($oh_instance['oh_wednesday_time1o']) ? $oh_instance['oh_wednesday_time1o'] : '';
  	$oh_wednesday_time1c   = isset($oh_instance['oh_wednesday_time1c']) ? $oh_instance['oh_wednesday_time1c'] : '';
    $oh_thursday_checkbox  = ! empty($oh_instance['oh_thursday_checkbox']) ? $oh_instance['oh_thursday_checkbox'] : false;
  	$oh_thursday_time1o    = isset($oh_instance['oh_thursday_time1o']) ? $oh_instance['oh_thursday_time1o'] : '';
  	$oh_thursday_time1c    = isset($oh_instance['oh_thursday_time1c']) ? $oh_instance['oh_thursday_time1c'] : '';
    $oh_friday_checkbox    = ! empty($oh_instance['oh_friday_checkbox']) ? $oh_instance['oh_friday_checkbox'] : false;
  	$oh_friday_time1o      = isset($oh_instance['oh_friday_time1o']) ? $oh_instance['oh_friday_time1o'] : '';
  	$oh_friday_time1c      = isset($oh_instance['oh_friday_time1c']) ? $oh_instance['oh_friday_time1c'] : '';
    $oh_saturday_checkbox  = ! empty($oh_instance['oh_saturday_checkbox']) ? $oh_instance['oh_saturday_checkbox'] : false;
  	$oh_saturday_time1o    = isset($oh_instance['oh_saturday_time1o']) ? $oh_instance['oh_saturday_time1o'] : '';
  	$oh_saturday_time1c    = isset($oh_instance['oh_saturday_time1c']) ? $oh_instance['oh_saturday_time1c'] : '';
    $oh_sunday_checkbox    = ! empty($oh_instance['oh_sunday_checkbox']) ? $oh_instance['oh_sunday_checkbox'] : false;
  	$oh_sunday_time1o      = isset($oh_instance['oh_sunday_time1o']) ? $oh_instance['oh_sunday_time1o'] : '';
  	$oh_sunday_time1c      = isset($oh_instance['oh_sunday_time1c']) ? $oh_instance['oh_sunday_time1c'] : '';
    $oh_status = 0;
    $oh_today = date('l');
    $wpsettings_time = current_time('H:i');
    $wpsettings_format = get_option('time_format');
    $oh_now = date('H:i',strtotime($clock_adjustment,strtotime($wpsettings_time)));

  	echo $before_widget;
    echo '<div class="widget-text wp_widget_openhours">';
		if ($title) {
			echo $before_title . $title . $after_title;
		}
    if ($oh_today == "Monday" && $oh_monday_checkbox == 1) {
      if ($oh_now >= $oh_monday_time1o && $oh_now < $oh_monday_time1c) { $oh_status = 1; }
    }
    else if ($oh_today == "Tuesday" && $oh_tuesday_checkbox == 1) {
      if ($oh_now >= $oh_tuesday_time1o && $oh_now < $oh_tuesday_time1c) { $oh_status = 1; }
    }
    else if ($oh_today == "Wednesday" && $oh_wednesday_checkbox == 1) {
      if ($oh_now >= $oh_wednesday_time1o && $oh_now < $oh_wednesday_time1c) { $oh_status = 1; }
    }
    else if ($oh_today == "Thursday" && $oh_thursday_checkbox == 1) {
      if ($oh_now >= $oh_thursday_time1o && $oh_now < $oh_thursday_time1c) { $oh_status = 1; }
    }
    else if ($oh_today == "Friday" && $oh_friday_checkbox == 1) {
      if ($oh_now >= $oh_friday_time1o && $oh_now < $oh_friday_time1c) { $oh_status = 1; }
    }
    else if ($oh_today == "Saturday" && $oh_saturday_checkbox == 1) {
      if ($oh_now >= $oh_saturday_time1o && $oh_now < $oh_saturday_time1c) { $oh_status = 1; }
    }
    else if ($oh_today == "Sunday" && $oh_sunday_checkbox == 1) {
      if ($oh_now >= $oh_sunday_time1o && $oh_now < $oh_sunday_time1c) { $oh_status = 1; }
    }
    else {
      $oh_status = 0;
    }

    // Display Option #1 : Dynamic text status -------------------------------
    if ($oh_display_mode == 'status_only') {
      switch ($oh_status) {
        case 0:
          if ($oh_text_closed ) {
            echo '<p>' . $oh_text_closed . '</p>';
          }
        break;
        case 1:
          if ($oh_text_opened ) {
            echo '<p>' . $oh_text_opened . '</p>';
          }
        break;
      }
    }

    // Display Option #2 & #3 : Timetable mode -------------------------------
    if ($oh_display_mode == 'timetable_full' || $oh_display_mode == 'timetable_light') {
      if (!function_exists('time_format')) {
        function time_format($wpsettings_format, $oh_now) {
          $wpformat_time = date($wpsettings_format,strtotime($oh_now));
          return $wpformat_time;
        }
      }

      echo "<table>";

      // Monday --------------------------------------------------------------
      $details = '';
      if ($oh_monday_checkbox) {
        if ($oh_monday_time1o && $oh_monday_time1c) {
          $details = '<td>'.time_format($oh_clocktime_format, $oh_monday_time1o).'-'.time_format($oh_clocktime_format, $oh_monday_time1c);
        }
        $details .= '</td>';
      }
      else {
        $details = '<td>'.esc_attr(__('closed', 'openhours')).'</td>';
      }
      if ($oh_display_mode == 'timetable_light' && $oh_monday_checkbox != 1) {
        // Further potential development
      }

      else {
        echo '<tr class="';
        if ($oh_today == "Tuesday") {
          echo "active";
        };
        echo '"><td>'.__('Monday', 'openhours').': </td>'.$details. '</tr>';
      }

      // Tuesday -------------------------------------------------------------
      $details = '';
      if ($oh_tuesday_checkbox) {
        if ($oh_tuesday_time1o && $oh_tuesday_time1c) {
          $details = '<td>'.time_format($oh_clocktime_format, $oh_tuesday_time1o).'-'.time_format($oh_clocktime_format, $oh_tuesday_time1c);
        }
        $details .= '</td>';
      }
      else {
        $details = '<td>'.esc_attr(__('closed', 'openhours')).'</td>';
      }
      if ($oh_display_mode == 'timetable_light' && $oh_tuesday_checkbox != 1) {
        // Further potential development
      }

      else {
        echo '<tr class="';
        if ($oh_today == "Tuesday") {
          echo "active";
        };
        echo '"><td>'.__('Tuesday', 'openhours').': </td>'.$details. '</tr>';
      }

      // Wednesday -------------------------------------------------------------
      $details = '';
      if ($oh_wednesday_checkbox) {
        if ($oh_wednesday_time1o && $oh_wednesday_time1c) {
          $details = '<td>'.time_format($oh_clocktime_format, $oh_wednesday_time1o).'-'.time_format($oh_clocktime_format, $oh_wednesday_time1c);
        }
        $details .= '</td>';
      }
      else {
        $details = '<td>'.esc_attr(__('closed', 'openhours')).'</td>';
      }
      if ($oh_display_mode == 'timetable_light' && $oh_wednesday_checkbox != 1) {
        // Further potential development
      }

      else {
        echo '<tr class="';
        if ($oh_today == "Wednesday") {
          echo "active";
        };
        echo '"><td>'.__('Wednesday', 'openhours').': </td>'.$details. '</tr>';
      }

      // Thursday -------------------------------------------------------------
      $details = '';
      if ($oh_thursday_checkbox) {
        if ($oh_thursday_time1o && $oh_thursday_time1c) {
          $details = '<td>'.time_format($oh_clocktime_format, $oh_thursday_time1o).'-'.time_format($oh_clocktime_format, $oh_thursday_time1c);
        }
        $details .= '</td>';
      }
      else {
        $details = '<td>'.esc_attr(__('closed', 'openhours')).'</td>';
      }
      if ($oh_display_mode == 'timetable_light' && $oh_thursday_checkbox != 1) {
        // Further potential development
      }

      else {
        echo '<tr class="';
        if ($oh_today == "Thursday") {
          echo "active";
        };
        echo '"><td>'.__('Thursday', 'openhours').': </td>'.$details. '</tr>';
      }

      // Friday -------------------------------------------------------------
      $details = '';
      if ($oh_friday_checkbox) {
        if ($oh_friday_time1o && $oh_friday_time1c) {
          $details = '<td>'.time_format($oh_clocktime_format, $oh_friday_time1o).'-'.time_format($oh_clocktime_format, $oh_friday_time1c);
        }
        $details .= '</td>';
      }
      else {
        $details = '<td>'.esc_attr(__('closed', 'openhours')).'</td>';
      }
      if ($oh_display_mode == 'timetable_light' && $oh_friday_checkbox != 1) {
        // Further potential development
      }

      else {
        echo '<tr class="';
        if ($oh_today == "Friday") {
          echo "active";
        };
        echo '"><td>'.__('Friday', 'openhours').': </td>'.$details. '</tr>';
      }

      // Saturday -------------------------------------------------------------
      $details = '';
      if ($oh_saturday_checkbox) {
        if ($oh_saturday_time1o && $oh_saturday_time1c) {
          $details = '<td>'.time_format($oh_clocktime_format, $oh_saturday_time1o).'-'.time_format($oh_clocktime_format, $oh_saturday_time1c);
        }
        $details .= '</td>';
      }
      else {
        $details = '<td>'.esc_attr(__('closed', 'openhours')).'</td>';
      }
      if ($oh_display_mode == 'timetable_light' && $oh_saturday_checkbox != 1) {
        // Further potential development
      }

      else {
        echo '<tr class="';
        if ($oh_today == "Saturday") {
          echo "active";
        };
        echo '"><td>'.__('Saturday', 'openhours').': </td>'.$details. '</tr>';
      }

      // Sunday -------------------------------------------------------------
      $details = '';
      if ($oh_sunday_checkbox) {
        if ($oh_sunday_time1o && $oh_sunday_time1c) {
          $details = '<td>'.time_format($oh_clocktime_format, $oh_sunday_time1o).'-'.time_format($oh_clocktime_format, $oh_sunday_time1c);
        }
        $details .= '</td>';
      }
      else {
        $details = '<td>'.esc_attr(__('closed', 'openhours')).'</td>';
      }
      if ($oh_display_mode == 'timetable_light' && $oh_sunday_checkbox != 1) {
        // Further potential development
      }

      else {
        echo '<tr class="';
        if ($oh_today == "Sunday") {
          echo "active";
        };
        echo '"><td>'.__('Sunday', 'openhours').': </td>'.$details. '</tr>';
      }
    }
  	echo '</table></div>';
  	echo $after_widget;
  }
}

function oh_register_custom_widget() {
	register_widget('OH_Openhours_Widget');
  wp_register_style('oh_style', plugins_url('openhours/assets/css/styles.css'));
  wp_enqueue_style('oh_style');
}
add_action('widgets_init', 'oh_register_custom_widget');

function oh_plugin_load_textdomain() {
  load_plugin_textdomain('openhours', false, basename( dirname( __FILE__ )) . '/languages');
}
add_action('plugins_loaded', 'oh_plugin_load_textdomain');
