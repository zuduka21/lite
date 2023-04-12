<?xml version="1.0" encoding="UTF-8"?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
        <?php $last_article = $A->getArticles(1,1); ?>
    <url>
        <loc><?php echo getURL() ?></loc>
        <lastmod><?php echo date("Y-m-d", $last_article[0]->date) ?></lastmod>
        <changefreq>Always</changefreq>
        <priority>1.0</priority>
    </url>

    <?php $categories = $A->getCategories() ?>

    <?php foreach ($categories as $category): ?>
        <?php $last_article = $A->getArticlesByCategory($category->id,1, 1); ?>
        <url>
            <loc><?php echo $category->url ?></loc>
            <lastmod><?php echo date("Y-m-d", $last_article[0]->date) ?></lastmod>
            <changefreq>daily</changefreq>
            <priority>0.7</priority>
        </url>
    <?php endforeach ?>

   <?php $articles = $A->getArticles(1, 100) ?>
   
   <?php foreach ($articles as $item): ?>
   <url>
      <loc><?php echo $item->url ?></loc>
      <lastmod><?php echo date("Y-m-d", $item->date) ?></lastmod>
      <changefreq>monthly</changefreq>
      <priority>1.0</priority>
   </url>
   <?php endforeach ?>

</urlset> 