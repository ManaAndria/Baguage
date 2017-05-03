<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( isset($_POST['action']) && $_POST['action'] == appBook()->slug.'_edit_closing' && isset($_POST['data']) )
{
	$closing_id = (int)$_POST['data'];
	$current = appBook()->app->closing->getSingle($closing_id);
	$form_action = 'closing_edit';
}
else
	$form_action = 'closing_new';
$app = appBook();
$frequencies = $app->app->closing->getFrequency();
?>
<div class="page-header row">
	<h2>
		<?php if (isset($current))
			echo __('Modifier une fermeture', $app->slug);
		else
			echo __('Ajouter une nouvelle fermeture', $app->slug);
		?>
	</h2>
</div>
<form id="<?php echo $app->slug; ?>_app<?php echo '_'.$form_action?>"  class="<?php echo $app->slug; ?>_form form-horizontal col-xs-12 col-sm-8" method="POST" action="">
	<div class="form-group">
	    <label for="start" class="col-xs-12 col-sm-4 control-label"><?php echo __('Date de début', $app->slug) ?> *</label>
	    <div class="col-xs-12 col-sm-8">
	    	<input type="text" class="form-control date" id="start" name="<?php echo $form_action; ?>[start]" placeholder="<?php echo __('Début', $app->slug) ?>" value="<?php echo ( isset($current) ? date('d-m-Y', strtotime($current->start)) : '' ); ?>" required readonly />
	    </div>
  	</div>
  	<div class="form-group">
	    <label for="end" class="col-xs-12 col-sm-4 control-label"><?php echo __('Date de fin', $app->slug) ?> *</label>
	    <div class="col-xs-12 col-sm-8">
	    	<input type="text" class="form-control date" id="end" name="<?php echo $form_action; ?>[end]" placeholder="<?php echo __('Fin', $app->slug) ?>" value="<?php echo ( isset($current) ? date('d-m-Y', strtotime($current->end)) : '' ); ?>" required readonly />
	    </div>
  	</div>
  	<div class="form-group">
	    <label for="frequency" class="col-xs-12 col-sm-4 control-label"><?php echo __('Fréquence', $app->slug) ?> *</label>
	    <div class="col-xs-12 col-sm-8">
	    	<select class="form-control" id="frequency" name="<?php echo $form_action; ?>[frequency]">
	    		<?php
	    		foreach ($frequencies as $key => $frequency) { ?>
	    			<option value="<?php echo $key; ?>"<?php echo ( (isset($current) && $frequency == $current->frequency) ? ' selected' : '' ) ?>><?php echo ucfirst(__($frequency, $app->slug)) ?></option>
	    		<?php	
	    		}
	    		?>
	    	</select>
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
		<input type="hidden" name="<?php echo $form_action ?>[closing_id]" value="<?php echo $closing_id; ?>" >
	<?php } ?>
	<?php wp_nonce_field( $form_action, $app->slug.'_'.$form_action ) ?>
</form>
<script type="text/javascript">
jQuery(function(){
	jQuery('#start').datepicker({
		dateFormat: 'dd-mm-yy',
		changeYear: true,
		changeMonth: true,
		onClose: function(value){
			jQuery('#end').datepicker('option', 'minDate', value);
		}
	});
	jQuery('#end').datepicker({
		dateFormat: 'dd-mm-yy',
		changeYear: true,
		changeMonth: true,
		onClose: function(value){
			jQuery('#start').datepicker('option', 'maxDate',value);
		}
	});
});
</script>