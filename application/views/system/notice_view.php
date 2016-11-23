	<h1>이용안내 보기</h1>
	<div id="body">
		<span id="button_bar"><?php echo anchor('system/notice_edit/'. $notice->id, '편집', ''); ?> | 삭제 | 목록</span>
		<div id="notice_view">
			<div class="notice_title"><?php echo $notice->title; ?></div>
			<div class="bbs_title odd_row">
				<span class="bbs_header">게시자</span>
				<span class="bbs_content"><?php echo $notice->writer; ?></span>
			</div><!--/div.bbs_title-->
			<div class="bbs_title even_row">
				<span class="bbs_header">작성일</span>
				<span class="bbs_content"><?php echo $notice->create_datetime; ?></span>
			</div><!--/div.bbs_title-->
			<div class="bbs_title odd_row">
				<span class="bbs_header">제목</span>
				<span class="bbs_content"><?php echo $notice->title; ?></span>
			</div><!--/div.bbs_title-->
			<div class="bbs_title even_row">
				<span class="bbs_header">첨부파일</span>
				<span class="bbs_content"><?php
				if ( $notice->attach1_name ) {
					echo anchor('system/notice_file/' . $notice->id . '/' . $notice->attach1_name, $notice->attach1_name, '');
				}
				if ( $notice->attach2_name ) {
					echo anchor('system/notice_file/' . $notice->id . '/' . $notice->attach2_name, $notice->attach2_name, '');
				}
				if ( $notice->attach3_name ) {
					echo anchor('system/notice_file/' . $notice->id . '/' . $notice->attach3_name, $notice->attach3_name, '');
				}
				?></span>
			</div><!--/div.bbs_title-->
			<div class="bbs_content"><?php echo $notice->content; ?>
			</div><!--/div.bbs_content-->
		</div><!--/div#notice_view-->
		<img src="" />
	</div><!--/div#body-->
