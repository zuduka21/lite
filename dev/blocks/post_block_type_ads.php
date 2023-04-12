<?php $banner_id = isset($banner_id) ? $banner_id + 1 : 1 ?>
<?php $id = getBannerID() ?>
<div class="mobile-banner" id="<?php echo $id ?>">

<script>
    if ((window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth) <= 660) {

        window.banner_type = window.banner_type !== undefined ? (window.banner_type == 1 ? 2 : 1) : Math.floor(Math.random() * 2) + 1;
        rand = window.banner_type;

        if (rand == 1) {
            document.getElementById("<?php echo $id ?>").innerHTML='<ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-7129845194257634" data-ad-slot="9823775084" data-ad-format="auto" data-full-width-responsive="false"></ins>';
            (adsbygoogle = window.adsbygoogle || []).push({});
        }
    
        if (rand == 2) {
            document.getElementById("<?php echo $id ?>").innerHTML='<div id="yandex_article-<?php echo $banner_id ?>"></div>';
    
            (function(w, d, n, s, t) {
                w[n] = w[n] || [];
                w[n].push(function() {
                    Ya.Context.AdvManager.render({
                        blockId: "R-A-733100-5",
                        renderTo: "yandex_article-<?php echo $banner_id ?>",
                        async: true,
                        pageNumber: <?php echo $banner_id ?>
                    });
                });
            })(this, this.document, "yandexContextAsyncCallbacks");
        }
    }
    
</script>

</div>
 