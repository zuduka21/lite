<?php $info = json_decode($block->info) ?>
<?php $yield = ($block->id - floor($block->id / 2) * 2) == 0 ? 2 : 4 ?>
<?php $step_photos = isset($info->step_photos) ? (array) $info->step_photos : array() ?>

<?php if ($block->info != '' && $info->description != '' && !empty($info)): ?>
    <script type="application/ld+json">
    {
      "@context": "https://schema.org/",
      "@type": "Recipe",
      "name": "<?=$article->name?>",
      <?php if (count($step_photos) > 1): ?>
      "resultPhoto": "<?php echo $step_photos[0] ?>",
      "image": "<?php echo $step_photos[0] ?>",
      <?php else: ?>
      "image": "<?=$article->cover_b ?>",
      <?php endif ?>
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
      "yield": "<?php echo isset($info->cook_yield) && $info->cook_yield > 0 ? $info->cook_yield : $yield?>",
      "recipeIngredient": [
        <?php echo '"' . implode('","', $info->ingredients) . '"' ?>
      ],
      "recipeInstructions": [
            <?php foreach ($info->instructions as $n=>$i): ?>
            {
                "@type": "HowToStep",
                "name": "Шаг <?php echo ($n + 1) ?>",
                "text": "<?php echo $i ?>"
                <?php if (isset($step_photos[$n+1])): ?>,"image": "<?php echo $step_photos[$n+1] ?>"<?php endif ?>
            }
            <?php if ($n < count($info->instructions)-1): ?>, <?php endif ?>
            <?php endforeach ?>
        <?php //echo '"' . implode('","', $info->instructions) . '"' ?>
      ]
    }
    </script>
<?php endif ?>