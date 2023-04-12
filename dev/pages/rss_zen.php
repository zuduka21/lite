<?php echo '<?xml version="1.0" encoding="UTF-8"?>' ?>
<rss version="2.0" xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:media="http://search.yahoo.com/mrss/" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:georss="http://www.georss.org/georss">   
   <?php $articles = $A->getArticlesZen(1, 50) ?>
   <channel>
       <title><?php echo $global_site_name . " - " . $global_meta_title ?></title>
       <link><?php echo $global_site_url ?></link>
       <description><?php echo $global_meta_description ?></description>
       <language>ru</language>
       <atom:link href="<?php echo $global_site_url ?>/rss_zen.xml" rel="self" type="application/rss+xml" />

      <?php foreach ($articles as $item): ?>
      <item>
          <title><![CDATA[<?php echo $item->name ?>]]></title>
          <link><?php echo $item->url ?></link>
          <guid><?php echo $item->url ?></guid>
          <pubDate><?php echo date('r', $item->date) ?></pubDate>
          <author>info@lafoy.ru (Редакция Lafoy)</author>
          <category>evergreen</category>
          <?php /*<category>native-draft</category>
          <category>noindex</category> */ ?>
          <?php if($item->blocks[0]->type != 9): ?>
              <enclosure url="<?php echo $item->cover ?>" type="image/jpeg" length="0" />
          <?php endif ?>
          <?php foreach ($item->blocks as $block): ?>
              <?php if ($block->type == 3): ?>
                  <enclosure url="<?php echo $block->photo_l ?>" type="image/jpeg" length="0" />
              <?php endif ?>
              <?php if ($block->type == 4): ?>
                  <enclosure url="<?php echo str_replace("watch?v=", "embed/", $block->info) ?>" type="video/youtube" length="0" />
              <?php endif ?>
              <?php if ($block->type == 9): ?>
                  <?php $text = $block->info ?>
                  <?php $text = str_replace("/photo/", "/photo_l/", $text) ?>
                  <?php $doc = new DOMDocument(); ?>
                  <?php libxml_use_internal_errors(true); ?>
                  <?php $doc->loadHTML( $text ); ?>
                  <?php $xpath = new DOMXPath($doc); ?>
                  <?php $imgs = $xpath->query("//img"); ?>
                  <?php $iframes = $xpath->query("//iframe"); ?>
                  <?php for ($i=0; $i < $imgs->length; $i++) { ?>
                  <?php $img = $imgs->item($i); ?>
                    <enclosure url="<?php echo $img->getAttribute("src"); ?>" type="image/jpeg" length="0" />
                  <?php } ?>
                  <?php for ($i=0; $i < $iframes->length; $i++) { ?>
                      <?php $iframe = $iframes->item($i); ?>
                      <enclosure url="<?php echo $iframe->getAttribute("src"); ?>" type="video/youtube" length="0" />
                  <?php } ?>
              <?php endif ?>
          <?php endforeach ?>

          <description><![CDATA[<?php echo $item->meta_description ?>]]></description>
          <?php ob_start() ?>
          <content:encoded><![CDATA[
              <?php $global_photos = $A->getArticlePhotos($item->id) ?>
              <?php $caption = isset($global_photos["{$item->id}_0"]) ? $global_photos["{$item->id}_0"]->source : '' ?>
              <?php if ($item->cover_l != '' && $item->blocks[0]->type != 9): ?><figure><img src="<?php echo $item->cover_l ?>"><?php if ($caption != ""): ?><figcaption>Фото: <?php echo $caption ?></figcaption><?php endif ?></figure><?php endif ?>
              <p></p>
              <?php foreach ($item->blocks as $block): ?>
              
                  <?php if ($block->type == 1) include __DIR__ . "/../blocks/zen_block_type_h2.php" ?>
                  <?php if ($block->type == 6) include __DIR__ . "/../blocks/zen_block_type_h3.php" ?>
                  <?php if ($block->type == 2) include __DIR__ . "/../blocks/zen_block_type_text.php" ?>
                  <?php if ($block->type == 3) include __DIR__ . "/../blocks/zen_block_type_photo.php" ?>
                  <?php if ($block->type == 4) include __DIR__ . "/../blocks/zen_block_type_video.php" ?>
                  <?php if ($block->type == 9) include __DIR__ . "/../blocks/zen_block_type_article.php" ?>
                  <?php //if ($block->type == 7) include __DIR__ . "/../blocks/zen_block_type_product.php" ?>
              
              <?php endforeach ?>
          ]]></content:encoded>

          <?php $content = ob_get_contents() ?>
          <?php $content = "{$content}" ?>
          <?php //$content = updateImageSizes($content, $item->id); ?>
          <?php $content = updateImageCaption($content, $item->id); ?>
          <?php //$content = insertRelativeLinks($content, $item->id, 'turbo'); ?>
          <?php $content = str_replace(' class="post__imgCaption"', '', $content) ?>
          <?php $content = str_replace('/photo_s/', '/photo_l/', $content) ?>
          <?php $content = str_replace('<p></p>', '', $content) ?>
          <?php $content = preg_replace('/data-image=".*?"/', '', $content) ?>
          <?php $content = preg_replace('/data-src=".*?"/', '', $content) ?>
          <?php $content = preg_replace('/data-src-s=".*?"/', '', $content) ?>
          <?php $content = str_replace("\n", "", $content) ?>
          <?php $content = str_replace("\r", "", $content) ?>
          <?php for ($i=1;$i<=10;$i++) $content = str_replace('  ', ' ', $content) ?>
          <?php //$content = str_replace('> <', '><', $content) ?>
          <?php //$content = str_replace('<figcaption>', '<figcaption><span class="copyright">', $content) ?>
          <?php //$content = str_replace('</figcaption>', '</span></figcaption>', $content) ?>
          <?php ob_end_clean () ?>
          <?php echo $content ?>

      </item>
      <?php endforeach ?>

   </channel>
</rss>
