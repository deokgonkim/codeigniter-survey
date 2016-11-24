	<h2>설문조사 작성</h2>
	<?php echo validation_errors(); ?>
	<?php echo form_open('surveys_manage/create') ?>
	<label for="title">설문조사 제목</label>
	<?php echo form_input('title', set_value('title')); ?><br />

	<label for="surveyor_name">설문기관</label>
	<?php echo form_input('surveyor_name', set_value('surveyor_name')); ?><br />

	<label for="surveyor_mail">설문기관 메일</label>
	<?php echo form_input('surveyor_mail', set_value('surveyor_mail')); ?><br />

	<label for="surveyor_phone">설문기관 연락처</label>
	<?php echo form_input('surveyor_phone', set_value('surveyor_phone')); ?><br />

	<label for="notbefore">설문조사 시작</label>
	<?php echo form_input('notbefore', set_value('notbefore')); ?><br />

	<label for="notafter">설문조사 종료</label>
	<?php echo form_input('notafter', set_value('notafter')); ?><br />

	<label for="content">설문조사 안내문</label>
	<?php echo form_textarea('content', set_value('content')); ?><br />

	<input type="submit" name="submit" value="설문조사 작성" />

	</form>

