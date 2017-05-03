<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * AppBook AppClosing class.
 *
 */
class AppClosing
{
	protected $db_name;

	public $app_id = null;
	
	public $datas = null;

	protected $frequency = array('aucune', 'annuelle');

	public function __construct($app_id)
	{
		global $wpdb;
		$this->app_id = (int)$app_id;
		$this->db_name = $wpdb->prefix . appBook()->slug . '_closing';
		$this->loadDatas();
	}

	public function loadDatas()
	{
		global $wpdb;

		$query = "SELECT * FROM {$this->db_name} WHERE `app_id`={$this->app_id}";
		$results = $wpdb->get_results($query, OBJECT);
		if ($results)
		{
			foreach ($results as $key => $result) {
				$results[$key]->frequency = $this->frequency[$result->frequency];
			}
			$this->datas = $results;
		}
	}

	public function getFrequency()
	{
		return $this->frequency;
	}

	public function getSingle($id)
	{
		global $wpdb;

		$closing_id = (int)$id;
		$query = "SELECT * FROM {$this->db_name} WHERE `app_id`={$this->app_id} AND `closing_id`={$closing_id}";
		$res = $wpdb->get_row($query, OBJECT);
		if ($res)
		{
			
			$res->frequency = $this->frequency[$res->frequency];
			return $res;
		}
		else
			return null;
	}

	public function create($datas)
	{
		global $wpdb;

		$start = $datas['start'];
		$end = $datas['end'];
		$frequency = (int)$datas['frequency'];
		
		$fields = array( 
			'app_id' => $this->app_id,
			'start' => $start,
			'end' => $end,
			'frequency' => $frequency
		);
		$format = array(
			'%d', 
			'%s',
			'%s',
			'%d',
		);
		$res = $wpdb->insert( $this->db_name, $fields, $format );
		if ($res)
			$this->loadDatas();

		return $res;
	}

	public function update($datas)
	{
		global $wpdb;

		$closing_id = (int)$datas['closing_id'];
		$start = $datas['start'];
		$end = $datas['end'];
		$frequency = (int)$datas['frequency'];
		
		$fields = array( 
			'start' => $start,
			'end' => $end,
			'frequency' => $frequency
		);
		$format = array(
			'%s',
			'%s',
			'%d'
		);
		$where = array( 'app_id' => $this->app_id, 'closing_id' => $closing_id );
		$where_format = array( '%d', '%d' );
		$res = $wpdb->update( $this->db_name, $fields, $where, $format, $where_format );
		if ($res)
			$this->loadDatas();
		return $res;
	}

	public function delete($id)
	{
		global $wpdb;
		
		$closing_id = (int)$id;
		return $wpdb->delete($this->db_name, array('app_id' => $this->app_id, 'closing_id' => $closing_id), '%d');
	}
}