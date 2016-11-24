function Survey_manage(survey_id) {
	this._survey_id = survey_id;
	
}

Survey_manage.set_item_template = function(item_template) {
	Survey_manage.item_template = item_template;
}

Survey_manage.prototype.new_item = function(item_id) {
	var newItem = $('#question_template').clone();
	newItem.attr('id', 'question' + item_id);
	newItem.css('display', 'block');
	newItem.children('label').text('설문 ' + item_id);
	newItem.children('input').attr('name', 'item' + item_id + '_title');
	newItem.children('div[class^=class_]').css('display', 'none');
	newItem.children('select[name=item_class]').change(function(e) {
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
	return newItem;
}

