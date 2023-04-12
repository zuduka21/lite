
  document.querySelector('.headerMobileBtnMenu').addEventListener('click', () => {
    document.querySelector('.page').classList.add('page--isHidden');
    document.querySelector('.modalMobileMenu').classList.add('modalMobileMenu--isVisible');
  });
  document.querySelector('.modalMobileMenuClose').addEventListener('click', () => {
    document.querySelector('.page').classList.remove('page--isHidden');
    document.querySelector('.modalMobileMenu').classList.remove('modalMobileMenu--isVisible');
  });

  document.querySelector('.headerMobileBtnSearch').addEventListener('click', () => {
    document.querySelector('.page').classList.add('page--isHidden');
    document.querySelector('.modalSearch').classList.add('modalSearch--isVisible');
  });
  document.querySelector('.modalSearchClose').addEventListener('click', () => {
    document.querySelector('.page').classList.remove('page--isHidden');
    document.querySelector('.modalSearch').classList.remove('modalSearch--isVisible');
  });