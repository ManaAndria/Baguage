<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * App class.
 *
 */
class App
{
	protected $db_name;

	public $app_id = null;

	public $datas = null;

	public $employee = null;

	public $service = null;
	
	public $userinfo =null;
	
	public $period = null;

	public $booking = null;

	public $opening = null;
	
	public $closing = null;
	
	public $stats = null;

	public $user_id;

	protected $editable_fields = array("app_name", "address", "zip", "city", "hour_zone", "country_code", "email_contact", "phonenumber", "days_last_booking", "capacity", "message");

	protected $required_fields = array("app_name", "address", "zip", "city", "hour_zone", "country_code", "email_contact", "phonenumber", "capacity");

	public function __construct($user_id)
	{
		global $wpdb;

		$this->db_name = $wpdb->prefix . appBook()->slug . '_app';
		$this->user_id = (int)$user_id;
		$this->loadDatas();
		if ($this->app_id)
			$this->load();
	}

	public function loadDatas()
	{
		global $wpdb;
		$query = "SELECT * FROM {$this->db_name} WHERE `user_id`={$this->user_id}";
		$datas = $wpdb->get_row($query, OBJECT);
		if (!empty( $datas) )
		{
			$this->datas = $datas;
			if ($this->app_id == null)
				$this->app_id = (int)$datas->app_id;
		}
		
	}

	public function load()
	{
		$this->employee = new AppEmployee($this->app_id);
		$this->service = new AppService($this->app_id);
		$this->userinfo = new AppUserInfo($this->app_id);
		$this->period = new AppPeriod($this->app_id);
		$this->booking = new AppBooking($this->app_id);
		$this->opening = new AppOpening($this->app_id);
		$this->closing = new AppClosing($this->app_id);
		$this->stats = new AppStats($this->app_id);
	}

	public function getRequiredFields()
	{
		return $this->required_fields;
	}

	public function create($user_id, $datas)
	{
		global $wpdb;

		$user_id = (int)$user_id;
		$field = array( 
			'user_id' => $user_id,
		);
		$format = array(
			'%d' 
		);
		$app = $wpdb->insert( $this->db_name, $field, $format );
		$app_id = $wpdb->insert_id;

		$info = new AppUserInfo($app_id);
		$create = $info->create($user_id, $datas);

		return $create;
	}

	public function update($datas)
	{
		global $wpdb;

		$fields = array();
		foreach ($this->editable_fields as $key) {
			$fields[$key] = $datas[$key];
		}
		$format = array(
			'%s', '%s', '%s', '%s','%s', '%s', '%s', '%s', '%d', '%d', '%s'
		);
		$where = array( 'app_id' => $this->app_id , 'user_id' => $this->user_id);
		$where_format = array( '%d', '%d' );
		$res = $wpdb->update( $this->db_name, $fields, $where, $format, $where_format );
		if ($res)
			$this->loadDatas();
		
		return $res;
	}
}