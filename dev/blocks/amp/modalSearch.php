  <div class="modalSearch">
    <span class="btn modalSearchClose">
      <i class="icon icon--close modalSearchClose__icon"></i>
    </span>

    <form action="/search.php" target="_top" method="GET" class="modalSearchForm">
      <div class="modalSearchForm__wrapper">
        <input type="text" class="modalSearchForm__input" name="q" aria-label="search" placeholder="Что вы ищете?">
        
        <button class="btn btn--white modalSearchFormBtn modalSearchForm__btn" type="submit" aria-label="search">
          <i class="icon icon--bigSearch modalSearchFormBtn__icon"></i>
        </button>
      </div>
    </form>
  </div>
