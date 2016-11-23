<?php echo $error;?>
<?php echo form_open_multipart('test/upload');?>
<input type="text" name="title" />
<input type="file" name="userfile" size="20" />

<br /><br />

<input type="submit" value="upload" />

</form>
<div id="title" />

<script type="text/javascript">
$(function() {
	$('#upload_file').submit(function(e) {
		e.preventDefault();
		$.ajaxFileUpload({
			url 			: 'upload',
			secureuri		:false,
			fileElementId	:'userfile',
			dataType		: 'json',
			data			: {
				'title'				: $('#title').val()
			},
			success	: function (data, status) {
				if(data.status != 'error') {
					$('#files').html('<p>Reloading files...</p>');
					refresh_files();
					$('#title').val('');
				}
				aert(data.msg);
			}
		});
	return false;
	});
});
</script>
