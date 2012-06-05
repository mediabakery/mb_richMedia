window.addEvent('domready', function() {

	if(document.id('ctrl_appid')) {
		document.id('ctrl_appid').addEvent("blur", function() {
			checkFacebookID(this);
		});
	};
	if(document.id('ctrl_targeturl')) {
		document.id('ctrl_targeturl').addEvent("blur", function() {
			checkFacebookID(this);
		});
	};
	if(document.id('ctrl_authorurl')) {
		document.id('ctrl_authorurl').addEvent("blur", function() {
			checkFacebookID(this);
		});
	};
	function checkFacebookID(inputField) {

		var objData = {
			'action' : 'mbSocializeGetIcon',
			'REQUEST_TOKEN' : REQUEST_TOKEN
		}

		if(inputField.value.length > 0) {
			objData.url = encodeURI(inputField.value);
		}

		new Request.Contao({
			onRequest : AjaxRequest.displayBox('Loading data ...'),
			onSuccess : function(val) {
				AjaxRequest.hideBox();
				var el = new Element('span');
				el.set('html', val);
				if (el.getElement('IMG')) {
					el.getElement('IMG').inject(inputField.getNext(), 'after');
					inputField.getNext().dispose();
				}
			}
		}).post(objData);

	}

});
