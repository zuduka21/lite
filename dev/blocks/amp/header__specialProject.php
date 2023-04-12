<?php /*
<?php $p = $A->getSpecialArticle() ?>
<?php if ($p): ?>
          <div class="specialProject header__specialProject">
            <a href="<?php echo $p->url ?>" title="<?php echo $p->name ?>" class="specialProject__link">
              <div class="specialProject__wrapperImg">
                <img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACwAAAAAAQABAAACAkQBADs=" data-src="<?php echo $p->cover_s ?>" alt="<?php echo $p->name ?>" class="specialProject__img">
              </div>

              <div class="specialProject__content">
                <span class="specialProject__title">СПЕЦПРОЕКТ</span>

                <p class="specialProject__text"><?php echo $p->name ?></p>
              </div>
            </a>
          </div>
<?php endif ?>
*/ ?>


<div class="specialProject header__specialProject">
<!--noindex-->
    <a href="https://fas.st/vHsq8" target=_blank rel="noopener,noreferrer,nofollow" title="Товары для дома - распродажа! Скидки до -70%!" class="specialProject__link">
        <div class="specialProject__wrapperImg">
            <?php
            $logoArr = array('/img/spec1.png', '/img/spec2.png');
            $curLogo = getURL().$logoArr[rand (0, 1)];
            ?>
            <amp-img src="<?=$curLogo?>" alt="Товары для дома - распродажа! Скидки до -70%!" data-src="<?=$curLogo?>.png" class="specialProject__img lazyload" width="70" height="70"></amp-img>
        </div>

        <div class="specialProject__content">
            <span class="specialProject__title">СПЕЦПРОЕКТ</span>

            <p class="specialProject__text">Товары для дома - распродажа! Скидки до -70%!</p>
        </div>
    </a>
<!--/noindex-->
</div>
