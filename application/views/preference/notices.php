	<h1>이용안내</h1>
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
				<td><?php echo anchor('preference/notice_view/'.$notice_item->id, $notice_item->title, '') ?></td>
				<td><?php echo $notice_item->create_datetime; ?>
			<?php endforeach ?></tr>
			</ul>
			</table>
		</div>
	</div><!--/div#body-->
