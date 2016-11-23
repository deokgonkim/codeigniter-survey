	<h1>로그인 화면</h1>
	<div id="body">
	<?php echo validation_errors(); ?>
	<?php //echo form_open('login/login_check'); ?>
	<?php echo form_open('login'); ?>
	<label for="login_name">Username:</label>
	<input type="text" size="20" id="login_name" name="login_name"/>
	<br/>
	<label for="password">Password:</label>
	<input type="password" size="20" id="passowrd" name="password"/>
	<br/>
	<input type="submit" value="Login"/>
	</form>
	<?php if ( $register ) echo anchor($register_link, '회원가입', ''); ?> | <?php echo anchor($recovery_link, '아이디/비밀번호 찾기', ''); ?>
	</div><!--/div#body -->
