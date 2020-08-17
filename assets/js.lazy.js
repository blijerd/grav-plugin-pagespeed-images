function jsLazy() {
    document.querySelectorAll('[data-lazyjs]').forEach(function (tabEl) {

        loadUrl = tabEl.dataset.lazyjs;

        loadScript(loadUrl);
    })
}
document.addEventListener("DOMContentLoaded", function () {
    setTimeout(jsLazy, 5000);
});
setTimeout(jsLazy, 5000);
function loadScript(url){

    var script = document.createElement("script")
    script.type = "text/javascript";

    if (script.readyState){  //IE
        script.onreadystatechange = function(){
            if (script.readyState == "loaded" ||
                script.readyState == "complete"){
            }
        };
    }

    script.src = url;

    document.getElementsByTagName("head")[0].appendChild(script);
}