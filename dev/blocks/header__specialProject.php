<?php $p = $A->getSpecialArticle() ?>
<?php if ($p): ?>
          <div class="specialProject header__specialProject">
            <a href="<?php echo $p->url ?>" title="<?php echo $p->name ?>" class="specialProject__link">
              <div class="specialProject__wrapperImg">
                <img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACwAAAAAAQABAAACAkQBADs=" data-src="<?php echo $p->cover_s ?>" alt="<?php echo $p->name ?>" class="specialProject__img lazyload">
              </div>

              <div class="specialProject__content">
                <span class="specialProject__title">СПЕЦПРОЕКТ</span>

                <p class="specialProject__text"><?php echo $p->name ?></p>
              </div>
            </a>
          </div>
<?php endif ?>

<?php /*
<div class="specialProject header__specialProject">
<!--noindex-->
    <a href="https://fas.st/vHsq8" target=_blank rel="noopener,noreferrer,nofollow" title="Товары для дома - распродажа! Скидки до -70%!" class="specialProject__link">
        <div class="specialProject__wrapperImg">
            <img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACwAAAAAAQABAAACAkQBADs=" alt="Товары для дома - распродажа! Скидки до -70%!" data-src="/img/spec<?php echo rand(1,2) ?>.png" class="specialProject__img lazyload">
        </div>

        <div class="specialProject__content">
            <span class="specialProject__title">СПЕЦПРОЕКТ</span>

            <p class="specialProject__text">Товары для дома - распродажа! Скидки до -70%!</p>
        </div>
    </a>
<!--/noindex-->
</div>
*/ ?>