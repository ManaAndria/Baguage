<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( isset($_POST['action']) && $_POST['action'] == appBook()->slug.'_edit_service' && isset($_POST['data']) )
{
	$service_id = (int)$_POST['data'];
	$current = appBook()->app->service->getSingle($service_id);
	$form_action = 'service_edit';
}
else
	$form_action = 'service_new';
$app = appBook();
?>
<div class="page-header row">
	<h2>
		<?php if (isset($current))
			echo __('Modifier un service', $app->slug);
		else
			echo __('Ajouter un nouveau service', $app->slug);
		?>
	</h2>
</div>
<form id="<?php echo $app->slug; ?>_app<?php echo '_'.$form_action?>"  class="<?php echo $app->slug; ?>_form form-horizontal col-xs-12 col-sm-8" method="POST" action="">
	<div class="form-group">
	    <label for="service_name" class="col-xs-12 col-sm-4 control-label"><?php echo __('Nom du service', $app->slug) ?> *</label>
	    <div class="col-xs-12 col-sm-8">
	    	<input type="text" class="form-control" id="service_name" name="<?php echo $form_action; ?>[service_name]" placeholder="<?php echo __('Nom du service', $app->slug) ?>" value="<?php echo ( isset($current) ? stripslashes($current->service_name) : '' ); ?>" required />
	    </div>
  	</div>
  	<div class="clearfix"></div><hr />
  	<div class="control-group">
		<div class="col-xs-12 col-sm-offset-4 col-sm-8">
			<button type="button" onclick="javascript: location.assign(location.href);" class="btn btn-default"><?php echo __('Annuler', $app->slug); ?></button>
			<input class="btn btn-primary" name="<?php echo $app->slug; ?>_app" type="submit" value="<?php echo  ( isset($current) ? __('Sauvegarder', $app->slug) : __('Ajouter', $app->slug) ) ?>">
		</div>
	</div>
	<?php 
	if ( isset($current) )
	{
	?>
		<input type="hidden" name="<?php echo $form_action ?>[service_id]" value="<?php echo $service_id; ?>" >
	<?php } ?>
	<?php wp_nonce_field( $form_action, $app->slug.'_'.$form_action ) ?>
</form>