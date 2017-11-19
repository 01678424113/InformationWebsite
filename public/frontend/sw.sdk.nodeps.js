

//<script>
    (function (w) {
        if (!(w.similarweb && w.similarweb.api)) {
            // base URLs
            w.similarweb = w.similarweb || {};
            w.similarweb.api = {
                apiBase: 'https://www.similarweb.com',
                assetBase: 'https://www.similarweb.com',
                proBase: 'https://pro.similarweb.com',
                debug: false,
                nodeps: true,
                marketoId: '891-VEY-973',
                isMunchkinEnabled: true,
                hasQqWechatFields: false
            };

            var doneCallbacks = [];

            w.similarweb.ui = {
                captchaKey: '6Ld9tP8SAAAAAKgr5QDjmeSkBXDIIy6aDRFdgYa8',
                addOnDone: function (cb, context) {
                    var bound = cb.bind(context || window);
                    if (w.similarweb.ui.loaded) {
                        bound();
                    } else {
                        doneCallbacks.push(bound);
                    }
                },
                loadingDone: function () {
                    doneCallbacks.forEach(function (cb) {
                        cb();
                    });
                    doneCallbacks = [];
                }
            };

            var head = document.getElementsByTagName('head')[0];

            var link = document.createElement('link');
            link.rel = 'stylesheet';
            link.type = 'text/css';
            link.href = 'https://www.similarweb.com/scripts/sdk/dist/sw.sdk.nodeps.css?v=20171116.3788';

            function loadScript() {
                var script = document.createElement('script');
                script.src = 'https://www.similarweb.com/scripts/sdk/dist/bundle.nodeps.min.js?v=20171116.3788';
                head.appendChild(script);
            }
            // fix for old IE
            if (link.addEventListener) { // W3C DOM
                link.addEventListener("load", loadScript);
            } else if (link.attachEvent) { // IE DOM
                link.attachEvent("onload", loadScript);
            }
            head.appendChild(link);
        }
    })(window);
    //</script>