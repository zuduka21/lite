<section class="post contentBlock__content" itemscope itemtype="http://schema.org/Article">
    <h1 class="post__mainTitle" itemprop="headline"><?php echo $article->name ?></h1>

    <div class="postInforamtion post__inforamtion">
        <span class="postInforamtion__type"><a href="<?php echo $article->category->url ?>" class="postInforamtion__link"><?php echo $article->category->name ?></a></span>

        <span class="postInforamtion__date"><?php echo date("d.m.Y", $article->date) ?></span>

        <span class="postInforamtion__author"><?php echo $article->author ?></span>
    </div>

    <meta itemprop="name" content="<?php echo $article->name ?>" />
    <meta itemprop="description" content="<?php echo $article->meta_description ?>" />
    <meta itemprop="dateModified" content="<?php echo date(DateTime::ISO8601, $article->date) ?>" />
    <meta itemprop="datePublished" content="<?php echo date(DateTime::ISO8601, $article->date) ?>" />
    <link itemprop="url" href="<?php echo $article->url ?>" />
    <meta itemprop="mainEntityOfPage" content="<?php echo $article->url ?>" />

    <div itemprop="articleBody">
        <?php $global_photos = $A->getArticlePhotos($article->id) ?>
        <?php if ($article->cover != '' && (int)$article->blocks[0]->type !== 9): ?>
            <?php $caption = isset($global_photos["{$article->id}_0"]) ? $global_photos["{$article->id}_0"]->source : '' ?>
            <figure class="post__wrapperImg">
                <img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACwAAAAAAQABAAACAkQBADs=" data-src="<?php echo $article->cover_l ?>" data-src-s="<?php echo $article->cover_s ?>" title="<?php echo $article->name ?>" alt="<?php echo $article->name ?>" class="post__img lazyload" itemprop="image" content="<?php echo $article->cover_l ?>">
                <?php if ($caption != ''): ?><figcaption class="post__imgCaption">© <?php echo $caption ?></figcaption><?php endif ?>
            </figure>
        <?php endif ?>

        <?php foreach ($article->blocks as $block): ?>
            <?php $block->info = post_nofollow($block->info); ?>
            <?php if ($block->type == 1) include __DIR__ . "/../blocks/post_block_type_h2.php" ?>
            <?php if ($block->type == 6) include __DIR__ . "/../blocks/post_block_type_h3.php" ?>
            <?php if ($block->type == 2) include __DIR__ . "/../blocks/post_block_type_text.php" ?>
            <?php if ($block->type == 3) include __DIR__ . "/../blocks/post_block_type_photo.php" ?>
            <?php if ($block->type == 4) include __DIR__ . "/../blocks/post_block_type_video.php" ?>
            <?php //if ($block->type == 5) include __DIR__ . "/../blocks/post_block_type_ads.php" ?>
            <?php if ($block->type == 7) include __DIR__ . "/../blocks/post_block_type_product.php" ?>
            <?php if ($block->type == 8) include __DIR__ . "/../blocks/post_block_type_instagram.php" ?>
            <?php if ($block->type == 9) include __DIR__ . "/../blocks/post_block_type_article.php" ?>

        <?php endforeach ?>
        <div class="mobile_ad"></div>
    </div>

    <?php //include __DIR__ . "/../blocks/post_block_type_ads.php" ?>

    <div itemprop="author" itemscope="" itemtype="http://schema.org/Person">
        <meta itemprop="name" content="<?php echo $article->author ?>">
    </div>

    <div itemprop="publisher" itemscope="" itemtype="https://schema.org/Organization">
        <meta itemprop="name" content="<?php echo $global_site_name ?>">
        <meta itemprop="telephone" content="">
        <meta itemprop="address" content="<?php echo $global_site_name ?>">
        <div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
            <link itemprop="url" href="<?php echo getUrl("/img/logo--black.png") ?>" />
            <link itemprop="contentUrl" href="<?php echo getUrl("/img/logo--black.png") ?>" />
        </div>
    </div>

    <?php include __DIR__ . "/../blocks/post__repost.php" ?>
</section>

<script type="text/javascript" rel="defer">
    (function($) {
        $(function() {
            $('div.postRepost').each(function(idx) {
                var el = $(this),
                    u = el.attr('data-url'),
                    t = el.attr('data-title'),
                    i = el.attr('data-image'),
                    d = el.attr('data-description');
                if (!u) u = location.href;

                if (!t) t = document.title;
                if (!d) {
                    var meta = $('meta[name="description"]').attr('content');
                    if (meta !== undefined) d = meta;
                    else d = '';
                }
                u = encodeURIComponent(u);
                t = encodeURIComponent(t);
                t = t.replace(/\'/g, '%27');
                i = encodeURIComponent(i);
                d = encodeURIComponent(d);
                d = d.replace(/\'/g, '%27');
                var vkImage = '';
                if (i != 'null' && i != '') vkImage = '&image=' + i;
                var s = new Array(
                    '<span class="btn postRepost__item postRepost__item--fb" onclick="window.open(\'//www.facebook.com/sharer/sharer.php?u=' + u + '\', \'_blank\', \'scrollbars=0, resizable=1, menubar=0, left=100, top=100, width=550, height=440, toolbar=0, status=0\');return false"><i class="icon icon--bigFb"></i></span>',

                    '<span class="btn postRepost__item postRepost__item--vk" onclick="window.open(\'//vk.com/share.php?url=' + u + '&title=' + t + '&image=' + vkImage + '&description=' + d + '\', \'_blank\', \'scrollbars=0, resizable=1, menubar=0, left=100, top=100, width=550, height=440, toolbar=0, status=0\');return false"><i class="icon icon--bigVk"></i></span>',

                    '<span class="btn postRepost__item postRepost__item--twitter" onclick="window.open(\'//twitter.com/intent/tweet?text=' + t + '&url=' + u + '\', \'_blank\', \'scrollbars=0, resizable=1, menubar=0, left=100, top=100, width=550, height=440, toolbar=0, status=0\');return false"><i class="icon icon--bigTwitter"></i></span>',

                    '<span class="btn postRepost__item postRepost__item--odnoklassniki" onclick="window.open(\'//ok.ru/dk?st.cmd=addShare&st._surl=' + u + '&title=' + t + '\', \'_blank\', \'scrollbars=0, resizable=1, menubar=0, left=100, top=100, width=550, height=440, toolbar=0, status=0\');return false"><i class="icon icon--bigOdnoklassniki"></i></span>',

                    '<span class="btn postRepost__item postRepost__item--pinterest" onclick="window.open(\'//pinterest.com/pin/create/button/?url=' + u + '&media=' + i + '&description=' + t + '\', \'_blank\', \'scrollbars=0, resizable=1, menubar=0, left=100, top=100, width=600, height=300, toolbar=0, status=0\');return false"><i class="icon icon--bigPinterest"></i></span>',
                );
                var l = '';
                for (j = 0; j < s.length; j++) l += s[j];
                el.html(l);
            })
        })
    })(jQuery);
    resizeVideo();

</script>
