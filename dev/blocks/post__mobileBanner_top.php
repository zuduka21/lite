<div class="postMobileBanner post__mobileBanner_top">

<script>
    if ((window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth) <= 660) {

        window.banner_type = 2; //window.banner_type !== undefined ? (window.banner_type == 1 ? 2 : 1) : Math.floor(Math.random() * 2) + 1;
        rand = window.banner_type;

        <?php /*
        if (rand == 1) {
            document.write('<ins class="adsbygoogle" style="display:block; text-align:center;" data-ad-layout="in-article" data-ad-format="fluid" data-ad-client="ca-pub-7129845194257634" data-ad-slot="6426142473"></ins>');
            (adsbygoogle = window.adsbygoogle || []).push({});
        }
        */ ?>
    
        if (rand == 2) {
            document.write('<div id="yandex-top"></div>');
        
            (function(w, d, n, s, t) {
                w[n] = w[n] || [];
                w[n].push(function() {
                    Ya.Context.AdvManager.render({
                        blockId: "R-A-441159-2",
                        renderTo: "yandex-top",
                        async: true
                    });
                });
                t = d.getElementsByTagName("script")[0];
                s = d.createElement("script");
                s.type = "text/javascript";
                s.src = "//an.yandex.ru/system/context.js";
                s.async = true;
                t.parentNode.insertBefore(s, t);
            })(this, this.document, "yandexContextAsyncCallbacks");
        }
    }
</script>

</div>
