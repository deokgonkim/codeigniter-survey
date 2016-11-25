
/**
 * Survey_manage_form = {
 *     "survey_id": 'survey_id',
 *     "items": [
 *         // Survey_item
 *         {
 *             "item_id": 'item_id',
 *             "title": 'title',
 *             "class": 'class',
 *             "answers": [
 *                 {
 *                 	"val_id": 'val_id',
 *                 	"val_text": 'val_text'
 *                 },
 *                 {
 *                 	"val_id": 'val_id',
 *                 	"val_text": 'val_text'
 *                 }
 *             ]
 *         },
 *         // Survey_item
 *         {
 *             "item_id": 'item_id',
 *             "title": 'title',
 *             "class": 'class',
 *             "answers": [
 *                 {
 *                 	"val_id": 'val_id',
 *                 	"val_text": 'val_text'
 *                 },
 *                 {
 *                 	"val_id": 'val_id',
 *                 	"val_text": 'val_text'
 *                 }
 *             ]
 *         }
 *     ]
 * }
 */


/**
 * 화면과 연결된 Survey_manage_form을 생성한다.
 *
 * ex.
 * var frm = new Survey_manage_form(survey_id);
 * or
 * window.frm = new Survey_manage_form(survey_id)
 */
function Survey_manage_form(survey_id) {
	this.survey_id = survey_id;
	this.questions = [];
	this.url_save_item = null;
	this.url_get_items = null;

	// div#items
	this.dom_form = null;

	// div#question_template
	this.dom_template = null;

	// answer templates
	// div#class_10
	this.dom_class10template = null;
	// div#class_20
	this.dom_class20template = null;
	// div#class_30
	this.dom_class30template = null;
}

Survey_manage_form.prototype.set_url_save_item = function(url_save_item) {
	this.url_save_item = url_save_item;
}

Survey_manage_form.prototype.set_url_get_items = function(url_get_items) {
	this.url_get_items = url_get_items;
}

/**
 * 화면에 표시되는 엘리면트를 jQuery로 잡아 넣는다.
 *
 * ex.
 * frm.set_form($('#item_form'));
 */
