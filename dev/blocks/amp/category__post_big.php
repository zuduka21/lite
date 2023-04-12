            <?php $article->url = str_replace($article->_url, 'amp/'.$article->_url, $article->url); ?>
            <article class="categoryPost category__post">
              <a href="<?php echo $article->url ?>" class="categoryPost__link">
                <amp-img src="<?php echo $article->cover_l ?>" srcset="<?php echo $article->cover_l ?> 750w, <?php echo $article->cover_s ?> 450w" title="<?php echo $article->name ?>" alt="<?php echo $article->name ?>" class="categoryPost__img" layout="responsive"></amp-img>
              </a>
                <div class="categoryPost_content">
                    <span class="categoryPost__infoCategory"><?php echo !empty($article->category) ? $article->category->name : ''?></span>
                    
                    <a href="<?php echo $article->url ?>" class="categoryPost__title"><?php echo $article->name ?></a>

                    
                </div>
            </article>
