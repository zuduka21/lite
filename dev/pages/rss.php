<?php echo '<?xml version="1.0" encoding="UTF-8"?>' ?>
<rss version="2.0" xmlns:content="http://purl.org/rss/1.0/modules/content/">
   <?php $category = getCategoryID() ?>
   <?php $articles = ($category > 0) ? $A->getArticlesByCategory($category, 1, 50) : $A->getArticles(1, 50) ?>
   <channel>
       <title><?php echo $global_meta_title ?></title>
       <link><?php echo $global_site_url ?></link>
       <description><?php echo $global_meta_description ?></description>
       <image>
            <title><?php echo $global_meta_title ?></title>
            <url><?php echo $global_site_url ?>/ms-icon-310x310.png</url>
            <link><?php echo $global_site_url ?></link>
       </image>
       <language>ru</language>

      <?php foreach ($articles as $item): ?>
      <item>
          <guid><?php echo $item->url ?></guid>
          <title><![CDATA[<?php echo $item->name ?>]]></title>
          <link><?php echo $item->url ?></link>
          <pubDate><?php echo date('r', $item->date) ?></pubDate>
          <enclosure url="<?php echo $item->cover ?>" type="image/jpeg" length="1" />
          <description><![CDATA[<?php echo $item->meta_description ?>]]></description>
      </item>
      <?php endforeach ?>

   </channel>
</rss>