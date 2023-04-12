<article class="categoryPost categoryPost--small category__post">
    <a href="<?php echo $article->url ?>" class="categoryPost__link">
        <div class="categoryPost__wrapperImg">
            <img src="<?php echo $article->cover_s ?>" alt="<?php echo $article->name ?>" class="categoryPost__img">
        </div>
    </a>
    <div class="categoryPost_small_content">
        <a href="<?php echo $article->url ?>" class="categoryPost__title"><?php echo $article->name ?></a>
        <span class="categoryPost__infoCategory"><?php echo $article->category->name ?></span>
    </div>
</article>
