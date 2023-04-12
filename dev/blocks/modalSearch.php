  <div class="modalSearch">
    <span class="btn modalSearchClose">
      <i class="icon icon--close modalSearchClose__icon"></i>
    </span>

    <form action="/search.php" method="GET" class="modalSearchForm">
      <div class="modalSearchForm__wrapper">
        <input type="text" class="modalSearchForm__input" name="q" aria-label="search">

        <span class="modalSearchForm__placeholder"><span></span> Что вы ищете?</span>

        <button class="btn btn--white modalSearchFormBtn modalSearchForm__btn" type="submit" aria-label="search">
          <i class="icon icon--bigSearch modalSearchFormBtn__icon"></i>
        </button>
      </div>
    </form>
  </div>
