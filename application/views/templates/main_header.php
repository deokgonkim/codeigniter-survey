<!DOCTYPE html>
<html>
<head>
	<title><?php echo $system_name; ?> (<?php echo $system_version; ?>)</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<style type="text/css">
		#container{
			margin: 10px;
			border: 1px solid #D0D0D0;
			-webkit-box-shadow: 0 0 8px #D0D0D0;
		}
		#body {
			margin: 0 15px 0 15px;
		}
		h1 {
			color: #444;
			background-color: transparent;
			border-bottom: 1px solid #D0D0D0;
			font-size: 19px;
			font-weight: normal;
			margin: 0 0 14px 0;
			padding: 14px 15px 10px 15px;
		}
		p.footer{
			text-align: right;
			font-size: 11px;
			border-top: 1px solid #D0D0D0;
			line-height: 32px;
			padding: 0 10px 0 10px;
			margin: 20px 0 0 0;
		}
	</style>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
</head>
<body>
<h1><?php echo $system_name; ?></h1>
<?php if ( $logged_in ) { ?>
<p><?php echo $name; ?>님 환영합니다. <?php echo anchor('login/logout', '로그아웃', ''); ?></p>
<?php } else { ?>
<p><?php echo anchor('login/', '로그인', ''); ?></p>
<?php } ?>
<div id="menubar">
	<ul>
		<?php foreach ($main_menus as $menu_key => $menu_name): ?><li>
			<?php echo anchor($menu_key, $menu_name, '') ?>
		</li><?php endforeach ?>
	</ul>
</div>
<div id="container">
	<div id="left_pane">
		<ul>
			<?php foreach ($sub_menus as $menu_key => $menu_name): ?><li>
				<?php echo anchor($menu_key, $menu_name, '') ?>
			</li><?php endforeach ?>
		</ul>
	</div><!--/div#left_pane-->
