<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * AppBook AppOpening class.
 *
 */
class AppOpening
{
	protected $db_name;

	public $app_id = null;

	public $days = array('0' => 'dimanche', '1' => 'lundi', '2' => 'mardi', '3' => 'mercredi', '4' => 'jeudi', '5' => 'vendredi', '6' => 'samedi');

	public function __construct($app_id)
	{
		global $wpdb;
		$this->app_id = (int)$app_id;
		$this->db_name = $wpdb->prefix . appBook()->slug . '_opening';
	}

	public function getSingle($id)
	{
		global $wpdb;

		$opening_id = (int)$id;
		$query = "SELECT * FROM {$this->db_name} WHERE `app_id`={$this->app_id} AND `opening_id`={$opening_id}";
		$res = $wpdb->get_row($query, OBJECT);
		if ($res)
			return $res;
		else
			return null;
	}
	public function filterByService($service_id, $day)
	{
		global $wpdb;

		$service_id = (int)$service_id;
		$day = (int)$day;
		$query = "SELECT * FROM {$this->db_name} WHERE `app_id`={$this->app_id} AND `service_id`={$service_id} AND `day`={$day}";
		$res = $wpdb->get_row($query, OBJECT);
		if ($res === null)
			return false;
		else
			return true;
	}

	public function getServiceByDay($day)
	{
		global $wpdb;
		$day = (int)$day;
		$query = "SELECT * FROM {$this->db_name} WHERE `app_id`={$this->app_id} AND `day`={$day}";
		return $wpdb->get_results($query, OBJECT);
	}

	public function create($datas)
	{
		global $wpdb;

		$service_id = (int)$datas['service_id'];
		$day = (int)$datas['day'];
		$start = $datas['start-hour'].':'.$datas['start-minute'];
		$end = $datas['end-hour'].':'.$datas['end-minute'];
		
		$fields = array( 
			'app_id' => $this->app_id,
			'service_id' => $service_id,
			'day' => $day,
			'start' => $start,
			'end' => $end,
		);
		$format = array(
			'%d', 
			'%d', 
			'%d', 
			'%s',
			'%s'
		);
		return $wpdb->insert( $this->db_name, $fields, $format );
	}

	public function update($datas)
	{
		global $wpdb;

		$opening_id = (int)$datas['opening_id'];
		$start = $datas['start-hour'].':'.$datas['start-minute'];
		$end = $datas['end-hour'].':'.$datas['end-minute'];
		
		$fields = array(
			'start' => $start,
			'end' => $end,
		);
		$format = array(
			'%s',
			'%s'
		);
		$where = array( 'app_id' => $this->app_id, 'opening_id' => $opening_id );
		$where_format = array( '%d', '%d' );
		return $wpdb->update( $this->db_name, $fields, $where, $format, $where_format );
	}

	public function delete($id)
	{
		global $wpdb;
		
		$opening_id = (int)$id;
		return $wpdb->delete($this->db_name, array('app_id' => $this->app_id, 'opening_id' => $opening_id), '%d');
	}
}