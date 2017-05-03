<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * AppBook AppBooking class.
 *
 */
class AppBooking
{
	protected $db_name;

	protected $db_name_period;

	public $app_id = null;

	public function __construct($app_id)
	{		global $wpdb;
		$this->app_id = (int)$app_id;
		$this->db_name = $wpdb->prefix . appBook()->slug . '_booking';
		$this->db_name_period = $wpdb->prefix . appBook()->slug . '_period';
	}

	public function getEvents()
	{
		global $wpdb;

		$query = "SELECT * FROM {$this->db_name} WHERE `app_id`={$this->app_id} AND DATEDIFF(`date`, NOW()) >= 0 ORDER BY `date` ASC ";
		$results = $wpdb->get_results($query);
		$res = [];
		foreach ($results as $result) {
			$arr = $this->getPeriodInfos($result->period_id);
			$title = $arr[0];
			$title .= $result->firstname.' '.$result->lastname.( $result->message != '' ? ' message: '.$result->message : '' );
			$res[] = array(
					'title' => $title,
					'start' => $result->date.' '.$arr[1]
				);
		}
		return json_encode($res);
	}

	public function getPeriodInfos($period_id)
	{
		global $wpdb;

		$res = [];
		$periodObject = new AppPeriod($this->app_id);
		$employee_id = $periodObject->getFieldById($period_id, 'employee_id');
		$period = $periodObject->getFieldById($period_id, 'period');

		$employeeObject = new AppEmployee($this->app_id);
		$employee = $employeeObject->getSingle($employee_id);
		$service_id = $employee->poste;

		$serviceObject = new AppService($this->app_id);
		$service = $serviceObject->getServiceName($service_id);

		$res[] = __('service: ', appBook()->slug).$service.', '.__('employé: ', appBook()->slug).$employee->firstname.' '.$employee->lastname.', '.__('client: ', appBook()->slug);
		$res[] = $period;
		return $res;
	}

	public function getCount($periods, $from = null , $to = null)
	{
		if (!is_array($periods))
			return false;

		if($from === null)
			$from = date( 'Y-m-d', strtotime('-1 month') );
		else
			$from = date('Y-m-d', $from);

		if($to === null)
			$to = date('Y-m-d', strtotime('+1 month'));
		else
			$to = date('Y-m-d', $to);

		$condition = implode(',', $periods);

		global $wpdb;
		$query = $wpdb->prepare("SELECT DATE(`date`) date, COUNT(`booking_id`) count FROM {$this->db_name} WHERE ( `date` BETWEEN '%s' AND '%s' ) AND `period_id` in (%s) GROUP BY DATE(date) ORDER BY date ASC", $from, $to, $condition);
		
		if ($wpdb->query($query))
		{
			$results = $wpdb->last_result;
			$ret = array();
			foreach ($results as $result) {
				$ret[$result->date] = $result->count;
			}
			return $ret;
		}
		else
			return null;
	}
}