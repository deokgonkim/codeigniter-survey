	<h1>이용안내 수정</h1>
	<div id="body">
		<?php echo form_open_multipart('system/notice_edit/' . $notice->id); ?>
		<span id="button_bar"><?php echo form_submit('submit', '완료'); ?> | 삭제 | 목록</span>
		<div id="notice_view">
			<div class="bbs_title odd_row">
				<span class="bbs_header">게시자</span>
				<span class="bbs_content"><?php echo form_input('writer', $notice->writer); ?></span>
			</div><!--/div.bbs_title-->
			<div class="bbs_title even_row">
				<span class="bbs_header">작성일</span>
				<span class="bbs_content"><?php echo $notice->create_datetime; ?></span>
			</div><!--/div.bbs_title-->
			<div class="bbs_title odd_row">
				<span class="bbs_header">제목</span>
				<span class="bbs_content"><?php echo form_input('title', $notice->title); ?></span>
			</div><!--/div.bbs_title-->
			<div class="bbs_title even_row">
				<span class="bbs_header">첨부파일</span>
				<span class="bbs_content"><?php echo form_upload('userfile1'); ?><?php echo form_upload('userfile2'); ?><?php echo form_upload('userfile3'); ?></span>
			</div><!--/div.bbs_title-->
			<div class="bbs_body">
				<?php echo form_textarea('content', $notice->content); ?>
			</div><!--/div.bbs_body-->
		</div><!--/div#notice_view-->
		</form>
	</div><!--/div#body-->
