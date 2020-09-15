function lazyImages() {
    var lazyImages = [].slice.call(document.querySelectorAll('[data-lazysrc]'));

    if ("IntersectionObserver" in window) {
        let lazyImageObserver = new IntersectionObserver(function (entries, observer) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    let lazyImage = entry.target;

                    if (webpSupport == true && lazyImage.dataset.srcwebp) {
                        lazyImage.src = lazyImage.dataset.srcwebp;

                        if (lazyImage.dataset.srcsetwebp) {
                            lazyImage.srcset = lazyImage.dataset.srcsetwebp;
                        }

                    } else {
                        lazyImage.src = lazyImage.dataset.lazysrc;

                        if (lazyImage.dataset.srcset) {
                            lazyImage.srcset = lazyImage.dataset.srcset;

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