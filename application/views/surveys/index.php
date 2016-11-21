	<?php foreach ($surveys as $survey_item): ?>
    	<h2><?php echo $survey_item['title'] ?></h2>
	<div class="main">
        	<?php echo $survey_item['title'] ?>
	</div>
	<p><?php echo anchor('surveys/view/'.$survey_item['id'], 'View survey', '') ?></p>
	<?php endforeach ?>

