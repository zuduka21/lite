            <article class="categoryPost categoryPost--big category__post">
              <a href="<?php echo $article->url ?>" class="categoryPost__link">
                <div class="categoryPost__wrapperImg">
                  <img src="<?php echo $article->cover_l ?>" alt="<?php echo $article->name ?>" class="categoryPost__img">
                </div>
              </a>
                <div class="categoryPost_content">
                    <a href="<?php echo $article->url ?>" class="categoryPost__title"><?php echo $article->name ?></a>

                    <span class="categoryPost__infoCategory"><?php echo !empty($article->category) ? $article->category->name : ''?></span>
                </div>
            </article>
