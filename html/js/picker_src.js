window.addEvent('domready', function() {
	document.id('ctrl_mb_richmedia').addEvent("blur", function() {
		new Request.Contao({
			onRequest : AjaxRequest.displayBox('Loading data ...'),
			onSuccess : function(res) {
				AjaxRequest.hideBox();
				var el = new Element('span'); el.set('html',res)
				el.getElement('IMG').inject(document.id('pal_mb_richmedia_legend').getElement('IMG'),'after');
				document.id('pal_mb_richmedia_legend').getElement('IMG').dispose();
			}
		}).post({
			'action' : 'mbRichMediaGetIconTag',
			'url' : encodeURI(this.value),
			'REQUEST_TOKEN' : REQUEST_TOKEN
		});
	});
});