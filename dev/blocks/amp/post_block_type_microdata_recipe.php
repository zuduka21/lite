<?php $info = json_decode($block->info) ?>


<?php if ($block->info != '' && $info->description != '' && !empty($info)): ?>
    <script type="application/ld+json">
    {
      "@context": "https://schema.org/",
      "@type": "Recipe",
      "name": "<?=$article->name?>",
      "image": "<?=$article->cover_l?>",
      "author": {
        "@type": "Person",
        "name": "<?=$article->author?>"
      },
      "datePublished": "<?php echo date('Y-m-d', $article->date) ?>",
      "description": "<?=$info->description?>",
      "nutrition": {
        "@type": "NutritionInformation"
      },
      "prepTime": "PT<?=$info->prep_time?>M",
      "cookTime": "PT<?=$info->cook_time?>M",
      "totalTime": "PT<?=$info->cook_time + $info->prep_time?>M",
      "recipeCategory": "<?=$info->category?>",
      "aggregateRating": {
        "@type": "AggregateRating",
        "ratingValue": "<?=$info->rating_value?>",
        "ratingCount": "<?=$info->rating_count?>"
      },
      "recipeIngredient": [
        <?php echo '"' . implode('","', $info->ingredients) . '"' ?>
      ],
      "recipeInstructions": [
        <?php echo '"' . implode('","', $info->instructions) . '"' ?>
      ]
    }
    </script>
<?php endif ?>