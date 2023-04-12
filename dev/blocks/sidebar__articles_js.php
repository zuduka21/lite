<div class="articles sidebar__articles">
    <span class="articles__title">РЕКОМЕНДУЕМ</span>
  
    <?php $articles = $A->getRandomArticles(4, (isset($article) ? $article->id : 0)) ?>
    <?php foreach ($articles as $a): ?>
    <article class="articlesItem articles__item">
        <a href="<?php echo $a->url ?>" class="articlesItem__link" title="<?php echo $a->name ?>">
            <div class="articlesItem__wrapperImg">
                <img src="<?php echo $a->cover_s ?>" alt="<?php echo $a->name ?>" class="articlesItem__img lazyload">
            </div>

            <div class="articlesItem__content">
                <p class="articlesItem__description"><?php echo $a->name ?></p>
    
                <span class="articlesItem__date"><?php echo date("d.m.Y", $a->date) ?></span>
            </div>
        </a>
    </article>
    <?php endforeach ?>

</div>
