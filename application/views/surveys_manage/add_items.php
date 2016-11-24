	<script type="text/javascript" src="<?php echo base_url() . 'js/survey_form.js'; ?>"></script>
	<h2>설문조사 문항 작성</h2>
	<?php echo validation_errors(); ?>
	<dl>
		<dt>설문조사 제목</dt>
		<dd><?php echo $survey->title; ?></dd>
		<dt>설문기관</dt>
		<dd><?php echo $survey->surveyor_name; ?></dd>
		<dt>설문기관 메일</dt>
		<dd><?php echo $survey->surveyor_mail; ?></dd>
		<dt>설문기관 연락처</dt>
		<dd><?php echo $survey->surveyor_phone; ?></dd>
		<dt>설문조사 시작</dt>
		<dd><?php echo mdate('%Y/%m/%d', strtotime($survey->notbefore)); ?></dd>
		<dt>설문조사 종료</dt>
		<dd><?php echo mdate('%Y/%m/%d', strtotime($survey->notafter)); ?></dd>
		<dt>설문조사 안내문</dt>
		<dd><?php echo $survey->content; ?></dd>
	</dl>
	<div id="items">
		<div id="question_template" style="display: block;">
			<button>문항 저장</button>
			<label for="question">설문 n</label>
			<input type="text" name="item_question" /><!-- 제목 -->
			<select name="item_class">
				<option>--문항 유형 선택--</option>
				<option value="10">다항선택형</option>
				<option value="20">서열형</option>
				<option value="30">개방형</option>
			</select>
			<br />
		</div>
		<div>
			<div class="class_10">
				<ol>
					<li><input type="radio"><input type="text" name="ans" value="응답1" /></li>
				</ol>
				<button>항목 추가</button>
			</div>
			<div class="class_20">
				<ul>
					<li><input type="checkbox"><input type="text" name="ans" value="응답1" /></li>
				</ul>
				<button>항목 추가</button>
				<input type="number" name="selectable" />
			</div>
			<div class="class_30">
				<input type="text" value="[응답란]" readonly=readonly />
			</div>
		</div>
		<div id="answer_type1_template" style="display: block;">
			<label for="question">응답 n</label>
			<input type="text" name="" />
		</div>
	</div>
	<button id="add_button">
		+
	</button>
	<input type="submit" name="submit" value="설문조사 작성" />

	</form>
	<script type="text/javascript">
	var survey_id = '<?php echo $survey->id; ?>';
	var url_item_save = '<?php echo site_url('surveys_manage/save_item'); ?>';
	$(function() {
		// hide template
		$('#question_template').css('display', 'none');
		// create first item.
		window.frm = new Survey_form(survey_id);
		frm.set_url_save_item(url_item_save);
		frm.set_form($('#items'));
		frm.set_template($('#question_template'));
		frm.set_class10template($('[class=class_10]'));
		frm.set_class20template($('[class=class_20]'));
		frm.set_class30template($('[class=class_30]'));
		frm.add_item();

		$('#add_button').click(function(e) {
			window.frm.add_item();
		});
		$('input[name=submit]').click(function(e) {
			window.frm.submit();
		});

	});
	</script>
