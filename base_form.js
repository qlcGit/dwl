$().extend('serialize',function() {
	for (var i = 0; i < this.elements.length; i++) {
		var form = this.elements[i];
		var parts = {};
		for (var j = 0; j < form.elements.length; j++) {
			var filed = form.elements[j];
			switch(filed.type) {
				case undefined :
				case 'submit' :
				case 'reset' :
				case 'file' :
				case 'button' :
					break;
				case 'radio' :
				case 'checkbox' :
					if (!filed.selected) break;
				case 'select-one' :
				case 'select-multiple' :
					for(var k = 0;k < filed.options.length;k++) {
						var option = filed.options[k];
						if (option.selected) {
							var optValue = '';
							if (option.hasAttribute) {
								optValue = (option.hasAttribute('value') ? option.value : option.text);
							}else {
								optValue = (option.attributes('value').specified ? option.value : option.text);
							}
							parts[filed.name] = optValue;
						}
					}
					break;
				default :
					parts[filed.name] = filed.value;
			}
		}
		return parts;
	}
	return this;
});
