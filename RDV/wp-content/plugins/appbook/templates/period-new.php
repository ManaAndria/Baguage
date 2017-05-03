<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$app = appBook();
if ( isset($_POST['action']) && $_POST['action'] == appBook()->slug.'_edit_period' && isset($_POST['data']) )
{
	$period_id = (int)$_POST['data'];
	$current = appBook()->app->period->getSingle($period_id);
	$employee_id = $current->employee_id;
	$period = explode(':', $current->period);
	$form_action = 'period_edit';
}
else
	$form_action = 'period_new';

?>
<div class="page-header row">
	<h2>
		<?php if (isset($current))
			echo __('Modifier une période', $app->slug);
		else
			echo __('Ajouter une nouvelle période', $app->slug);
		?>
	</h2>
</div>
<form id="<?php echo $app->slug; ?>_app<?php echo '_'.$form_action?>"  class="<?php echo $app->slug; ?>_form form-horizontal col-xs-12 col-sm-8" method="POST" action="">
	<div class="form-group col-xs-12">
	    <label for="hour" class="control-label col-xs-6 col-sm-4"><?php echo __('Heure', $app->slug) ?> *</label>
    	<div class="col-xs-6 col-sm- col-sm-2">
    		<input type="number" class="form-control" step="1" id="hour" min="0" max="23" name="<?php echo $form_action; ?>[hour]" value="<?php echo ( isset($current) ? $period[0] : '' ) ?>" required />
		</div>
  	</div>
  	<div class="form-group col-xs-12">
	    <label for="minute" class="control-label col-xs-6 col-sm-4"><?php echo __('Minute', $app->slug) ?> *</label>
    	<div class="col-xs-6 col-sm-2">
    		<input type="number" class="form-control" id="minute" step="1" min="0" max="59" name="<?php echo $form_action; ?>[minute]" value="<?php echo ( isset($current) ? $period[1] : '' ) ?>" required />
		</div>
  	</div>
  	<div class="clearfix"></div><hr />
  	<div class="control-group col-xs-12">
		<div class="col-xs-12 col-sm-offset-2 col-sm-8" style="padding-left: 0px;">
			<button type="button" onclick="javascript: location.assign(location.href);" class="btn btn btn-default"><?php echo __('Annuler', $app->slug); ?></button>
			<input class="btn btn btn-primary" name="<?php echo $app->slug; ?>_app" type="submit" value="<?php echo ( isset($current) ? __('Sauvegarder', $app->slug) : __('Ajouter', $app->slug) ) ?>">
		</div>
	</div>
	<?php 
	if ( isset($current) )
	{
	?>
		<input type="hidden" name="<?php echo $form_action ?>[period_id]" value="<?php echo $period_id; ?>" >
		<input type="hidden" name="<?php echo $form_action ?>[employee_id]" value="<?php echo $employee_id; ?>" >
	<?php
	}
	else
	{
	?>
		<input type="hidden" name="<?php echo $form_action ?>[employee_id]" value="<?php echo $_POST['data']; ?>" >
	<?php
	}
	?>
	<?php wp_nonce_field( $form_action, $app->slug.'_'.$form_action ) ?>
</form>