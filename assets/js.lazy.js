var jsLazyLoaded = false;
var lazyInputs = false;
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
console.log("Add listeners to");
// document.addEventListener("DOMContentLoaded", function () {
    lazyInputs = document.getElementsByTagName('input');
    console.log("Add listeners");
    for(ix=0;ix<lazyInputs.length;ix++) {
        lazyInputs[ix].addEventListener("focus", jsLazy);
    }


// });

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