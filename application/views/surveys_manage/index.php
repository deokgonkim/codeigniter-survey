	<h1>설문조사 목록</h1>
	<table class="list">
	<tr>
		<th>번호</th>
		<th>제목</th>
		<th>게시자</th>
		<th>기간</th>
	</tr>
	<?php foreach ($surveys as $survey_item): ?><tr>
		<td><?php echo $survey_item->id; ?></td>
		<td><?php echo anchor('surveys/view/'.$survey_item->id, $survey_item->title, ''); ?></td>
		<td><?php echo $survey_item->creator_name; ?></td>
		<td><?php echo mdate('%Y/%m/%d', strtotime($survey_item->notbefore)) . ' ~ ' . mdate('%Y/%m/%d', strtotime($survey_item->notafter)); ?></td>
	</tr><?php endforeach ?>
	</table>

