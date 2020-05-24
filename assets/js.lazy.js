function jsLazy() {
    document.querySelectorAll('[data-lazyjs]').forEach(function (tabEl) {
        // loadJS('yourcode.js', yourCodeToBeCalled, document.body);
        loadJS(tabEl.getAttribute('data-lazyjs'), document.body);
    })
}
document.addEventListener("DOMContentLoaded", function () {
    jsLazy();
});

// var loadJS = function(url, implementationCode, location){
var loadJS = function(url, location){
    //url is URL of external file, implementationCode is the code
    //to be called from the file, location is the location to
    //insert the <script> element

    var scriptTag = document.createElement('script');
    scriptTag.src = url;

    location.appendChild(scriptTag);
};