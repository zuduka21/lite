  <div class="modalMobileMenu">
    <span class="btn modalMobileMenuClose">
      <i class="icon icon--close modalMobileMenu__icon"></i>
    </span>

    <ul class="mobileMenu">
      <?php foreach ($A->getCategories(['is_main' => 1, 'menu' => 1]) as $item): ?>
          <li class="mobileMenu__item">
            <a href="<?php echo $item->url ?>" class="mobileMenu__link"><?php echo $item->name ?></a>
          </li>
      <?php endforeach ?>
    </ul>
  </div>
