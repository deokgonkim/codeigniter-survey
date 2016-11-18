	<?php echo validation_errors(); ?>
	<?php echo form_open('login/login_check'); ?>
	<label for="login_name">Username:</label>
	<input type="text" size="20" id="login_name" name="login_name"/>
	<br/>
	<label for="password">Password:</label>
	<input type="password" size="20" id="passowrd" name="password"/>
	<br/>
	<input type="submit" value="Login"/>
	</form>
