	<h1>시작하기</h1>
	<div id="body">
		<img src="" />
		<div id="left_column">
			<label>이용안내</label>
			<table class="list">
			<tr>
				<th>제목</th>
				<th>게시일</th>
			<tr>
			<?php foreach ($notices as $notice_item): ?><tr>
				<td><?php echo anchor('system/notice/view/'.$notice_item->id, $notice_item->title, '') ?></td>
				<td><?php echo $notice_item->create_datetime; ?>
			<?php endforeach ?></tr>
			</ul>
			</table>
		</div>
		<div id="center_column">
			<label>받은 설문지</label>
			<table class="list">
			<tr>
				<th>제목</th>
				<th>기간</th>
			</tr>
			<?php foreach ($surveys_received as $survey_item): ?><tr>
				<td><?php echo anchor('surveys/view/'.$survey_item->id, $survey_item->title, '') ?></td>
				<td><?php echo $survey_item->notbefore . '~' . $survey_item->notafter ?></td>
			</tr>
			<?php endforeach ?></table>
		</div>
		<div id="right_column">
			<label>지난 설문지</label>
			<ul>
		        <?php foreach ($surveys_archived as $survey_item): ?>
				<li><?php echo anchor('surveys/view/'.$survey_item->id, $survey_item->title, '') ?></li>
			<?php endforeach ?>
			</ul>
		</div>
	</div>
