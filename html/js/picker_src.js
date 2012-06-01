window.addEvent('domready', function() {
	document.id('ctrl_mb_richmedia').addEvent("blur", function() {
		checkRichMedia(this.value);
	});

	document.id('ctrl_mb_richmedia').addEvent("focus", function() {
		document.id('ctrl_mb_richmedia').removeEvent("focus");
		setTimeout(aftersleep, 2000);
	});

	function checkRichMedia(val) {
		new Request.Contao({
			onRequest : AjaxRequest.displayBox('Loading data ...'),
			onSuccess : function(res) {
				AjaxRequest.hideBox();
				var el = new Element('span');
				el.set('html', res)
				el.getElement('IMG').inject(document.id('pal_mb_richmedia_legend').getElement('IMG'), 'after');
				document.id('pal_mb_richmedia_legend').getElement('IMG').dispose();
			}
		}).post({
			'action' : 'mbRichMediaGetIconTag',
			'url' : encodeURI(val),
			'REQUEST_TOKEN' : REQUEST_TOKEN
		});
	}

	function aftersleep() {
		checkRichMedia(document.id('ctrl_mb_richmedia').value);
	}
});
