jsLazyLoaded = false;
function jsLazy() {
    if(jsLazyLoaded == false) {
        console.log("Load lazyjs");

        jsLazyLoaded = true;
        document.querySelectorAll('[data-lazyjs]').forEach(function (tabEl) {

            loadUrl = tabEl.dataset.lazyjs;

            loadScript(loadUrl);
        })
    }
}
document.addEventListener("DOMContentLoaded", function () {
    inputs = document.getElementsByTagName('input');
    console.log("Add listeners");
    for(i=0;i<inputs.length;i++) {
        inputs[i].addEventListener("focus", jsLazy);
    }


});

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