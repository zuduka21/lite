<?php echo '<?xml version="1.0" encoding="UTF-8"?>' ?>
<rss version="2.0" xmlns:yandex="http://news.yandex.ru" xmlns:media="http://search.yahoo.com/mrss/" xmlns:turbo="http://turbo.yandex.ru">
   <?php $articles = getCurrentPage() > 0 ? $A->getArticlesTurbo(getCurrentPage(), 100) : $A->getArticlesTurbo(0, 50) ?>
   <?php //$articles = $A->getArticlesTurbo(getCurrentPage(), 100) ?>
   <channel>
       <title><?php echo $global_site_name . " - " . $global_meta_title ?></title>
       <link><?php echo $global_site_url ?></link>
       <description><?php echo $global_meta_description ?></description>
       <image>
            <title><?php echo $global_meta_title ?></title>
            <url><?php echo $global_site_url ?>/ms-icon-310x310.png</url>
            <link><?php echo $global_site_url ?></link>
       </image>
       <language>ru</language>

      <?php foreach ($articles as $item): ?>
      <?php $type = ($item->category_id != 46) ? "false" : "true" ?>
      <?php //if (getCurrentPage() > 0 && $item->category_id == 46) continue ?>
      <item turbo="<?php echo $type ?>">
          <guid><?php echo $item->url ?></guid>
          <title><![CDATA[<?php echo $item->name ?>]]></title>
          <link><?php echo $item->url ?></link>
          <pubDate><?php echo date('r', $item->date) ?></pubDate>
          <author><?php echo $item->author ?></author>
          <enclosure url="<?php echo $item->cover ?>" type="image/jpeg" />
          <description><![CDATA[<?php echo $item->meta_description ?>]]></description>
          <turbo:content><![CDATA[<?php include __DIR__ . "/../pages/post_turbo.php" ?>]]></turbo:content>
      </item>
      <?php endforeach ?>

   </channel>
</rss>
