window.addEvent("domready", function () {
    if(document.id("ctrl_mb_richmedia")) {document.id("ctrl_mb_richmedia").addEvent("blur", function () {
        checkRichMedia(this.value)
    })};
    if(document.id("ctrl_mb_richmedia")) {document.id("ctrl_mb_richmedia").addEvent("focus", function () {
        setTimeout(aftersleep, 2000)
    })};

    function checkRichMedia(val) {
        new Request.Contao({
            onRequest: AjaxRequest.displayBox("Loading data ..."),
            onSuccess: function (res) {
                AjaxRequest.hideBox();
                var objResponse = JSON.decode(res);
                REQUEST_TOKEN = objResponse.token;
                var el = new Element("span");
                el.set("html", unescape(objResponse.iconTag));
                if (el.getElement("IMG")) {
                    el.getElement("IMG").inject(document.id("pal_mb_richmedia_legend").getElement("IMG"), "after");
                    document.id("pal_mb_richmedia_legend").getElement("IMG").dispose()
                }
            }
        }).post({
            action: "mbRichMediaGetIconTag",
            url: encodeURI(val),
            REQUEST_TOKEN: REQUEST_TOKEN
        })
    }
    function aftersleep() {
        checkRichMedia(document.id("ctrl_mb_richmedia").value)
    }
});