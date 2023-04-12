// Update 'version' for cache refresh 
var staticCacheName = 'lafoy_pwa_cache';
var version = 'v01.01';

// Core files in cache
function updateStaticCache() {
  return caches.open(version + staticCacheName).then(function (cache) {
    console.log('ServiceWorkers cache opened'); 
    return cache.addAll([
        '/',
        '/manifest.json',
    ]);
  });
};

self.addEventListener('install', function (event) {
    event.waitUntil(updateStaticCache());
});

self.addEventListener('activate', function (event) {
  event.waitUntil(
    caches.keys().then(function (keys) {
      // Remove the cache version that is no longer valid
      return Promise.all(keys.filter(function (key) {
        return key.indexOf(version) !== 0;}).map(function (key) {
            return caches.delete(key);
        }));
    }));
});

self.addEventListener('fetch', function (event) {
  var request = event.request;
  if (request.method !== 'GET') {
    event.respondWith(fetch(request).catch(function () {return caches.match('offline.html');}));
    return;
  }
  // HTML requests: network first, if fall back => cache, if fall back => offline page 
  if (request.headers.get('Accept').indexOf('text/html') !== -1) {
    // Fix for Chrome bug: https://code.google.com/p/chromium/issues/detail?id=573937
    if (request.mode != 'navigate') {
      request = new Request(request.url, {
        method: 'GET',
        headers: request.headers,
        mode: request.mode,
        credentials: request.credentials,
        redirect: request.redirect
      });
    }
    event.respondWith(
      fetch(request).then(function (response) {
        var copy = response.clone();
        caches.open(version + staticCacheName).then(function(cache) {cache.put(request, copy);});
        return response;
      })
      .catch(function () {
        return caches.match(request).then(function (response) {
          return response || caches.match('offline.html');
        })
      })
    );
    return;
  }
  // non-HTML requests: cache first, if fall back => network
  event.respondWith(
    caches.match(request).then(function (response) {
      return response || fetch(request).catch(function () {
        // Image request: if offline then put a placeholder
        if (request.headers.get('Accept').indexOf('image') !== -1) {
          return new Response('<svg width="400" height="300" role="img" aria-labelledby="offline-title" viewBox="0 0 400 300" xmlns="http://www.w3.org/2000/svg"><title id="offline-title">offline</title><g fill="none" fill-rule="evenodd"><path fill="#D8D8D8" d="M0 0h400v300H0z"/><text fill="#9B9B9B" font-family="Helvetica Neue,Arial,Helvetica,sans-serif" font-size="72" font-weight="bold"><tspan x="93" y="172">offline</tspan></text></g></svg>', {headers:{'Content-Type':'image/svg+xml'}});
        }
      });
    })
  );
});
