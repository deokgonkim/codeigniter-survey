function Select_recipient_form() {
	this.search_criteria_list = [];
	
}

/**
 *
 * 폼 형태
 * <div id="search_criteria">
 *     <dl>
 *         <dt>검색 조건</dt>
 *         <dd><?php echo form_dropdown('search_criteria', $criteria, ''); ?></dd>
 *         <dd><input name="key" /></dd>
 *     </dl>
 *     <button name="add_criteria">조건 추가</button>
 *     <button name="search">검색</button>
 * </div>
 */
function Search_form() {
	this.criterias = [];
	// 최초 이름 검색 조건이 하나 들어가 있음.
	this.criterias.push(new Search_criteria(0, ''));

	this.dom_form = null;
	this.dom_result = null;
	this.dom_criteria_first = null;
}

Search_form.prototype.set_form = function(form) {
	this.dom_form = form;
	var frmObj = this;
	// 검색 조건 선택시, 폼 초기화
	this.dom_form.find('select').change(function(e) {
		var type = $(this).val();
		var index = $(this).parents('dl').index();
		frmObj.criterias[index].type = type;
		if ( type == '0' ) {
			// 이름 검색
		} else if ( type == '1' ) {
			// 그룹 검색
			var new_select = $('<select>');
			new_select.append($('<option>', {
				value: 1,
				text: 'My option'
			}));
			$(this).parents('dl').find('input').replaceWith(new_select);
		} else if ( type == '3' ) {
			// 속성1 검색
		}
	});
	// 조건 추가 버튼 클릭시
	this.dom_form.find('button[name=add_criteria]').click(function(e) {
		var first_type = frmObj.dom_criteria_first.find('select').val();
		frmObj.criterias.push(new Search_criteria(first_type, ''));
		var new_item = frmObj.dom_criteria_first.clone(true, true);
		new_item.insertAfter(frmObj.dom_form.find('dl').last());
	});
	this.dom_criteria_first = this.dom_form.find('dl').clone(true, true);
}

Search_form.prototype.set_result_form = function(form) {
	this.dom_result = form;
}

function Search_criteria(type, value) {
	this.type = type;
	this.value = value;
}
