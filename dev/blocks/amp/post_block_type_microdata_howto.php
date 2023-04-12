<?php $info = json_decode($block->info) ?>


<?php if ($block->info != '' && $info->description != '' && !empty($info)): ?>
    <script type="application/ld+json">
    {
      "@context": "http://schema.org",
      "@type": "HowTo",
      "name": "<?=$article->name?>",
      "description": "<?=$info->description?>",
      "image": {
        "@type": "ImageObject",
        "url": "<?=$article->cover_l?>"
      },
      <?php if(!empty($info->supplies) && $info->supplies[0] !== ''): ?>
      "supply": [
        <?php foreach($info->supplies as $supply): ?>
        <?php if($supply !== ''): ?>
        {
          "@type": "HowToSupply",
          "name": "<?=$supply?>"
        }<?= next($info->supplies) ? ',' : ''; ?>
        <?php endif; ?>
        <?php endforeach; ?>
      ],
      <?php endif;?>
      <?php if(!empty($info->tools) && $info->tools[0] !== ''): ?>
      "tool": [
        <?php foreach($info->tools as $tool): ?>
        <?php if($tool !== ''): ?>
        {
          "@type": "HowToTool",
          "name": "<?=$tool?>"
        }<?= next($info->tools) ? ',' : ''; ?>
        <?php endif; ?>
        <?php endforeach; ?>
      ],
      <?php endif;?>
      <?php if(!empty($info->steps) && $info->steps[0] !== ''): ?>
      "step": [
       <?php foreach($info->steps as $step): ?>
       <?php if($step !== ''): ?>
        {
          "@type": "HowToStep",
          "text": "<?=$step?>"
        }<?= next($info->steps) ? ',' : ''; ?>
        <?php endif; ?>
        <?php endforeach; ?>
      ],
      <?php endif;?>
      "totalTime": "PT<?=$info->total_time?>M"
    }
    </script>
<?php endif ?>
