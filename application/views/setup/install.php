	<?php echo validation_errors(); ?>
	<ul>
	<?php foreach ($tables as $table_item): ?>
		<li><?php echo $table_item['name'] ?> : <strong><?php echo $table_item['status'] ?></strong></li>
	<?php endforeach ?>
	</ul>
