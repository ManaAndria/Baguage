<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * AppBook AppPeriod class.
 *
 */
class AppPeriod
{
	protected $db_name;

	public $app_id = null;

	public function __construct($app_id)
	{
		global $wpdb;
		$this->app_id = (int)$app_id;
		$this->db_name = $wpdb->prefix . appBook()->slug . '_period';
	}

	public function getSingle($id)
	{
		global $wpdb;

		$period_id = (int)$id;
		$query = "SELECT * FROM {$this->db_name} WHERE `app_id`={$this->app_id} AND `period_id`={$period_id}";
		$res = $wpdb->get_row($query, OBJECT);
		if ($res)
			return $res;
		else
			return null;
	}

	public function getPeriodByEmployee($id)
	{
		global $wpdb;

		$employee_id = (int)$id;
		$query = "SELECT * FROM {$this->db_name} WHERE `app_id`={$this->app_id} AND `employee_id`={$employee_id}";
		$res = $wpdb->get_results($query, ARRAY_A);
		if ($res)
			return $res;
		else
			return null;
	}

	public function create($datas)
	{
		global $wpdb;
		
		$period = $datas['hour'].':'.$datas['minute'];
		$employee_id = (int)$datas['employee_id'];
		$fields = array( 
			'app_id' => $this->app_id,
			'employee_id' => $employee_id,
			'period' => $period
		);
		$format = array(
			'%d',
			'%d',
			'%s'
		);
		$res = $wpdb->insert( $this->db_name, $fields, $format );

		return $res;
	}

	public function update($datas)
	{
		global $wpdb;

		$period = $datas['hour'].':'.$datas['minute'];
		$employee_id = (int)$datas['employee_id'];
		$period_id = (int)$datas['period_id'];
		$fields = array('period' => $period);
		$format = array('%s');
		$where = array( 'period_id' => $period_id, 'app_id' => $this->app_id, 'employee_id' => $employee_id );
		$where_format = array( '%d', '%d', '%d' );
		$res = $wpdb->update( $this->db_name, $fields, $where, $format, $where_format );
		
		return $res;
	}

	public function delete($id)
	{
		global $wpdb;
		
		$period_id = (int)$id;
		return $wpdb->delete($this->db_name, array('app_id' => $this->app_id, 'period_id' => $period_id), '%d');
	}

	public function getFieldById($id, $field)
	{
		global $wpdb;

		$period_id = (int)$id;
		$query = "SELECT `{$field}` FROM {$this->db_name} WHERE `app_id`={$this->app_id} AND `period_id`={$period_id}";
		return $wpdb->get_var($query);
	}
}