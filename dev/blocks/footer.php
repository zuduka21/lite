    <footer class="footer">
      <div class="container footer__container">
        <div class="footer__col">
          <div class="logo footer__logo">
            <img src="<?php echo getUrl('img/logo--white.png') ?>" alt="LAFOY - Полезные советы и идеи для жизни" title="LAFOY - Полезные советы и идеи для жизни" class="logo__img">
          </div>

          <span class="footer__copyrate">© <?php echo date('Y') ?>, Lafoy.ru: Живи красиво!</span>

          <p class="footer__description">Интернет-сайт с полезными советами и идеями для жизни. Все права на фотографии принадлежат их авторам.<br>При правомерном использовании материалов с данного ресурса, гиперссылка на LAFOY.RU обязательна!<br>Материалы, отмеченные знаком «Реклама», публикуются на правах рекламы.</p>

          <span class="footer__stopAge">Сайт может содержать контент, не предназначенный для лиц младше 18 лет.</span>

          <span class="footerEmail footer__email">
              <a href="<?php echo getUrl('about-us') ?>" class="footerEmail__link">О проекте</a>
              <a href="<?php echo getUrl('copyright') ?>" class="footerEmail__link">Правообладателям</a>
          </span>
          <span class="footerEmail footer__email">
              <a href="<?php echo getUrl('contacts') ?>" class="footerEmail__link">Контакты</a>
          </span>
        </div>

        <?php include __DIR__ . "/footer__soc.php" ?>
      </div>

      <?php include __DIR__ . "/footer__counters.php" ?>

    </footer>

    <div class="btn btn--radius btnToUp">
      <div class="icon icon--arrowTop"></div>
    </div>
     
     
<div class="banner-install banner-install-bottom">
    <div class="banner-install-bottom-logo">
        <svg width="50" height="50" viewBox="2 0 28 30" fill="none" xmlns="http://www.w3.org/2000/svg" id="svg_logo_banner_install"><path d="M0 0Z" /></svg>
    </div>
    <div class="banner-install-bottom-info">
        <div class="banner-install-bottom-header">Читай нас в приложении</div>
        <div class="banner-install-bottom-text">Теперь LAFOY и в твоем телефоне!</div>
    </div>
    <div class="banner-install-bottom-button">
        <button id="install_button">Установить</button>
    </div>
    <div class="banner-install-bottom-close" id="install_close">
        &#215;
    </div>
</div>     