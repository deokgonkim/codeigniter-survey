	<ul>
		<li>버전 : <?php echo $version ?></li>
		<li>시스템명 : <?php echo $system_name ?></li>
	</ul>
	<hr />
	<ul>
		<li><?php echo anchor('setup/install', 'DB설치', 'class=""') ?></li>
		<li><?php echo anchor('setup/uninstall', 'DB제거', 'class="strong double-check"') ?></li>
	</ul>
	<script language="javascript" type="text/javascript">
	$(".double-check").click(function(e) {
		if ( prompt('진행하시려면 \'YES\'를 입력하십시오.') == 'YES' ) {
			return true;
		} else {
			return false;
		}
	});
	</script>
