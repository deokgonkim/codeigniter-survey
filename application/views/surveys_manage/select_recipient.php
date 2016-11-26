	<script type="text/javascript" src="<?php echo base_url() . 'js/select_recipient_form.js'; ?>"></script>
	<h2>대상자 선택</h2>
	<?php echo validation_errors(); ?>
	<div id="select_preset">
		<dl>
			<dt>조사 대상자 표시</dt>
			<dd><?php echo form_input('recipient_name', '', 'placeholder="조사 대상자"'); ?> (총 <?php echo form_input('recipient_count', '', 'placeholder="00"'); ?>명 )</dd>
			<dt>선택</dt>
			<dd><?php echo form_dropdown('recipients', $preset, ''); ?></dd>
		</dl>
	</div>
	<div id="search_criteria">
		<dl>
			<dt>검색 조건</dt>
			<dd><?php echo form_dropdown('search_criteria', $criteria, ''); ?></dd>
			<dd><input name="key" /></dd>
		</dl>
		<button name="add_criteria">조건 추가</button>
		<button name="search">검색</button>
	</div>
	<div id="result_container">
		<div id="results">
			<table id="grid_results"></table>
			<div id="pager_results"></div>
		</div>
		<div id="buttons">
			<button>&gt;</button><br />
			<button>&lt;</button>
		</div>
		<div id="buttons2">
			<button>&gt;</button><br />
			<button>&lt;</button>
		</div>
		<div id="gselected">
			<table id="selected_grid"></table>
			<div id="selected_pager"></div>
		</div>
<br style="clear: left;" />
	</div>

	<script type="text/javascript">
	var survey_id = '<?php //echo $survey->id; ?>';
	var url_item_save = '<?php //echo site_url('surveys_manage/save_item'); ?>';
	var url_get_items = '<?php //echo site_url('surveys_manage/get_items'); ?>';
	$(function() {
		// hide template
		$('#question_template').css('display', 'none');
		// create first item.
		window.search_frm = new Search_form();
		search_frm.set_form($('#search_criteria'));

var mydata = [
{ id : "one", "name" : "row one" },
{ id : "two", "name" : "row two" },
{ id : "three", "name" : "row three" }
];

$("#grid_results").jqGrid({ //set your grid id
multiselect: true,
data: mydata, //insert data from the data object we created above
datatype: 'local',
width: '100%', //specify width; optional
colNames:['Id','Name'], //define column names
colModel:[
{name:'id', index:'id', key: true, width:50},
{name:'name', index:'name', width:100}
], //define column models
pager: '#pager_results', //set your pager div id
sortname: 'id', //the column according to which data is to be sorted; optional
viewrecords: true, //if true, displays the total number of records, etc. as: "View X to Y out of Z” optional
sortorder: "asc", //sort order; optional
caption:"jqGrid Example" //title of grid
});
		
$("#selected_grid").jqGrid({ //set your grid id
multiselect: true,
datatype: 'javascript',
//width: '100%', //specify width; optional
colNames:['Id','Name'], //define column names
colModel:[
{name:'id', index:'id', key: true, width:50},
{name:'name', index:'name', width:100}
], //define column models
pager: '#pager_selected', //set your pager div id
sortname: 'id', //the column according to which data is to be sorted; optional
viewrecords: true, //if true, displays the total number of records, etc. as: "View X to Y out of Z” optional
sortorder: "asc", //sort order; optional
caption:"jqGrid Example" //title of grid
});
		$('#add_button').click(function(e) {
			window.frm.add_item();
		});
		$('input[name=submit]').click(function(e) {
			window.frm.submit();
		});

	});
	</script>
	<style type="text/css">
	div#result_container {
		padding: 2px 2px 2px 2px;
		width: 1000px;
	}
	div#results {
		border: #f00 solid 1px;
		display: inline-block;
		float: left;
		width: 40%;
		height: 300px;
	}
	div#buttons {
		border: #0f0 solid 1px;
		display: inline-block;
		float: left;
		width: 5%;
		height: 320px;
	}
	div#buttons2 {
		border: #0ff solid 1px;
		display: inline-block;
		float: left;
		width: 5%;
		height: 320px;
	}
	div#gselected {
		border: #00f solid 1px;
		display: inline-block;
		float; left;
		width: 40%;
		height: 250px;
	}
	</style>
