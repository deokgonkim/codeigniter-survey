	<h1>login/info</h1>
	<div id="body">
	<style type="text/css">
	.code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	</style>
	<ul>
	<li><strong>userdata('uid')</strong> : <?php echo $uid; ?></li>
	<li><strong>userdata('login')</strong> : <?php echo $login; ?></li>
	<li><strong>userdata('grp_ids')</strong> : <?php echo $grp_ids; ?></li>
	<li><strong>userdata('admin')</strong> : <?php echo $can_admin; ?></li>
	<li><strong>userdata('modify')</strong> : <?php echo $can_modify; ?></li>
	<li><strong>userdata('create')</strong> : <?php echo $can_create; ?></li>
	</ul>
	<hr />
	<strong>all_userdata</strong><pre class="code"><?php echo $all_userdata; ?></pre>
	</div><!--/div#id -->
