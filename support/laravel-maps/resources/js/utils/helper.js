export const isDefined = object => typeof object !== 'undefined';

export const fadeElementIn = element => {
  const target = element.closest('.fade');
  target.classList.add('show'); // Bootstrap 4
  target.classList.add('in'); // Backwards compatibility Bootstrap 3.3.7
};

export const openUrl = url => window.open(url, '_blank');

export const logError = error => isDefined(console) && console.error('[laravel-maps] error:', error);
