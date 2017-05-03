<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$app = appBook();
$employees = $app->app->employee->datas;
?>
<div class="modal fade" id="confirmDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
 	<div class="modal-dialog" role="document">
	    <div class="modal-content">
	      	<div class="modal-header">
	        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        	<h4 class="modal-title" id="myModalLabel"><?php echo __('Supprimer une période', $app->slug) ?></h4>
	      	</div>
	      	<div class="modal-body">
	        <?php echo __("Êtes vous sûr de vouloir supprimer !?") ?>
	      	</div>
	      	<div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('NON', $app->slug) ?></button>
		        <button id="confirm-delete" type="button" class="btn btn-primary" onclick=""><?php echo __('OUI', $app->slug) ?></button>
	      	</div>
	    </div>
  	</div>
</div>
<div class="col-xs-12 row" id="period">
	<div class="page-header row">
		<h2><?php echo __('Liste des périodes', $app->slug); ?></h2>
	</div>
	<?php
if (!count($employees))
	echo '<div class="alert alert-info" role="alert">'.__("Il n'y a aucune période", $app->slug).'</div>';
else
{
	foreach ($employees as $key => $employee) {// boucle employee
		$periods = $app->app->period->getPeriodByEmployee($employee->employee_id);
?>
	<div class="panel panel-default" id="employee-<?php echo $employee->employee_id ?>">
	  	<div class="panel-heading"><?php echo $employee->firstname.' '.$employee->lastname ?> - <?php echo $app->app->service->getServiceName($employee->poste) ?></div>
	  	<div class="panel-body">
	    	<div class="pull-right">
	  			<button class="period-new page-header-btn btn btn-large pull-right btn-success" data-toggle="button" aria-pressed="false" data-remote="true" data-loading-text="<?php _e("Patientez", $app->slug) ?> ..." data-employee="<?php echo $employee->employee_id ?>">
	  				<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>&nbsp;&nbsp;<?php _e("Ajouter une période", $app->slug) ?>
  				</button>
	  		</div>
	 	</div>
	  	<ul class="list-group">
	  	<?php 
	  	if ($periods !== null)
	  	{
	  		foreach ($periods as $period) {// boucle period
	  	?>
		    <li id="<?php echo $period->period_id ?>" class="list-group-item">
		    	<span class="pull-left"><?php echo $period->period ?></span>
		    	<div class="pull-right">
		    		<button class="btn btn-large btn-default edit-period" autocomplete="off" data-toggle="tooltip" aria-pressed="false" data-id="<?php echo $period->period_id ?>" data-employee="<?php echo $employee->employee_id ?>" data-loading-text="<?php _e("Patientez", $app->slug) ?> ...">
		    			<span class="glyphicon glyphicon-edit" aria-hidden="true" title="<?php echo __('Modifier', $app->slug); ?>"></span>		    			
		    		</button>
		    		<button class="btn btn-large btn-danger delete-period" autocomplete="off" data-toggle="modal" aria-pressed="false" data-id="<?php echo $period->period_id ?>" data-target="#confirmDelete">
		    			<span class="glyphicon glyphicon-remove" aria-hidden="true" title="<?php echo __('Supprimer', $app->slug); ?>"></span>
		    		</button>
		    	</div>
		    </li>
	    <?php
			}
		}
	    ?>
	  	</ul>
	</div>
<?php
	}
}
?>
<input type="hidden" id="period_id" name="period_id" value="">
</div>