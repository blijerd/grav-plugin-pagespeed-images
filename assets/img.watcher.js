function testWebP(callback) {
    var webP = new Image();
    webP.onload = webP.onerror = function () {
        callback(webP.height == 2);
    };
    webP.src = 'data:image/webp;base64,UklGRjoAAABXRUJQVlA4IC4AAACyAgCdASoCAAIALmk0mk0iIiIiIgBoSygABc6WWgAA/veff/0PP8bA//LwYAAA';
};
var webpSupport;
function lazyImages() {

    testWebP(function (support) {
        var body = document.body;
        if (support) {
            body.classList.add("webp");
            webpSupport = true;
        } else {
            body.classList.add("nowebp");
        }
    });


    var lazyImages = [].slice.call(document.querySelectorAll('[data-lazysrc]'));

    if ("IntersectionObserver" in window) {
        let lazyImageObserver = new IntersectionObserver(function (entries, observer) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    let lazyImage = entry.target;

                    if (webpSupport == true && lazyImage.dataset.srcwebp) {
                        lazyImage.src = lazyImage.dataset.srcwebp;
                        // console.log('loading ' + lazyImage.dataset.srcwebp);
                        if (lazyImage.dataset.srcsetwebp) {
                            lazyImage.srcset = lazyImage.dataset.srcsetwebp;
                            // console.log('srcset webp found');
                        }
                    } else {
                        lazyImage.src = lazyImage.dataset.lazysrc;
                        // console.log('loading ' + lazyImage.dataset.src);
                        if (lazyImage.dataset.srcset) {
                            lazyImage.srcset = lazyImage.dataset.srcset;
                            // console.log('srcset found');
                        }
                    }
                    lazyImageObserver.unobserve(lazyImage);
                }
            });
        });

        lazyImages.forEach(function (lazyImage) {
            lazyImageObserver.observe(lazyImage);
        });
    }
}
lazyImages();
document.addEventListener("DOMContentLoaded", function () {
    lazyImages();
});