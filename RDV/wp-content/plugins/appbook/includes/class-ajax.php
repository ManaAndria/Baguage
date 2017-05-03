<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * AppResto AppRestoAjax class.
 *
 */
class AppRestoAjax 
{
	public static function init()
	{
		$ajax_actions = array(
			'new_service' => true,
			'new_employee' => true,
			'new_period' => true,
			'new_opening' => true,
			'new_closing' => true,

			'edit_service' => true,
			'edit_employee' => true,
			'edit_period' => true,
			'edit_opening' => true,
			'edit_closing' => true,
			
			'delete_service' => true,
			'delete_employee' => true,
			'delete_period' => true,
			'delete_opening' => true,
			'delete_closing' => true,
		);
		foreach ($ajax_actions as $ajax_action => $nopriv) {
			add_action( 'wp_ajax_'.appBook()->slug.'_' . $ajax_action, array( __CLASS__, $ajax_action ) );
			if ( $nopriv ) {
				add_action( 'wp_ajax_nopriv_'.appBook()->slug.'_' . $ajax_action, array( __CLASS__, $ajax_action ) );
			}
		}
	}

	// NEW
	public static function new_service()
	{
		load_template(appBook()->template_path."service-new.php", false);
		die();
	}

	public static function new_employee()
	{
		load_template(appBook()->template_path."employee-new.php", false);
		die();
	}

	public static function new_period()
	{
		load_template(appBook()->template_path."period-new.php", false);
		die();
	}

	public static function new_opening()
	{
		load_template(appBook()->template_path."opening-new.php", false);
		die();
	}

	public static function new_closing()
	{
		load_template(appBook()->template_path."closing-new.php", false);
		die();
	}

	// EDIT
	public static function edit_service()
	{
		if ( isset($_POST['action']) && ($_POST['action'] == appBook()->slug.'_edit_service') && isset($_POST['data']) )
		{
			load_template( appBook()->template_path."service-new.php", false);
		}
		die();
	}
	
	public static function edit_employee()
	{
		if ( isset($_POST['action']) && ($_POST['action'] == appBook()->slug.'_edit_employee') && isset($_POST['data']) )
		{
			load_template( appBook()->template_path."employee-new.php", false);
		}
		die();
	}

	public static function edit_period()
	{
		if ( isset($_POST['action']) && ($_POST['action'] == appBook()->slug.'_edit_period') && isset($_POST['data']) )
		{
			load_template( appBook()->template_path."period-new.php", false);
		}
		die();
	}

	public static function edit_opening()
	{
		if ( isset($_POST['action']) && ($_POST['action'] == appBook()->slug.'_edit_opening') && isset($_POST['data']) )
		{
			load_template( appBook()->template_path."opening-new.php", false);
		}
		die();
	}

	public static function edit_closing()
	{
		if ( isset($_POST['action']) && ($_POST['action'] == appBook()->slug.'_edit_closing') && isset($_POST['data']) )
		{
			load_template( appBook()->template_path."closing-new.php", false);
		}
		die();
	}

	// DELETE
	public static function delete_service()
	{
		if ( isset($_POST['action']) && ($_POST['action'] == appBook()->slug.'_delete_service') && isset($_POST['data']) )
		{
			$res = appBook()->app->service->delete($_POST['data']);
		}
		if (!$res)
			exit('0');
		else
			exit('1');
	}
	
	public static function delete_employee()
	{
		if ( isset($_POST['action']) && ($_POST['action'] == appBook()->slug.'_delete_employee') && isset($_POST['data']) )
		{
			$res = appBook()->app->employee->delete($_POST['data']);
		}
		if (!$res)
			exit('0');
		else
			exit('1');
	}

	public static function delete_period()
	{
		if ( isset($_POST['action']) && ($_POST['action'] == appBook()->slug.'_delete_period') && isset($_POST['data']) )
		{
			$res = appBook()->app->period->delete($_POST['data']);
		}
		if (!$res)
			exit('0');
		else
			exit('1');
	}

	public static function delete_opening()
	{
		if ( isset($_POST['action']) && ($_POST['action'] == appBook()->slug.'_delete_opening') && isset($_POST['data']) )
		{
			$res = appBook()->app->opening->delete($_POST['data']);
		}
		if (!$res)
			exit('0');
		else
			exit('1');
	}

	public static function delete_closing()
	{
		if ( isset($_POST['action']) && ($_POST['action'] == appBook()->slug.'_delete_closing') && isset($_POST['data']) )
		{
			$res = appBook()->app->closing->delete($_POST['data']);
		}
		if (!$res)
			exit('0');
		else
			exit('1');
	}
}
AppRestoAjax::init();