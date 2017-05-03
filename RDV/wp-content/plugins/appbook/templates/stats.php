<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$app = appBook();
$services = $app->app->service->datas;
?>
<div id="stats">
<form id="stats-form" name="stats-form" class="form-inline" method="post" action=""> 
	<div class="form-group">
		<span><?php echo __('Date de début', $app->slug); ?></span>
		<div class="input-group">
			<input type="text" class="form-control date" id="start" name="start" value="<?php echo date('d-m-Y', strtotime('-1 month')); ?>" required readonly />
			<label for="start" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
		</div>
	</div>
	<div class="form-group">
		<span><?php echo __('Date de fin', $app->slug); ?></span>
		<div class="input-group">
			<input type="text" class="form-control date" id="end" name="end" value="<?php echo date('d-m-Y', strtotime('+1 month')); ?>" required readonly />
			<label for="end" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
		</div>
	</div>
	<div class="form-group">
		<label><?php echo __('Services', $app->slug); ?></label>
		<select id="services" class="form-control" name="services" multiple="multiple">
			<?php foreach ($services as $service) { ?>
				<option value="<?php echo $service->service_id ?>" selected><?php echo $service->service_name; ?></option>
			<?php	
			}
			?>
		</select>
	</div>
	<div class="form-group pull-right">
		<input class="btn btn-primary" name="<?php echo $app->slug; ?>_app" type="submit" value="<?php echo  __('Valider', $app->slug) ?>" />
	</div>
</form>
<div class="clearfix"></div>
<hr />
<div class="clearfix"></div>
<canvas id="canvas-stats" width="400" height="400"></canvas>
</div>