    <footer class="footer">
      <div class="container footer__container">
        <div class="footer__col">
          <div class="logo footer__logo">
            <amp-img src="<?php echo getUrl('img/logo--white.png') ?>" alt="LAFOY - Полезные советы и идеи для жизни" title="LAFOY - Полезные советы и идеи для жизни" class="logo__img" height="23" width="102"></amp-img>
          </div>

          <span class="footer__copyrate">© <?php echo date('Y') ?>, Lafoy.ru: Живи красиво!</span>

          <p class="footer__description">Интернет-сайт с полезными советами и идеями для жизни. Все права на фотографии принадлежат их авторам.<br>При правомерном использовании материалов с данного ресурса, гиперссылка на LAFOY.RU обязательна!<br>Материалы, отмеченные знаком «Реклама», публикуются на правах рекламы.</p>

          <span class="footer__stopAge">Сайт может содержать контент, не предназначенный для лиц младше 16 лет.</span>

          <span class="footerEmail footer__email">
              <a href="<?php echo getUrl('amp/about-us') ?>" class="footerEmail__link">О проекте</a>
              <a href="<?php echo getUrl('amp/copyright') ?>" class="footerEmail__link">Правообладателям</a>
          </span>
          <span class="footerEmail footer__email">
              <a href="<?php echo getUrl('amp/contacts') ?>" class="footerEmail__link">Контакты</a>
          </span>
        </div>

        <?php include __DIR__ . "/footer__soc.php" ?>
      </div>

      <?php include __DIR__ . "/footer__counters.php" ?>

    </footer>
     