Survey_manage_form.prototype.set_form = function(items_form) {
	this.dom_form = items_form;
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
Survey_manage_form.prototype.set_template = function(template) {
	this.dom_template = template;
	this.dom_template.css('display', 'none');
	var frmObj = this;
	// 문항 저장 버튼 이벤트
	this.dom_template.find('button').click(function(e) {
		var question = $(this).parents('[id^=question]');
		frmObj._save_item(question);
	});
	this.dom_template.children('select[name=item_class]').change(function(e) {
		var dom_item = $(this).parent('[id^=question]');
		var item_id = dom_item.attr('id').replace('question', '');
		console.log('item_id : ' + item_id);
		console.log('frmObj.answers : ' + frmObj.questions[item_id-1].answers);
		var question = frmObj.questions[item_id-1];
		var answers = question.answers;
		question.clazz = $(this).val();
		question.rendered = 'dirty';
		if ( question.clazz == '10' ) {
			question.clazz = '10';
			if ( answers.length == 0 ) {
				answers.push('');
			}
		} else if ( question.clazz == '20' ) {
			if ( answers.length == 0 ) {
				answers.push('aa');
			}
		} else {
		}
		frmObj.render();
	});
}

Survey_manage_form.prototype.new_item = function() {
	var item = new Survey_item();
	this.questions.push(item);
	this.render(this.dom_form);
}

/**
 * 다항선택식 문항에 대한 HTML 템플릿을 지정한다.
 *
 * 답변 템플릿
 * <div class="class_10">
 *     <ol>
 *         <li><input type="radio" name="ans" /><input type="text" name="ans" value="응답1" /><button>삭제</button></li>
 *     </ol>
 *     <button>항목추가</button>
 * </div>
 * 
 */
Survey_manage_form.prototype.set_class10template = function(template) {
	this.dom_class10template = template;
	this.dom_class10template.css('display', 'none');
	var frmObj = this;
	// 응답 항목 추가 버튼 액션
	this.dom_class10template.children('button').click(function(e) {
		var question = $(this).parents('[id^=question]');
		var item_id = question.attr('id').replace('question', '');
		frmObj.add_answer_for_item(item_id);
	});
	// 응답 항목 삭제 버튼 액션
	this.dom_class10template.find('li button').click(function(e) {
		var question = $(this).parents('[id^=question]');
		var item_id = question.attr('id').replace('question', '');
		var ans_idx = $(this).parent('li').attr('data-index');
		console.log('delete button');
		frmObj.remove_answer_for_item(item_id, ans_idx);
	});
	// 내용 수정시 자동 갱신
	//TODO blur 이벤트에 하는 것이 맞을까?
	this.dom_class10template.find('li input[type=text]').blur(function(e) {
		var question = $(this).parents('[id^=question]');
		var item_id = question.attr('id').replace('question', '');
		var ans_idx = $(this).parent('li').attr('data-index');
		frmObj.replace_answer_for_item(item_id, ans_idx, $(this).val());
	});
	this.dom_class10template.find('li').first().attr('data-is-template', 'true');
}

/**
 * 서열형 문항에 대한 HTML 템플릿을 지정한다.
 *
 * 답변 템플릿
 * <div class="class_20">
 *     <ul>
 *         <li><input type="checkbox" /><input type="text" name="ans" value="응답1" /><button>삭제</button></li>
 *     </ul>
 *     <button>항목추가</button>
 *     선택 제한<input type="number" name="selectable" />
 * </div>
 */
Survey_manage_form.prototype.set_class20template = function(template) {
	this.dom_class20template = template;
	this.dom_class20template.css('display', 'none');
	this.dom_class20template.children('button').click(function(e) {
		var question = $(this).parents('[id^=question]');
		var ansItem = question.find('li:visible').first().clone(true, true);
		ansItem.children('input[type=text]').val('');
		question.find('ul').append(ansItem);
		$(this).parent().children('input[type=number]').val(question.find('li:visible').length);
	});
	// 응답 항목 삭제 버튼 액션
	this.dom_class20template.find('li button').click(function(e) {
		// 마지막 남은 1개는 삭제되지 않도록 한다.
		if ( $(this).parents('li').parent().children().length == 1 ) {
			return;
		}
		var counter = $(this).parents('ul').parent().children('input[type=number]');
		counter.val(counter.val()-1);
		$(this).parents('li').remove();
	});
	this.dom_class20template.children('input[type=number]').change(function(e) {
		var itemCount = $(this).parent().find('li:visible').length;
		if ( this.value < itemCount ) {
			this.value = 1;
		}
		if ( this.value > itemCount ) {
			this.value = itemCount;
		}
	});
	this.dom_class20template.find('li').first().attr('data-is-template', 'true');
}

/**
 * 개방형 문항에 대한 HTML 템플릿을 지정한다.
 */
Survey_manage_form.prototype.set_class30template = function(template) {
	this.dom_class30template = template;
	this.dom_class30template.css('display', 'none');
}

/**
 * 설문 조사 문항 추가시 사용한다.
 *
 * ex.
 * var frm = new Survey_manage_form(survey_id);
 * frm.add_item();
 */
Survey_manage_form.prototype.add_item = function(data) {
	var question;
	if ( data == undefined ) {
		question = new Survey_item(this.questions.length + 1, 'not yet', 10, undefined);
	} else {
		question = new Survey_item(data.item_id, data.title, data.class, data.answer);
	}
	this.questions.push(question);
	console.log('item count : ' + this.questions.length);
	this.render();
	return;

	var item_id = this.questions.length + 1;
	var new_item = this.dom_template.clone(true, true);
	var frmObj = this;
	new_item.attr('id', 'question' + item_id);
	new_item.css('display', 'block');
	// 문항 번호 세팅
	new_item.children('label').text('설문 ' + item_id);
	// 문항 제목 세팅
	new_item.children('input').attr('name', 'title');
	// 답변 숨기기
	//new_item.children('div[class^=class_]').css('display', 'none');
	// 다항식 답변 항목 추가
	var newAns = frmObj.dom_class10template.clone(true, true);
	new_item.append(newAns);
	// 서열형 답변 항목 추가
	newAns = frmObj.dom_class20template.clone(true, true);
	new_item.append(newAns);
	// 개방형 답변 항목 추가
	newAns = frmObj.dom_class30template.clone(true, true);
	new_item.append(newAns);
	// 문항종류 선택시 처리
	new_item.children('select[name=item_class]').change(function() {
		var item = $(this).parent('[id^=question]');
		//TODO html에 data-class 속성을 넣는 것이 문제 없을까? html5에서 사용하는 기능인데..
		item.attr('data-class', this.value);
		if ( this.value == '10' ) {
			$(this).parent().children('div.class_10').css('display', 'block');
			$(this).parent().children('div.class_20').css('display', 'none');
			$(this).parent().children('div.class_30').css('display', 'none');
			console.log($(this));
		} else if ( this.value == '20' ) {
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
	if ( data != undefined ) {
		new_item.children('input').val(data.title);
		console.log(data.class);
		new_item.children('select').val(data.class);
		$.map(data.answer, function(value, index) {
			Survey_manage_form.prototype.add_class10_answer(this, new_item, value);
		});
	}
	this.dom_form.append(new_item);
}

Survey_manage_form.prototype.add_answer_for_item = function(item_id) {
	var question = this.questions[item_id-1];

	var existingAnswers = question.answers.length;
	if ( existingAnswers >= 7 ) {
		alert('답항수 제한 초과(7)');
		return;
	}
	question.answers.push('new answer');
	question.rendered = 'dirty';
	this.render();
}

Survey_manage_form.prototype.remove_answer_for_item = function(item_id, ans_idx) {
	var question = this.questions[item_id-1];

	if ( question.answers.length == 1 ) {
		return;
	}
	question.answers.splice(ans_idx, 1);
	question.rendered = 'dirty';
	this.render();
}

Survey_manage_form.prototype.replace_answer_for_item = function(item_id, ans_idx, answer) {
	var question = this.questions[item_id-1];

	question.answers[ans_idx] = answer;

	question.rendered = 'dirty';
	console.log(question.answers);
	this.render();
}

/**
 * 새로운 문항 항목을 생성하여 반환한다.
 *
 * ex.
 * var new_item = frm.create_item();
 * or
 * var new_item = frm.create_item({id: , no: , title: , answer: {}});
 */
Survey_manage_form.prototype.create_item = function(data) {
	var item_id = this.questions.length + 1;

	var new_item = this.dom_template.clone(true, true);

	if ( data == undefined ) {
		// 빈 항목을 생성한다.
		new_item.attr('id', 'question0');
		new_item.css('display', 'block');
		// 문항 번호 세팅
		new_item.children('label').text('설문 0');
		// 문항 제목 세팅
		new_item.children('input').attr('name', 'title');
	} else {
		// 받은 데이터를 넣은 항목을 생성한다.
		new_item.attr('id', 'question' + data.id);
		new_item.css('display', 'block');
		// 문항 번호 세팅
		new_item.children('label').text('설문 ' + data.no);
		// 문항 제목 세팅
		new_item.children('input').attr('name', 'title');
	}

	// 다항식 답변 항목 추가
	var newAns = frmObj.dom_class10template.clone(true, true);
	new_item.append(newAns);
	// 서열형 답변 항목 추가
	newAns = frmObj.dom_class20template.clone(true, true);
	new_item.append(newAns);
	// 개방형 답변 항목 추가
	newAns = frmObj.dom_class30template.clone(true, true);
	new_item.append(newAns);
	// 문항종류 선택시 처리
	new_item.children('select[name=item_class]').change(function() {
	});

	return new_item;
}

Survey_manage_form.prototype.submit = function() {
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
Survey_manage_form.prototype._save_item = function(question) {
	var question_id = question.attr('id');
	question_id = question_id.replace('question', '');
	var question_title = question.children('input[name=title]').val();
	var question_class = question.children('select').val();
	//var answers = {};
	var answers = [];
	var answer_count = question.find('li input[type=text]:visible').length;
	question.find('li input[type=text]:visible').each(function(index, obj) {
		//eval('answers.ans' + index + ' = \'' + $(obj).val() + '\''); 
		answers.push($(obj).val());
	});
	//var class20count = question.find('
	console.log('question id is ' + question_id);
	console.log('title ' + question_title);
	console.log('ans ' + answers);
	$.ajax({  
		type: 'POST',  
		url: this.url_save_item,  
		data: {
			"survey_id": this.survey_id,
			"item_id": question_id,
			"title": question_title,
			"class": question_class,
			"values": answers
		},  
		success: function(data, status) {
			console.log(data);
		}
	});  
}

Survey_manage_form.prototype.get_items = function() {
	var frmObj = this;
	$.ajax({  
		type: 'GET',  
		url: this.url_get_items + '/' + this.survey_id,
		success: function(data, status) {
			console.log(data);
			$.map(data, function(value, index) {
				console.log(value);
				frmObj.add_item(value);
			});
			frmObj.render();
		}
	});  
}

Survey_manage_form.prototype.changeClass = function(obj, dom_obj, data) {
	var item = dom_obj.parents('[id^=question]');
	//TODO html에 data-class 속성을 넣는 것이 문제 없을까? html5에서 사용하는 기능인데..
	item.attr('data-class', this.value);
	if ( dom_obj.value == '10' ) {
		$(this).parent().children('div.class_10').css('display', 'block');
		$(this).parent().children('div.class_20').css('display', 'none');
		$(this).parent().children('div.class_30').css('display', 'none');
		console.log($(this));
	} else if ( dom_obj.value == '20' ) {
		$(this).parent().children('div.class_10').css('display', 'none');
		$(this).parent().children('div.class_20').css('display', 'block');
		$(this).parent().children('div.class_30').css('display', 'none');
		console.log($(this));
	} else if ( dom_obj.value == '30' ) {
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
}

/**
 * 다항 선택형 문항 추가
 */
Survey_manage_form.prototype.add_class10_answer = function(obj, domObj, data) {
	//var question = domObj.parents('[id^=question]');
	var question = domObj;
	var existingAnswers = question.find('li:visible').length;
	if ( existingAnswers >= 7 ) {
		alert('답항수 제한 초과(7)');
		return;
	}
	if ( existingAnswers == 0 ) {
		question.find('div').css('display', 'block');
	}
	var ansItem = question.find('li:visible').first().clone(true, true);
	ansItem.children('input[type=text]').val('');
	question.find('ol').append(ansItem);
	if ( question.find('div:visible').length == 0 ) {
		question.find('div').css('display', 'block');
	}
	if ( data != undefined ) {
		ansItem.children('input[type=text]').val(data.val_text);
	}
}

Survey_manage_form.prototype.render = function(dom) {
	var t = this;
	//t.dom_form.children().remove();
	this.questions.forEach(function(obj_item, index) {
		var dom_item;
		if ( obj_item.rendered == true ) {
			return;
		}
		// 객체가 그려지지 않았으므로 표시한다.
		dom_item = t.dom_template.clone(true, true);
		// 화면에 표시
		dom_item.css('display', 'block');
		// 문항 번호 표시
		dom_item.attr('id', 'question' + obj_item.item_id);
		// 문항 번호 세팅
		dom_item.children('label').text('설문 ' + obj_item.item_id);
		// 문항 제목
		dom_item.children('input').attr('name', 'title');
		dom_item.children('input').val(obj_item.title);

		if ( obj_item.clazz == '10' ) {
			var ans = t.dom_class10template.clone(true, true);
			if ( obj_item.answers != undefined && obj_item.answers.length > 0) {
				obj_item.answers.forEach(function(obj_ans, index) {
					var ansItem = ans.find('li[data-is-template=true]').clone(true, true);
					ansItem.removeAttr('data-is-template');
					ansItem.children('input[type=text]').val(obj_ans);
					ansItem.attr('data-index', index);
					ans.find('ol').append(ansItem);
					console.log('li count ' + ans.find('li').length);
				});
				ans.find('li[data-is-template=true]').remove();
				ans.css('display', 'block');
				dom_item.append(ans);
			}
		} else if ( obj_item.clazz == '20' ) {
			var ans = t.dom_class20template.clone(true, true);
			if ( obj_item.answers != undefined && obj_item.answers.length > 0) {
				obj_item.answers.forEach(function(obj_ans, index) {
					var ansItem = ans.find('li[data-is-template=true]').clone(true, true);
					ansItem.removeAttr('data-is-template');
					ansItem.children('input[type=text]').val(obj_ans);
					ansItem.attr('data-index', index);
					ans.find('ul').append(ansItem);
					console.log('li count ' + ans.find('li').length);
				});
				ans.find('li[data-is-template=true]').remove();
				ans.css('display', 'block');
				dom_item.append(ans);
			}
		}
		if ( obj_item.rendered == 'dirty' ) {
			// 객체 수정의 경우, 갱신한다.
			t.dom_form.find('[id=question' + obj_item.item_id + ']').remove();
			t.dom_form.append(dom_item);
		} else {
			t.dom_form.append(dom_item);
			obj_item.rendered = true;
		}
	});
}

Survey_manage_form.prototype.rerender = function(dom) {
	this.dom_form.children().remove();
	if ( this.questions.length > 0 ) {
		this.questions.forEach(function(question, index) {
			question.rendered = false;
		});
	}
	this.render();
}

/**
 * Survey_item = {
 *     "item_id": 'item_id',
 *     "title": 'title',
 *     "class": 'class',
 *     "answers": [
 *         {
 *             "val_id": 'val_id',
 *             "val_text": 'val_text'
 *         },
 *         {
 *             "val_id": 'val_id',
 *             "val_text": 'val_text'
 *         }
 *     ]
 * }
 */
function Survey_item(item_id, title, clazz, answers) {
	this.item_id = item_id;
	this.title = title;
	this.clazz = clazz;
	//this.answers = answers;
	this.answers = [];

	if ( answers == undefined ) {
		answers = [];
	} else {
		var t = this;
		$.map(answers, function(value, index) {
			t.answers.push(value);
		});
	}
}

Survey_item.prototype.set = function(attr_name, value) {
	if ( attr_name == 'item_id' ) {
		this.item_id = value;
	} else if ( attr_name == 'title' ) {
		this.title = value;
	} else if ( attr_name == 'class' ) {
		this.clazz = value;
	} else if ( attr_name == 'answers' ) {
		this.answers = value;
	}
}

Survey_item.prototype.get = function(attr_name) {
	if ( attr_name == 'item_id' ) {
		return this.item_id;
	} else if ( attr_name == 'title' ) {
		return this.title;
	} else if ( attr_name == 'class' ) {
		return this.clazz;
	} else if ( attr_name == 'answers' ) {
		return this.answers;
	} else {
		return this;
	}
}

Survey_item.prototype.add_answer = function(val_id, val_text) {
	answers.push({"val_id": val_id, "val_text": val_text});
}

/**
 * 응답 항목들을 data로 덮어 씌운다.
 *
 * clazz : 10, 20, 30
 * data 형식
 * {"1":"value1", "2":"value2", "3":"value3"}
 */
Survey_item.prototype.set_answers = function(clazz, data) {
	var t = this;
	var dom_ans_template = null;
	this.clazz = clazz;
	if ( t.clazz == 10 ) {
		dom_ans_template = this.dom_class10template;
	} else if ( t.clazz = 20 ) {
		dom_ans_template = this.dom_class20template;
	} else {
		dom_ans_template = this.dom_class30template;
	}
	$.map(data.answer, function(value, index) {
		t.answers.push(value);
		var dom = dom_ans_template.clone(true, true);
		t.dom_answers.append(dom);
	});
}

Survey_item.prototype.add_item = function(clazz, item) {
	var dom_ans_template = null;
//	if ( );
}


Survey_item.prototype.create_item = function(clazz, data) {
	var new_item = null;
	if ( clazz == 10 ) {
		
	}
	if ( data == undefined ) {
	} else {
	}
}

Survey_item.prototype.set_dom = function(dom) {
	this.dom_item = dom;
}

//Survey_item.prototype.add_class10item = function(

Survey_item.prototype.create_answer = function(data) {
	var new_item = null;

	return new_item;
}

function Survey_item_answer(val_id, val_text, clazz) {
	this.val_id = val_id;
	this.val_text = val_text;

	this.dom_ans = null;
}

