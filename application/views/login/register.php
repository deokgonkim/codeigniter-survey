	<h1>회원 가입</h1>
	<div id="body">
	<?php echo validation_errors(); ?>
	<?php //echo form_open('login/login_check'); ?>
	<?php echo form_open('login/register'); ?>
	<label for="login_name">로그인:</label>
	<input type="text" size="20" id="login_name" name="login_name"/>
	<br/>
	<label for="password">비밀번호:</label>
	<input type="password" size="20" id="passowrd" name="password"/>
	<br/>
	<label for="name">이름:</label>
	<input type="text" size="20" id="name" name="name"/>
	<br/>
	<label for="mail">이메일:</label>
	<input type="text" size="20" id="mail" name="mail"/>
	<br/>
	<input type="submit" value="회원 가입"/>
	</form>
	</div><!--/div#body -->
