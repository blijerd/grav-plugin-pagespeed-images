function jsLazy() {
    document.querySelectorAll('[data-lazyjs]').forEach(function (tabEl) {
        // loadJS('yourcode.js', yourCodeToBeCalled, document.body);
        loadUrl = tabEl.dataset.lazyjs;
        console.log(loadUrl);
        loadScript(loadUrl, '');
    })
}
document.addEventListener("DOMContentLoaded", function () {
    jsLazy();
});
jsLazy();
// var loadJS = function(url, implementationCode, location){
function loadScript(url, callback){

    var script = document.createElement("script")
    script.type = "text/javascript";
console.log(script);
    if (script.readyState){  //IE
        script.onreadystatechange = function(){
            if (script.readyState == "loaded" ||
                script.readyState == "complete"){
                script.onreadystatechange = null;
                callback();
            }
        };
    } else {  //Others
        script.onload = function(){
            callback();
        };
    }

    script.src = url;
    console.log(url);
    document.getElementsByTagName("head")[0].appendChild(script);
}