<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$app = appBook();
$days = $app->app->opening->days;
?>
<div class="modal fade" id="add-service" tabindex="-1" role="dialog" aria-labelledby="add-edit-title">
 	<div class="modal-dialog" role="document">
	    <div class="modal-content">
	      	<div class="modal-header">
	        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        	<h4 class="modal-title" id="add-edit-title"></h4>
	      	</div>
	      	<div class="modal-body container-fluid">
	      	</div>
	      	<div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('Annuler', $app->slug) ?></button>
		        <button id="confirm-add" type="button" class="btn btn-primary"><?php echo __('Sauvegarder', $app->slug) ?></button>
	      	</div>
	    </div>
  	</div>
</div>
<div class="modal fade" id="confirmDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
 	<div class="modal-dialog" role="document">
	    <div class="modal-content">
	      	<div class="modal-header">
	        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        	<h4 class="modal-title" id="myModalLabel"><?php echo __('Supprimer un service', $app->slug) ?></h4>
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
<div class="col-xs-12 row" id="opening">
<?php
foreach ($days as $key => $day) { 
	$openings = $app->app->opening->getServiceByDay($key);
?>
	<div class="panel panel-default">
 		<div class="panel-heading"><div class="center-block"><?php echo ucfirst(__($day, $app->slug)); ?></div></div>
  		<div class="panel-body">
    		<div class="pull-right">
    			<button class="btn btn-sm pull-right btn-success add-service" data-toggle="modal" data-loading-text="<?php _e("Patientez", $app->slug) ?> ..." aria-pressed="false" data-remote="true" data-day="<?php echo $key ?>">
	  				<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>&nbsp;&nbsp;<?php _e("Ajouter une période", $app->slug) ?>
  				</button>
    		</div>
  		</div>
  		<?php
		if ( count($openings) ){
		?>
  		<table class="table-responsive app-table">
    		<thead>
    			<tr>
    				<th><?php _e('Service', $app->slug) ?></th>
	    			<th><?php _e('Début', $app->slug); ?></th>
	    			<th><?php _e('Fin', $app->slug); ?></th>
	    			<th></th>
    			</tr>
    		</thead>
    		<tbody>
    		<?php
			foreach ($openings as $opening){
				$service_name = $app->app->service->getServiceName($opening->service_id);
			?>
				<tr id="<?php echo $opening->opening_id ?>">
					<td><?php echo $service_name ?></td>
					<td><?php echo $opening->start ?></td>
					<td><?php echo $opening->end ?></td>
					<td>
						<div class="pull-right">
				    		<button class="btn btn-sm btn-default edit-service" autocomplete="off" data-loading-text="<?php _e("Patientez", $app->slug) ?> ..." data-toggle="button" aria-pressed="false" data-id="<?php echo $opening->opening_id ?>" data-service="<?php echo $opening->service_id ?>">
				    			<span class="glyphicon glyphicon-edit" aria-hidden="true" title="<?php echo __('Modifier', $app->slug); ?>"></span>	
				    		</button>
							<button class="btn btn-sm btn-danger delete-service" autocomplete="off" data-toggle="modal" aria-pressed="false" data-id="<?php echo $opening->opening_id ?>" data-target="#confirmDelete">
				    			<span class="glyphicon glyphicon-remove" aria-hidden="true" title="<?php echo __('Supprimer', $app->slug); ?>"></span>
				    		</button>
			    		</div>
					</td>
				</tr>
			<?php
			}
			?>	
    		</tbody>
  		</table>
  		<?php
  		}
		?>
	</div>
<?php	
}
?>
<input type="hidden" id="opening_id" name="opening_id" value="">
</div>