	<h2>설문조사 작성</h2>
	<?php echo validation_errors(); ?>
	<?php echo form_open('surveys_manage/create') ?>
	<label for="title">설문조사 제목</label>
	<input type="text" name="title" /><br />

	<label for="surveyor_name">설문기관</label>
	<input type="text" name="surveyor_name" /><br />

	<label for="surveyor_mail">설문기관 메일</label>
	<input type="text" name="surveyor_mail" /><br />

	<label for="surveyor_phone">설문기관 연락처</label>
	<input type="text" name="surveyor_phone" /><br />

	<label for="notbefore">설문조사 시작</label>
	<input type="text" name="notbefore" /><br />

	<label for="notafter">설문조사 종료</label>
	<input type="text" name="notafter" /><br />

	<label for="content">설문조사 안내문</label>
	<textarea name="content"></textarea><br />

	<input type="submit" name="submit" value="설문조사 작성" />

	</form>

