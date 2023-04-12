    <div class="col-md-12">
        <nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light navbar-dark bg-dark static-top">
         
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="navbar-toggler-icon"></span>
            </button> <a class="navbar-brand" href="#">LAFOY</a>
        
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                
                <ul class="navbar-nav ml-md-auto">
                    <li class="nav-item <?php if (getCurrentPage() == 'new'): ?>active<?php endif ?>">
                        <a class="nav-link" href="<?php echo getUrl('page=new') ?>">Новые <span class="badge badge-primary"><?php echo $A->getNewArticlesCount(($U->isAuthor() ? $_SESSION['user_id'] : 0)) ?></span></a>
                    </li>
                    <?php if($U->isAuthor()): ?>
                        <li class="nav-item <?php if (getCurrentPage() == 'users'): ?>active<?php endif ?>">
                            <a class="nav-link" href="<?php echo getUrl('page=users&subpage=article&user_id='.$_SESSION['user_id']) ?>">Мои записи <span class="badge badge-light"><?php echo $A->getUserArticlesCount($_SESSION['user_id']) ?></span></a>
                        </li>
                    <?php endif ?>
                    <?php if(!$U->isAuthor()): ?>

                    <li class="nav-item <?php if (getCurrentPage() == 'reviewed'): ?>active<?php endif ?>">
                        <a class="nav-link" href="<?php echo getUrl('page=reviewed') ?>">Проверенные <span class="badge badge-warning"><?php echo $A->getReviewedArticlesCount() ?></span></a>
                    </li>
                    <?php endif; ?>
                    <?php if($U->isAdmin()): ?>
                    <li class="nav-item <?php if (getCurrentPage() == 'published'): ?>active<?php endif ?>">
                    <a class="nav-link" href="<?php echo getUrl('page=published') ?>">Опубликованные <span class="badge badge badge-success"><?php echo $A->getPublishedArticlesCount() ?></span></a>
                    </li>
                    <li class="nav-item <?php if (getCurrentPage() == 'old'): ?>active<?php endif ?>">
                        <a class="nav-link" href="<?php echo getUrl('page=old') ?>">Устаревшие <span class="badge badge badge-danger"><?php echo $A->getOldArticlesCount() ?></span></a>
                    </li>
                    <li class="nav-item <?php if (getCurrentPage() == 'categories'): ?>active<?php endif ?>">
                        <a class="nav-link" href="<?php echo getUrl('page=categories') ?>">Категории <span class="badge badge badge-light"><?php echo $A->getCategoriesCount() ?></span></span></a>
                    </li>
                    <li class="nav-item <?php if (getCurrentPage() == 'users'): ?>active<?php endif ?>">
                        <a class="nav-link" href="<?php echo getUrl('page=users') ?>">Пользователи</span></a>
                    </li>
                    <li class="nav-item <?php if (getCurrentPage() == 'editor'): ?>active<?php endif ?>">
                        <a class="nav-link" href="<?php echo getUrl('page=editor') ?>">HTML</a>
                    </li>
                    <li class="nav-item <?php if (getCurrentPage() == 'config'): ?>active<?php endif ?>">
                        <a class="nav-link" href="<?php echo getUrl('page=config') ?>">Конфиг</a>
                    </li>
                    <?php endif; ?>
                    <li class="nav-item ml-5">
                        <a class="btn btn-outline-light" href="<?php echo getUrl('page=users&action=logout') ?>">Выход</a>
                    </li>
                </ul>
            </div>
        
        </nav>
    </div>
