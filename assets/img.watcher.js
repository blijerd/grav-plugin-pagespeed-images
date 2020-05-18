document.addEventListener("DOMContentLoaded", function() {
    var lazyImages = [].slice.call(document.querySelectorAll('[data-lazysrc]'));

    if ("IntersectionObserver" in window) {
        let lazyImageObserver = new IntersectionObserver(function(entries, observer) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    let lazyImage = entry.target;

                    if(webpSupport == true && lazyImage.dataset.srcwebp) {
                        lazyImage.src = lazyImage.dataset.srcwebp;
                        console.log('loading '+lazyImage.dataset.srcwebp);
                        if(lazyImage.dataset.srcsetwebp) {
                            lazyImage.srcset = lazyImage.dataset.srcsetwebp;
                            console.log('srcset webp found');
                        }
                    } else {
                        lazyImage.src = lazyImage.dataset.src;
                        console.log('loading '+lazyImage.dataset.src);
                        if(lazyImage.dataset.srcset) {
                            lazyImage.srcset = lazyImage.dataset.srcset;
                            console.log('srcset found');
                        }
                    }
                    lazyImageObserver.unobserve(lazyImage);
                }
            });
        });

        lazyImages.forEach(function(lazyImage) {
            lazyImageObserver.observe(lazyImage);
        });
    }
});