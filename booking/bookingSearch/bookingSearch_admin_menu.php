<?php

/**
* 
*/
class BookingSearch_admin_menu
{
	
	function __construct()
	{
		add_action('admin_menu', array($this, 'add_admin_menu'), 20);
		add_action('admin_init', array($this, 'register_settings'));
		
	}

	//add menu to the wordpress sidebar
	public function add_admin_menu()
	{
	    add_menu_page(__('BookingSearch','Booking-search'), __('BookingSearch','Booking-search'), 'manage_options', 'bookingSearch', array($this, 'menu_html'));
	}

	//html content of the admin menu
	public function menu_html()
	{
	    echo '<h1>'.get_admin_page_title().'</h1>';
	    ?>
	    <form method="post" action="options.php">
	    	<?php settings_fields('bookingSearch_settings') ?>
	    	<?php do_settings_sections('bookingSearch_settings') ?> <br>
			<?php submit_button(__('Save changes','Booking-search')); ?>
	    </form>
	    <?php

	}

	//create setting option and section
	public function register_settings()
	{	
		//options group declaration
	    register_setting('bookingSearch_settings', 'dbs_client_id');
	    register_setting('bookingSearch_settings', 'dbs_client_secret');
	    register_setting('bookingSearch_settings', 'dbs_authorization');

	    //sections
	    add_settings_section('bookingSearch_section', __('Customer parameter','Booking-search'), array($this, 'section_html'), 'bookingSearch_settings');

	    //fields
	    add_settings_field('dbs_client_id', __('Client ID','Booking-search'), array($this, 'dbs_client_id_html'), 'bookingSearch_settings', 'bookingSearch_section');
	    add_settings_field('dbs_client_secret', __('Client secret','Booking-search'), array($this, 'dbs_client_secret_html'), 'bookingSearch_settings', 'bookingSearch_section');
	    add_settings_field('dbs_authorization', __('Authorization','Booking-search'), array($this, 'dbs_authorization_html'), 'bookingSearch_settings', 'bookingSearch_section');

	}

	//section rendu
	public function section_html()
	{
		//echo __('Give Informations','Booking-search');
	}

	//field rendu for dbs_client_id
	public function dbs_client_id_html()
	{
		?>
	    <input type="text" name="dbs_client_id" value="<?php echo get_option('dbs_client_id')?>" style="
    width: 600px !important;"/>

	    <?php
	}

	//field rendu for dbs_client_secret
	public function dbs_client_secret_html()
	{
		?>
	    <input type="text" name="dbs_client_secret" value="<?php echo get_option('dbs_client_secret')?>" style="
    width: 600px !important;"/>

	    <?php
	}

	//field rendu for dbs_authorization
	public function dbs_authorization_html()
	{
		?>
		<input type="text" name="dbs_authorization" value="<?php echo get_option('dbs_authorization')?>" style="
    width: 600px !important;"/>

	    <?php
	}

	
}