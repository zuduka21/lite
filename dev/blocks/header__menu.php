          <nav class="headerMenu header__menu">
            <ul class="headerMenu__list">

                <?php foreach ($A->getCategories(['is_main' => 1, 'menu' => 1]) as $item): ?>
                    <?php $url = explode('/', $_SERVER["REQUEST_URI"]); ?>
                    <?php $actual_link = "https://$_SERVER[HTTP_HOST]/$url[1]"; ?>
                    <?php if ($actual_link == $item->url){ ?>
                        <?php if(isset($url[2])): ?>
                            <?php if(strlen($url[2]) < 5): ?>
                                <li class="headerMenu__item active"><span class="headerMenu__link" title="<?php echo $item->name ?>"><?php echo $item->name ?></span></li>
                            <?php else: ?>
                                <li class="headerMenu__item"><a href="<?php echo $item->url ?>" class="headerMenu__link" title="<?php echo $item->name ?>"><?php echo $item->name ?></a></li>
                            <?php endif; ?>
                        <?php else: ?>
                            <li class="headerMenu__item active"><span class="headerMenu__link" title="<?php echo $item->name ?>"><?php echo $item->name ?></span></li>
                        <?php endif; ?>
                    <?php }else { ?>
                        <li class="headerMenu__item"><a href="<?php echo $item->url ?>" class="headerMenu__link" title="<?php echo $item->name ?>"><?php echo $item->name ?></a></li>
                    <?php } ?>
                <?php endforeach ?>

            </ul>
          </nav>
