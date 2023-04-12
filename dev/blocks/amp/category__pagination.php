<?php $prefix = 'amp' ?>
<?php if (isset($category) && getPageType() == 'category') $prefix .= '/'.$category->_url ?>
<?php $count = $count ?>
<?php $limit = $global_count_posts_in_category ?>
<?php $count_pages = ceil ($count / $limit) ?>
<?php $current_page = getCurrentPage() ?>
<?php $prev_page = $current_page - 1 ?>
<?php $prev_url = $prev_page > 0 ? ($prev_page == 1 ? getUrl($prefix) : getUrl($prefix . "/{$prev_page}")) : false ?>

<?php $next_page = $current_page + 1 ?>
<?php $next_url = $next_page <= $count_pages ? getUrl($prefix . "/{$next_page}") : false ?>

<?php if ($count_pages > 1): ?>
          <ul class="pagination category__pagination">
            <?php if ($prev_url !== false): ?>
            <li class="pagination__item pagination__item--prev">
              <a href="<?php echo $prev_url ?>" class="paginationLink">
                <i class="icon icon--arrowLeft paginationLink__icon"></i>

                <span class="paginationLink__text">Предыдущие</span>
              </a>
            </li>
            <?php
            endif;

            for ($i = 1; $i <= $count_pages; $i++):
              if ($count_pages > 6 && $i == 3 && $current_page > 3): ?>
                <li class="pagination__item"><div class="paginationLink"><span class="paginationLink__text">…</span></div></li>
                <?php
              endif;

              if ($count_pages > 6 && $i == $count_pages - 2 && $current_page < $count_pages - 3): ?>
                <li class="pagination__item"><div class="paginationLink"><span class="paginationLink__text">…</span></div></li>
                <?php 
              endif;

              if ($count_pages > 6 && $i != 1  && $i != $count_pages && $i != $current_page && $i != ($current_page - 1) && $i != ($current_page + 1)) :
                    if (($current_page > 1 && $current_page < $count_pages) || ($current_page == 1 && $i <> 3 && $i <> 4) || ($current_page == $count_pages && $i <> $count_pages - 2 && $i <> $count_pages - 3)) { continue; }  
              endif;
              ?>

              <li class="pagination__item <?php if ($i == $current_page): ?>pagination__item--active<?php endif ?>">
                <?php if ($i == $current_page): ?>
                    <div class="paginationLink">
                      <span class="paginationLink__text"><?php echo $i ?></span>
                    </div>
                <?php else: ?>
                    <a href="<?php echo $i == 1 ? getUrl($prefix) : getUrl($prefix . "/{$i}") ?>" class="paginationLink">
                      <span class="paginationLink__text"><?php echo $i ?></span>
                    </a>
                <?php endif ?>
              </li>
            <?php endfor ?>

            <?php if ($next_url !== false): ?>
            <li class="pagination__item pagination__item--next">
              <a href="<?php echo $next_url ?>" class="paginationLink pagination__link">
                <i class="icon icon--arrowRight paginationLink__icon"></i>

                <span class="paginationLink__text">Следующие</span>
              </a>
            </li>
            <?php endif  ?>
          </ul>
<?php endif ?>

<?php /*
            <li class="pagination__item">
              <a href="javascript:void(0)" class="paginationLink">
                <span class="paginationLink__text">...</span>
              </a>
            </li>
            <!-- /.pagination__item -->
*/ ?>

