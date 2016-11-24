/**
 * 화면과 연결된 Survey_form을 생성한다.
 *
 * ex.
 * var frm = new Survey_form(survey_id);
 * or
 * windows.frm = new Survey_form(survey_id)
 */
function Survey_form(survey_id) {
	this.survey_id = survey_id;
	this.form = null;
	this.template = null;
	this.class10template = null;
	this.class20template = null;
	this.class30template = null;
	this.questions = [];
}

/**
 * 화면에 표시되는 엘리면트를 jQuery로 잡아 넣는다.
 *
 * ex.
 * frm.set_form($('#item_form'));
 */
Survey_form.prototype.set_form = function(items_form) {
	this.form = items_form;
}

/**
 * 화면에 표시된 답변 항목 템플릿을 지정한다.
 * 지정한 템플릿은 내부적으로 숨김 처리한다.
 * 사용할 때는, Surveyform.prototype.add_item을 통해서 template를 추가하는 형태로 사용한다.
 *
 * ex.
 * frm.set_template($('#item_template'));
 *
 * 문항 템플릿
 * <div id="question_template">
 *     <button>문항 저장</button>
 *     <label for="question">설문 n</label>
 *     <input type="text" name="question" />
 *     <select name="item_class">
 *         <option>--문항 유형 선택--</option>
 *         <option value="10">다항선택형</option>
 *         <option value="20">서열형</option>
 *         <option value="30">개방형</option>
 *     </select>
 * </div>
 */
Survey_form.prototype.set_template = function(template) {
	this.template = template;
	this.template.css('display', 'none');
	var frmObj = this;
	this.template.find('button').click(function(e) {
		var question = $(this).parents('[id^=question]');
		frmObj._save_item(question);
	});
}

/**
 * 다항선택식 문항에 대한 HTML 템플릿을 지정한다.
 *
 * 답변 템플릿
 * <div class="class_10">
 *     <ol>
 *         <li><input type="radio" /><input type="text" name="ans" value="응답1" /></li>
 *     </ol>
 *     <button>항목추가</button>
 * </div>
 * 
 */
Survey_form.prototype.set_class10template = function(template) {
	this.class10template = template;
	this.class10template.css('display', 'none');
	this.class10template.find('button').click(function(e) {
		var question = $(this).parents('[id^=question]');
		var ansItem = question.find('li').first().clone();
		ansItem.children('input[type=text]').val('');
		question.find('ol').append(ansItem);
	});
}

/**
 * 서열형 문항에 대한 HTML 템플릿을 지정한다.
 *
 * 답변 템플릿
 * <div class="class_10">
 *     <ul>
 *         <li><input type="checkbox" /><input type="text" name="ans" value="응답1" /></li>
 *     </ul>
 *     <button>항목추가</button>
 * </div>
 */
Survey_form.prototype.set_class20template = function(template) {
	this.class20template = template;
	this.class20template.css('display', 'none');
	this.class20template.find('button').click(function(e) {
		var question = $(this).parents('[id^=question]');
		var ansItem = question.find('li').first().clone();
		ansItem.val('');
		question.find('ul').append(ansItem);
	});
}

/**
 * 개방형 문항에 대한 HTML 템플릿을 지정한다.
 */
Survey_form.prototype.set_class30template = function(template) {
	this.class30template = template;
	this.class30template.css('display', 'none');
}

/**
 * 설문 조사 문항 추가시 사용한다.
 *
 * ex.
 * var frm = new Survey_form(survey_id);
 * frm.add_item();
 */
Survey_form.prototype.add_item = function() {
	var item_id = this.questions.length + 1;
	var new_item = this.template.clone(true, true);
	var frmObj = this;
	new_item.attr('id', 'question' + item_id);
	new_item.css('display', 'block');
	new_item.children('label').text('설문 ' + item_id);
	new_item.children('input').attr('name', 'title');
	new_item.children('div[class^=class_]').css('display', 'none');
	new_item.children('select[name=item_class]').change(function() {
		var item = $(this).parent('[id^=question]');
		//TODO html에 data-class 속성을 넣는 것이 문제 없을까? html5에서 사용하는 기능인데..
		item.attr('data-class', this.value);
		if ( this.value == '10' ) {
			var frm = $(this).parent();
			var existing = frm.children('#answer' + item_id).length;
			if ( existing == 0 ) {
				var newAns = frmObj.class10template.clone(true, true);
				newAns.attr('id', 'answer' + item_id);
				frm.append(newAns);
			} else {
			}
			$(this).parent().children('div.class_10').css('display', 'block');
			$(this).parent().children('div.class_20').css('display', 'none');
			$(this).parent().children('div.class_30').css('display', 'none');
			console.log($(this));
		} else if ( this.value == '20' ) {
			var frm = $(this).parent();
			var existing = frm.children('#answer' + item_id).length;
			if ( existing == 0 ) {
				var newAns = frmObj.class20template.clone(true, true);
				newAns.attr('id', 'answer' + item_id);
				frm.append(newAns);
			} else {
			}
			$(this).parent().children('div.class_10').css('display', 'none');
			$(this).parent().children('div.class_20').css('display', 'block');
			$(this).parent().children('div.class_30').css('display', 'none');
			console.log($(this));
		} else if ( this.value == '30' ) {
			$(this).parent().children('div.class_10').css('display', 'none');
			$(this).parent().children('div.class_20').css('display', 'none');
			$(this).parent().children('div.class_30').css('display', 'block');
			console.log($(this));
		} else {
			$(this).parent().children('div.class_10').css('display', 'none');
			$(this).parent().children('div.class_20').css('display', 'none');
			$(this).parent().children('div.class_30').css('display', 'none');
			console.log($(this));
		}
	});
	// input 항목에 blur 사용하면, 답변 항목들을 처리할 수 없다.
	//new_item.children('input[name^=item]').blur(this._save_item);

	this.questions.push(new_item);
	this.form.append(new_item);
}

Survey_form.prototype.submit = function() {
	console.log(this);
	console.log(this.questions);
	this.questions.forEach(function(val, index, ar) {
		var question_title = val.find('input[name=title]').val();
		var answers = [];
		val.find('li input[type=text]').each(function(index, obj) {
			answers.push($(obj).val());
		});
		
		console.log('question : ' + question_title);
		console.log('found? ' + answers);
		console.log(answers);
		console.log(val.val());
	});
}

/**
 * 선택된 항목을 서버에 저장한다.
 */
Survey_form.prototype._save_item = function(question) {
	var question_id = question.attr('id');
	var question_title = question.children('input[name=title]').val();
	var answers = [];
	question.find('li input[type=text]').each(function(index, obj) {
		answers.push($(obj).val());
	});
	console.log('question id is ' + question_id);
	console.log('title ' + question_title);
	console.log('ans ' + answers);
}
