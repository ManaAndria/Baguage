<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$app = appBook();
$closings = $app->app->closing->datas;
?>
<div class="modal fade" id="confirmDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
 	<div class="modal-dialog" role="document">
	    <div class="modal-content">
	      	<div class="modal-header">
	        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        	<h4 class="modal-title" id="myModalLabel"><?php echo __('Supprimer une fermeture', $app->slug) ?></h4>
	      	</div>
	      	<div class="modal-body">
	        <?php echo __("Êtes vous sûr de vouloir supprimer !?") ?>
	      	</div>
	      	<div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('NON', $app->slug) ?></button>
		        <button id="confirm-delete" type="button" class="btn btn-primary"><?php echo __('OUI', $app->slug) ?></button>
	      	</div>
	    </div>
  	</div>
</div>
<div class="col-xs-12 row" id="closing">
	<div class="page-header row">
		<button id="closing-new" class="page-header-btn btn btn-large pull-right btn-success" data-toggle="button" aria-pressed="false" data-loading-text="<?php _e("Patientez", $app->slug) ?> ..."><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>&nbsp;&nbsp;<?php _e("Ajouter une fermeture", $app->slug) ?></button>
	</div>
<?php
if (!count($closings))
	echo '<div class="alert alert-info" role="alert">'.__("Il n'y a aucune fermeture définie", $app->slug).'</div>';
else
{
?>
<table class="table app-table">
	<tr>
		<th><?php _e('Début', $app->slug) ?></th>
		<th><?php _e('Fin', $app->slug) ?></th>
		<th><?php _e('Fréquence', $app->slug) ?></th>
		<th><?php /*_e('Actions', $app->slug)*/ ?></th>
	</tr>
	<?php
	foreach ($closings as $key => $closing) { ?>
	<tr id="<?php echo $closing->closing_id ?>">
		<td><?php echo date('d-m-Y', strtotime($closing->start)) ?></td>
		<td><?php echo date('d-m-Y', strtotime($closing->end)) ?></td>
		<td><?php echo ucfirst($closing->frequency) ?></td>
		<td>
			<div class="pull-right">
			<button class="btn btn-large btn-default edit-closing" autocomplete="off" data-toggle="tooltip" aria-pressed="false" data-id="<?php echo $closing->closing_id ?>" data-loading-text="<?php _e("Patientez", $app->slug) ?> ...">
				<span class="glyphicon glyphicon-edit" aria-hidden="true" title="<?php echo __('Modifier', $app->slug); ?>"></span>
			</button>
			<button class="btn btn-large btn-danger delete-closing" autocomplete="off" data-toggle="modal" aria-pressed="false" data-id="<?php echo $closing->closing_id ?>" data-target="#confirmDelete">
				<span class="glyphicon glyphicon-remove" aria-hidden="true" title="<?php echo __('Supprimer', $app->slug); ?>"></span>
			</button>
		</div>
		</td>
	</tr>
	<?php
	}
	?>
</table>
<?php
}
?>
<input type="hidden" id="closing_id" name="closing_id" value="">
</div>