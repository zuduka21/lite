console.log('253'); 

var g_country = 'xx';
var comment_is_loaded = false;
var js_is_loaded = false;
var counters_is_loaded = false;
var video_is_loaded = false;
var img_is_loaded = false;
var is_can_install = false;

var bodyHeight = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
var ad_k = isMobile() ? 0.75 : 1.25;



function PWAinit() {
    if('serviceWorker'in navigator){
        window.addEventListener('load',function(){
            navigator.serviceWorker.register('/sw.js').then(
                function(registration){console.log('ServiceWorker registered: ',registration.scope);},
                function(err){console.log('ServiceWorker error: ',err);});
        });

        // Initialize deferredPrompt for use later to show browser install prompt.
        let deferredPrompt;
        let buttonInstall = document.getElementById("install_button");
        let closeInstall = document.getElementById("install_close");

        window.addEventListener('beforeinstallprompt', (e) => {
            is_can_install = true;
            // Prevent the mini-infobar from appearing on mobile
            e.preventDefault();
            // Stash the event so it can be triggered later.
            deferredPrompt = e;
            // Update UI notify the user they can install the PWA
            if (isMobile() && getCookie('hide_install_prompt') !== 'yes') {
                let t = 0;
                
                let lf_visit = sessionStorage.getItem('lf_visit');
  
                if(!lf_visit) {
                    t = 15000;
                    sessionStorage.setItem('lf_visit', 1);
                }

                //setTimeout(showInstallPromotion, t);
            }
            // Optionally, send analytics event that PWA install promo was shown.
            console.log(`'beforeinstallprompt' event was fired.`);
        });

        window.addEventListener('appinstalled', () => {
          // Hide the app-provided install promotion
          hideInstallPromotion();
          // Clear the deferredPrompt so it can be garbage collected
          deferredPrompt = null;
          // Optionally, send analytics event to indicate successful install
          console.log('PWA was installed');
          ym(53943307, "reachGoal", 'APP_INSTALLED');
        });

        if (buttonInstall !== null)
        buttonInstall.addEventListener('click', async () => {
            // Hide the app provided install promotion
            hideInstallPromotion();
            // Show the install prompt
            deferredPrompt.prompt();
            // Wait for the user to respond to the prompt
            const { outcome } = await deferredPrompt.userChoice;
            // Optionally, send analytics event with outcome of user choice
            console.log(`User response to the install prompt: ${outcome}`);
            // We've used the prompt, and can't use it again, throw it away
            deferredPrompt = null;
        });

        if (closeInstall !== null)
        closeInstall.addEventListener('click', async () => {
            hideInstallPromotion();
            setCookie('hide_install_prompt', 'yes', 60*24*7);
        });

    } else {
      console.log('ServiceWorker not supported');
    }
}

function getPWADisplayMode() {
  const isStandalone = window.matchMedia('(display-mode: standalone)').matches;
  if (document.referrer.startsWith('android-app://')) {
    return 'twa';
  } else if (navigator.standalone || isStandalone) {
    return 'standalone';
  }
  return 'browser';
}

function showInstallPromotion() {
    if (!is_can_install) return;
    if ($('.ce-banner').length && $('.ce-banner').css('display') != 'none') return;
    $('.banner-install').show();
    $('.banner-install-bottom-close').hide();
    $('.modalMobileMenu').css('height', 'calc(100vh - 70px)');
}

function hideInstallPromotion() {
    $('.banner-install').hide();
}


PWAinit();

var preloader = "<div class=\"preloader\">\n" +
                "  <div class=\"bounce1\"></div>\n" +
                "  <div class=\"bounce2\"></div>\n" +
                "  <div class=\"bounce3\"></div>\n" +
                "</div>";

!function(t){t.fn.isOnScreen=function(o,e){(null==o||"undefined"==typeof o)&&(o=1),(null==e||"undefined"==typeof e)&&(e=1);var i=t(window),r={top:i.scrollTop(),left:i.scrollLeft()};r.right=r.left+i.width(),r.bottom=r.top+i.height();var f=this.outerHeight(),n=this.outerWidth();if(!n)return!1;var h=this.offset();h.right=h.left+n,h.bottom=h.top+f;var l=!(r.right<h.left||r.left>h.right||r.bottom<h.top||r.top>h.bottom);if(!l)return!1;var m={top:Math.min(1,(h.bottom-r.top)/f),bottom:Math.min(1,(r.bottom-h.top)/f),left:Math.min(1,(h.right-r.left)/n),right:Math.min(1,(r.right-h.left)/n)};return m.left*m.right>=o&&m.top*m.bottom>=e}}(jQuery);

!function(t){t.fn.isOnScreen2=function(o,e){(null==o||"undefined"==typeof o)&&(o=1),(null==e||"undefined"==typeof e)&&(e=1);var i=t(window),r={top:i.scrollTop()+bodyHeight/ad_k,left:i.scrollLeft()};r.right=r.left+i.width(),r.bottom=r.top+i.height();var f=this.outerHeight(),n=this.outerWidth();if(!n)return!1;var h=this.offset();h.right=h.left+n,h.bottom=h.top+f;var l=!(r.right<h.left||r.left>h.right||r.bottom<h.top||r.top>h.bottom);if(!l)return!1;var m={top:Math.min(1,(h.bottom-r.top)/f),bottom:Math.min(1,(r.bottom-h.top)/f),left:Math.min(1,(h.right-r.left)/n),right:Math.min(1,(r.right-h.left)/n)};return m.left*m.right>=o&&m.top*m.bottom>=e}}(jQuery);


/* COOKIES_ENABLER */

function setCookie(name, value, minutes) {
    var expires = "";
    if (minutes) {
        var date = new Date();
        date.setTime(date.getTime() + (minutes*60*1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}
function getCookie (name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}

window.COOKIES_ENABLER=window.COOKIES_ENABLER||function(){"use strict";function e(){var e,n;for(e=1;e<arguments.length;e++)for(n in arguments[e])arguments[e].hasOwnProperty(n)&&(arguments[0][n]=arguments[e][n]);return arguments[0]}function n(e,n,t){var s;return function(){var a=this,i=arguments,o=function(){s=null,t||e.apply(a,i)},r=t&&!s;clearTimeout(s),s=setTimeout(o,n),r&&e.apply(a,i)}}function t(e,n){do if(s(e,n))return e;while(e=e.parentNode);return null}function s(e,n){return(" "+e.className+" ").indexOf(" "+n+" ")>-1}var a,i,o,r={scriptClass:"ce-script",iframeClass:"ce-iframe",acceptClass:"ce-accept",disableClass:"ce-disable",dismissClass:"ce-dismiss",bannerClass:"ce-banner",bannerHTML:null!==document.getElementById("ce-banner-html")?document.getElementById("ce-banner-html").innerHTML:'<p>This website uses cookies. <a href="#" class="ce-accept">Enable Cookies</a></p>',eventScroll:!1,scrollOffset:200,clickOutside:!1,cookieName:"ce-cookie",cookieDuration:"365",wildcardDomain:!1,iframesPlaceholder:!0,iframesPlaceholderHTML:null!==document.getElementById("ce-iframePlaceholder-html")?document.getElementById("ce-iframePlaceholder-html").innerHTML:'<p>To view this content you need to<a href="#" class="ce-accept">Enable Cookies</a></p>',iframesPlaceholderClass:"ce-iframe-placeholder",onEnable:"",onDismiss:"",onDisable:""},c=function(){Math.abs(window.pageYOffset-o)>a.scrollOffset&&u()},l=function(){i={accept:document.getElementsByClassName(a.acceptClass),disable:document.getElementsByClassName(a.disableClass),banner:document.getElementsByClassName(a.bannerClass),dismiss:document.getElementsByClassName(a.dismissClass)};var e,n=i.accept,s=n.length,r=i.disable,l=r.length,d=i.dismiss,p=d.length;for(a.eventScroll&&window.addEventListener("load",function(){o=window.pageYOffset,window.addEventListener("scroll",c)}),a.clickOutside&&document.addEventListener("click",function(e){var n=e.target;return t(n,a.iframesPlaceholderClass)||t(n,a.disableClass)||t(n,a.bannerClass)||t(n,a.dismissClass)||t(n,a.disableClass)?!1:void u()}),e=0;s>e;e++)n[e].addEventListener("click",function(e){e.preventDefault(),u(e)});for(e=0;l>e;e++)r[e].addEventListener("click",function(e){e.preventDefault(),m(e)});for(e=0;p>e;e++)d[e].addEventListener("click",function(e){e.preventDefault(),f.dismiss()})},d=function(n){a=e({},r,n),"Y"==p.get()?("function"==typeof a.onEnable&&a.onEnable(),b.get(),g.get()):"N"==p.get()?("function"==typeof a.onDisable&&a.onDisable(),g.hide(),l()):(f.create(),g.hide(),l())},u=n(function(e){"undefined"!=typeof e&&"click"===e.type&&e.preventDefault(),"Y"!=p.get()&&(p.set(),b.get(),g.get(),g.removePlaceholders(),f.dismiss(),window.removeEventListener("scroll",c),"function"==typeof a.onEnable&&a.onEnable())},250,!1),m=function(e){"undefined"!=typeof e&&"click"===e.type&&e.preventDefault(),"N"!=p.get()&&(p.set("N"),f.dismiss(),window.removeEventListener("scroll",c),"function"==typeof a.onDisable&&a.onDisable())},f=function(){function e(){var e='<div class="'+a.bannerClass+'">'+a.bannerHTML+"</div>";document.body.insertAdjacentHTML("beforeend",e)}function n(){i.banner[0].style.display="none","function"==typeof a.onDismiss&&a.onDismiss()}return{create:e,dismiss:n}}(),p=function(){function e(e){var n,t,s,i,o,r="undefined"!=typeof e?e:"Y";a.cookieDuration?(n=new Date,n.setTime(n.getTime()+24*a.cookieDuration*60*60*1e3),t="; expires="+n.toGMTString()):t="",s=location.hostname,1!==s.split(".")&&a.wildcardDomain?(i=s.split("."),i.shift(),o="."+i.join("."),document.cookie=a.cookieName+"="+r+t+"; path=/; domain="+o,null==p.get()&&(o="."+s,document.cookie=a.cookieName+"="+r+t+"; path=/; domain="+o)):document.cookie=a.cookieName+"="+r+t+"; path=/"}function n(){var e,n,t,s=document.cookie.split(";"),i=s.length;for(e=0;i>e;e++)if(n=s[e].substr(0,s[e].indexOf("=")),t=s[e].substr(s[e].indexOf("=")+1),n=n.replace(/^\s+|\s+$/g,""),n==a.cookieName)return unescape(t)}return{set:e,get:n}}(),g=function(){function e(e){var n=document.createElement("div");n.className=a.iframesPlaceholderClass,n.innerHTML=a.iframesPlaceholderHTML,e.parentNode.insertBefore(n,e)}function n(){var e,n=document.getElementsByClassName(a.iframesPlaceholderClass),t=n.length;for(e=t-1;e>=0;e--)n[e].parentNode.removeChild(n[e])}function t(){var n,t,s=document.getElementsByClassName(a.iframeClass),i=s.length;for(t=0;i>t;t++)n=s[t],n.style.display="none",a.iframesPlaceholder&&e(n)}function s(){var e,n,t,s=document.getElementsByClassName(a.iframeClass),i=s.length;for(t=0;i>t;t++)n=s[t],e=n.attributes["data-ce-src"].value,n.src=e,n.style.display="block"}return{hide:t,get:s,removePlaceholders:n}}(),b=function(){function e(){var e,n,t,s,i=document.getElementsByClassName(a.scriptClass),o=i.length,r=document.createDocumentFragment();for(e=0;o>e;e++)if(i[e].hasAttribute("data-ce-src"))"undefined"!=typeof postscribe&&postscribe(i[e].parentNode,'<script src="'+i[e].getAttribute("data-ce-src")+'"></script>');else{for(t=document.createElement("script"),t.type="text/javascript",n=0;n<i[e].attributes.length;n++)s=i[e].attributes[n],s.specified&&"type"!=s.name&&"class"!=s.name&&t.setAttribute(s.name,s.value);t.innerHTML=i[e].innerHTML,r.appendChild(t)}document.body.appendChild(r)}return{get:e}}();return{init:d,enableCookies:u,dismissBanner:f.dismiss}}();

var loadCE = function() {
        COOKIES_ENABLER.init({
            scriptClass: 'ce-script',
            iframeClass: 'ce-iframe',

            acceptClass: 'ce-accept',
            dismissClass: 'ce-dismiss',
            disableClass: 'ce-disable',

            bannerClass: 'ce-banner',
            bannerHTML:
                '<noindex><p>Наш сайт использует <a href="/cookies-policy">cookies</a>'
                    +'<a href="#" class="ce-accept">'
                        +'Хорошо!'
                    +'</a>'
                +'</p></noindex>',

            cookieName: 'ce-cookie-v1',
            cookieDuration: '365',
            wildcardDomain: false,

            iframesPlaceholder: false,
            iframesPlaceholderHTML:
                '<p>Для просмотра данной страницы необходимо '
                    +'<a href="#" class="ce-accept">Включить Cookies</a>'
                +'</p>',
            iframesPlaceholderClass: 'ce-iframe-placeholder',

            // Callbacks
            onEnable: '',
            onDismiss: '',
            onDisable: ''
        });
}

/* end  COOKIES_ENABLER */


$.fn.isInViewport = function() {
    if(typeof $(this) !== typeof undefined ){
        let elementTop = $(this).offset().top;
        let elementBottom = elementTop + $(this).outerHeight();

        let viewportTop = $(window).scrollTop();
        let viewportBottom = viewportTop + $(window).height();

        return elementBottom > viewportTop && elementTop < viewportBottom;
    }else{
        return false;
    }
}

  function isMobile() {
      var w = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
      return (w <= 660);
  }

  function _addJS (url) {
      var e = document.createElement("script");
      e.src = url;
      e.async = 1;
      document.head.appendChild(e);
  }

  var stickyBanner = function() {

      var sticky = new Sticky('.sidebar__wrapperBanner--sticky');
      //if ($('.contentBlock__content').outerHeight(true) > $('.contentBlock__sidebar').outerHeight(true)) {
          //$(document).ready(function() {
          //var sticky = new Sticky('.sidebar__wrapperBanner--sticky');
          //})
      //}
  };

  var actionModalMobileMenu = function() {
    $(document).on('click', '.headerMobileBtnMenu', function() {
      $('.page').addClass('page--isHidden');
      $('.modalMobileMenu').addClass('modalMobileMenu--isVisible');
      showInstallPromotion();
    })

    $(document).on('click', '.modalMobileMenuClose', function() {
      $('.page').removeClass('page--isHidden');
      $('.modalMobileMenu').removeClass('modalMobileMenu--isVisible');
      hideInstallPromotion();
    })
  };

  var actionModalSearch = function() {
    $(document).on('click', '.headerBtnSearch', function() {
      $('.page').addClass('page--isHidden');
      $('.banner').hide();
      $('.modalSearch').addClass('modalSearch--isVisible');
    })

    $(document).on('click', '.headerMobileBtnSearch', function() {
      $('.page').addClass('page--isHidden');
      $('.banner').hide();
      $('.modalSearch').addClass('modalSearch--isVisible');
    })

    $(document).on('click', '.modalSearchClose', function() {
      $('.page').removeClass('page--isHidden');
      $('.banner').show();
      $('.modalSearch').removeClass('modalSearch--isVisible');
    })
  };

  var hiddenModalSearchFormPlaceholder = function() {
    $(document).on('click', '.modalSearchForm__placeholder', function() {
      $(this).prev('.modalSearchForm__input').focus();
    });

    $(document).on('focusin', '.modalSearchForm__input', function() {
      $(this).next('.modalSearchForm__placeholder').addClass('modalSearchForm__placeholder--isHidden');
    });

    $(document).on('focusout', '.modalSearchForm__input', function() {
      if ($(this).val() == '') {
        $(this).next('.modalSearchForm__placeholder').removeClass('modalSearchForm__placeholder--isHidden');
      }
    });
  }

  var scrollToTop = function() {
    $(window).scroll(function() {
      if ($(this).scrollTop() >= ($(this).width() / 3)) {
        $('.btnToUp').addClass('btnToUp--isVisible');
      } else {
        $('.btnToUp').removeClass('btnToUp--isVisible');
      }
    });

    $(document).ready(function() {
      if ($(window).scrollTop() >= ($(window).width() / 3)) {
        $('.btnToUp').addClass('btnToUp--isVisible');
      } else {
        $('.btnToUp').removeClass('btnToUp--isVisible');
      }
    });

    $(document).on('click', '.btnToUp', function() {
      $('html, body').animate({
        scrollTop: 0
      }, 500);

      $(this).removeClass('btnToUp--isVisible');
    })
  };

  var resizeVideo = function() {
      
      $('.youtube-player').each(function() {
          $(this).attr('src',  $(this).attr('data-src'));
      });
    
      $(document).ready(function() {
          $('.youtube-player').height($('.youtube-player').width() * 0.5625);
      });
      
      $(window).resize(function () {
          $('.youtube-player').height($('.youtube-player').width() * 0.5625);
      });
  }
  
  var loadImages = function() {
      /*
      $("img").each(function(i, elem){
          var img = $(this).attr('data-src');
          var img_s = $(this).attr('data-src-s');
          if (isMobile() && typeof img_s !== typeof undefined && img_s !== false) img = img_s;
            
          if (typeof img !== typeof undefined && img !== false) {
              $(this).attr("src", img);
          }
      });
      */
          $( "img.lazyload" ).each(function() {
              if ($(this).attr('is_loaded') != '1' && ($(this).isOnScreen(0, 0.01) || $(this).isOnScreen2(0, 0.01))) {
                  //console.log($(this).attr('src'));
                  
                  var img = $(this).attr('data-src');
                  var img_s = $(this).attr('data-src-s');
                  if (isMobile() && typeof img_s !== typeof undefined && img_s !== false) img = img_s;
                        
                  if (typeof img !== typeof undefined && img !== false) {
                      $(this).attr("src", img);
                      $(this).attr('is_loaded', '1');
                  }
              }
              img_is_loaded = true;
          });
  }

  var loadBlocks = function() {
      $(".dynamic").each(function() {
          if ($(this).attr('is_loaded') != '-1' && $(this).attr('is_loaded') != '1' && ($(this).isOnScreen(0, 0.01) || $(this).isOnScreen2(0, 0.01))) {
              $(this).load('/index.php?type=' + $(this).attr('data-type') + '&id=' + $(this).attr('data-id'));
              $(this).attr('is_loaded', '1');
          }
      })
  }

  var inProgress = false,
      index = 0,
      id = 0,
      meta_title = '',
      url = '',
      last_meta_title = [document.title],
      last_url = [window.location.href],
      loaded_articles = [];
      
  var loadRelatedArticles = function () {
      if (!$('section.contentBlock__content').length) return; 
      
      let section = $('section.contentBlock__content').last();

      //if(section.children().last().isInViewport() && !inProgress) 
      //if ($('.postRepost').isOnScreen(0, 0.01) || $('.postRepost').isOnScreen2(0, 0.01)) 
      if ($('.footer').isOnScreen(0, 0.01) || $('.footer').isOnScreen2(0, 0.01)) 
      {
          inProgress = true;

          if(typeof related_articles[index] !== typeof undefined){

              id = related_articles[index].id;
              if (typeof loaded_articles[id] === 'undefined') {
                  loaded_articles[id] = 1;
                  console.log(id);
                  meta_title = related_articles[index].meta_title;
                  url = related_articles[index].url;
                  section.after(preloader);
                  $.ajax({
                      type: "GET",
                      url: '/index.php?type=post_related' + '&id=' + id,
                      async: true,
                      cache: true,

                      success: function (data) {
                          $('.preloader').remove();
                          $(section).after(data);
                          document.title = meta_title;
                          window.history.replaceState("", meta_title, url + "-" + id);
                          last_meta_title.push(meta_title);
                          last_url.push(url + "-" + id);
                          inProgress = false;
                          index++;
                      }
                  });
              }
          }
      }
      if(index){
          if(section.isInViewport()){
              document.title = meta_title;
              window.history.replaceState("", meta_title, url + "-" + id);
          }else{
              for (let i = 0; i < $('section.contentBlock__content').length; i++) {
                  if($('section.contentBlock__content').eq(i).isInViewport()){
                      document.title = last_meta_title[i];
                      window.history.replaceState("", last_meta_title[i], last_url[i]);
                  }
              }
          }
      }
  }
  

  const domains = {
      social: [
          'instagram.',
          'tiktok.',
          'facebook.',
          'vk.',
          'ok.',
      ],
      search: [
          'yandex.',
          'toloka',
          'google.',
          'baidu.',
          'yahoo.',
          'bing.'
      ]
  }
  
  function lfDetectRef() {
      console.log('Detect start');
      const ref = document.referrer;
    
      if(!ref) return 'direct';
    
      const refDomain = new URL(ref).hostname;
    
      for(let key in domains) {
          const contains = domains[key].some(element => {
              if (refDomain.includes(element)) {
                  return true;
              }
        
              return false;
          });
      
          if(contains) return key;
      }
    
      return 'site';
  }
  
  function lfGetRef() {
      let refferer = sessionStorage.getItem('refferer');
  
      if(!refferer) {
          refferer = lfDetectRef();
          sessionStorage.setItem('refferer', refferer);
      }
      console.log('lfGetRef :: ' + refferer);
      
      return refferer;
  }
  
  function lfGetPostType() {
      let ret =  $('.postInforamtion__link').text();
      if (!ret || ret === null) ret = 'not_post';
      
      console.log('lfGetPostType :: ' + ret);
      
      return ret;
  }

  
  var ref = getCookie('lref') === null ? (document.referrer ? ('' + document.referrer + '') : 'direct') : getCookie('lref');
  if (ref.indexOf('lafoy.ru') > -1) ref = 'direct';
  if (ref.indexOf('yandex') === -1 && ref.indexOf('google') === -1 && ref.indexOf('toloka') === -1) ref = 'direct';
  if (getCookie('lref') === null) setCookie ('lref', ref, 5);
  let g_ref = ref;
  let g_rand = Math.floor(Math.random() * 3) + 1;
  console.log(ref);

  var vbanner_id = '-1';
  var is_dev = $('body').hasClass('is_dev');
  //if (ref == 'direct') is_dev = true;
  is_dev = false;
  var yandex_only = $('.contentBlock').hasClass('yandex_only');
  var google_only = false;
  
  var dayg_id = 0;
  var rand = 0;
  var side_id = 0;
  var side_time = Math.floor(Date.now() / 1000) - 11;
  
  var loadFullScreenAd = function(country) {

      if (google_only) return;
      
      if (isMobile()) {
          var adsArray = [
              //'R-A-2164698-5', 
              'R-A-2164698-10', 
              //'R-A-2164698-8', 
              //'R-A-2164698-9', 
          ];
      } else {
          return;
      }

      let block_id = adsArray[Math.floor(Math.random()*adsArray.length)];
      
      window.yaContextCb.push(()=>{
          Ya.Context.AdvManager.render({
              type: 'fullscreen',    
              platform: 'touch',
              blockId: block_id
          })
      });
  };
  
  var loadAds = function() {
      if (js_is_loaded === false) return;

      yandex_only = (g_country === 'ru') ? true : yandex_only;
      google_only = ! yandex_only;
      if (g_country === 'kz' || g_country === 'by' || g_country === 'xx') google_only = false;
      
      if (!isMobile() && $('.contentBlock__sidebar').length && $('.contentBlock__sidebar').css('display') != 'none') {
          //$( ".dayg" ).each(function() {
              //if (($(this).attr('is_loaded') == '1' && $(this).isOnScreen(0, 0.01)) || vbanner_id == '') {
                  if (vbanner_id != $(this).attr('id') && (Math.floor(Date.now() / 1000) - side_time > 10)) {
                      window.banner_side_type = window.banner_side_type !== undefined ? (window.banner_side_type == 1 ? 2 : 1) : Math.floor(Math.random() * 2) + 1;

                      rand = window.banner_side_type;
                      if (yandex_only) rand = 2;
                      if (google_only) rand = 1;
                                            
                      side_id ++;
                      if(!is_dev) {
                          if (rand == 1) {
                               side_time = Math.floor(Date.now() / 1000);
                               document.getElementById("side_banner").innerHTML='<ins class="adsbygoogle" style="display:inline-block;width:300px;height:600px" data-ad-client="ca-pub-7129845194257634" data-ad-slot="5412443703" data-ad-format="auto" data-full-width-responsive="true"></ins>';
                               (adsbygoogle = window.adsbygoogle || []).push({});
                           }

                           if (rand == 2) {
                               side_time = Math.floor(Date.now() / 1000);
                               document.getElementById("side_banner").innerHTML='<div id="yandex_sidebar-' + side_id + '"></div>';

                               window.yaContextCb.push(()=>{
                                  Ya.Context.AdvManager.render({
                                      renderTo: 'yandex_sidebar-' + side_id,
                                      blockId: 'R-A-2164698-7',
                                      pageNumber: side_id
                                  })
                               });

                           }
                           
                      }

                      vbanner_id = $(this).attr('id');

                      if(!$('#side_banner').children().length){
                          //$('#side_banner').css({'height' :  '600px', 'background-color' : '#eeeeee', 'margin-top' : '20px'});
                      }else{
                          $('#side_banner').css({'height' :  '', 'background-color' : '', 'margin-top' : '20px'});
                      }
                  }
              //}
          //});
      }

      var count = 0;
      $( ".dayg:not(:first):not(:first)" ).each(function() {
          if ($(this).attr('is_loaded') == '1' && ($(this).isOnScreen(0, 0.01) || $(this).isOnScreen2(0, 0.01))) count ++;
      });
        
      var flag = 0;
      var num = 0;

      if(isMobile())
          var selector = $(".dayg:not(:first):not(:first)");
      else
          var selector = $(".dayg:not(:first):not(:first):even:odd:odd:even");

      selector.each(function() {
          if ($(this).attr('is_loaded') != '-1' && $(this).attr('is_loaded') != '1' && ($(this).isOnScreen(0, 0.01) || $(this).isOnScreen2(0, 0.01))) {
              num ++;
              if (count == 0 && flag == 0 && num > 0) {
                  if (isMobile()) {
                      $(this).attr('is_loaded', '1').css('margin-bottom', '25px');
                      flag = 1;

                      window.banner_type = window.banner_type !== undefined ? (window.banner_type == 1 ? 2 : 1) : Math.floor(Math.random() * 2) + 1;
                      rand = window.banner_type;
                      if (yandex_only) rand = 2;
                      if (google_only) rand = 1;
                      
                      dayg_id ++;

                      $(this).attr('id', dayg_id);

                      if(!is_dev) {
                          if (rand == 1) {
                              window.banner_google_type = window.banner_google_type !== undefined ? (window.banner_google_type == 1 ? 2 : 1) : Math.floor(Math.random() * 2) + 1;
                              
                              if (window.banner_google_type == 1) $(this).html('<ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-7129845194257634" data-ad-slot="9823775084" data-ad-format="auto" data-full-width-responsive="true"></ins>');
                              
                              if (window.banner_google_type == 2) $(this).html('<ins class="adsbygoogle" style="display:block; text-align:center;" data-ad-layout="in-article" data-ad-format="fluid" data-ad-client="ca-pub-7129845194257634" data-ad-slot="2736772571"></ins>');

                              (adsbygoogle = window.adsbygoogle || []).push({});
                          }

                          if (rand == 2) {
                              $(this).html('<div id="dayg-' + dayg_id + '" class="aby"></div>');


                              if (Math.floor(Math.random() * 2) + 1 == 1) {
                                  var adsArray = [
                                      'R-A-2164698-4', 
                                      //'R-A-2164698-11', 
                                  ];                                

                                  window.yaContextCb.push(()=>{
                                      Ya.Context.AdvManager.render({
                                          renderTo: 'dayg-' + dayg_id,
                                          blockId: adsArray[Math.floor(Math.random()*adsArray.length)],
                                          pageNumber: dayg_id
                                      })
                                  });
                               } else {
                                  window.yaContextCb.push(()=>{
                                      Ya.adfoxCode.createAdaptive({
                                          ownerId: 695982, containerId: 'dayg-' + dayg_id,
                                          params: {pp: 'i', ps: 'giva', p2: 'iedm'}
                                      }, ['phone'], {
                                          tabletWidth: 830, phoneWidth: 480, isAutoReloads: false
                                      })
                                  })
                              }

                          }
                      }

                  }

                  if (!isMobile()) {
                      $(this).attr('is_loaded', '1').css('margin-bottom', '25px');
                      flag = 1;

                      window.banner_type = window.banner_type !== undefined ? (window.banner_type == 1 ? 2 : 1) : Math.floor(Math.random() * 2) + 1;
                      rand = window.banner_type;
                      if (yandex_only) rand = 2;
                      if (google_only) rand = 1;
                      
                      dayg_id++;

                      $(this).attr('id', dayg_id);

                      if(!is_dev) {
                          if (rand == 1) {
                              $(this).html('<ins class="adsbygoogle" style="display:block;text-align:center;"  data-ad-layout="in-article" data-ad-format="fluid" data-ad-client="ca-pub-7129845194257634" data-ad-slot="6426142473"></ins>');
                              (adsbygoogle = window.adsbygoogle || []).push({});
                          }

                          if (rand == 2) {
                              $(this).html('<div id="dayg-' + dayg_id + '"></div>');

                               window.yaContextCb.push(()=>{
                                  Ya.Context.AdvManager.render({
                                      renderTo: 'dayg-' + dayg_id,
                                      blockId: 'R-A-2164698-6',
                                      pageNumber: dayg_id
                                  })
                               });
                          }

                      }
                  }
                  if(!$(this).children().length && $(this).attr('is_loaded') === '1'){
                      //$(this).css({'height' :  '70px', 'background-color' : '#eeeeee'});
                  }else{
                      $(this).css({'height' :  '', 'background-color' : ''});
                  }
              } else {
                  $(this).attr('is_loaded', '-1');
              }
          }
      });
  }
  
  var loadCounters = function() {
      counters_is_loaded = true;
      
      /*
      var _tmr = window._tmr || (window._tmr = []);
      _tmr.push({id: "2856632", type: "pageView", start: (new Date()).getTime()});
      (function (d, w, id) {
        if (d.getElementById(id)) return;
        var ts = d.createElement("script"); ts.type = "text/javascript"; ts.async = true; ts.id = id;
        ts.src = "https://top-fwz1.mail.ru/js/code.js";
        var f = function () {var s = d.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ts, s);};
        if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); }
      })(document, window, "topmailru-code");
      */

      (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
      m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
      (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

      ym(53943307, "init", {
          clickmap:true,
          trackLinks:true,
          accurateTrackBounce:true,
          
          userParams: {
              'display_mode': getPWADisplayMode(),
          },
          
          params: [
              {'lafoy_visit_src': lfGetRef()},
              {'lafoy_post_type': lfGetPostType()}
          ]
          
      });
      
      //window.dataLayer = window.dataLayer || [];
      //function gtag(){dataLayer.push(arguments);}
      //gtag('js', new Date());
      //gtag('config', 'UA-47915019-7');

      $("footer").append("<img src='//counter.yadro.ru/hit?t52.6;r"+
      escape(document.referrer)+((typeof(screen)=="undefined")?"":
      ";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
      screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
      ";h"+escape(document.title.substring(0,150))+";"+Math.random()+
      "' alt='' title='' "+
      "border='0' width='1' height='1'>");

  }
  
  var loadJS = function() {
      if (js_is_loaded === true) return;
      js_is_loaded = true;
      
      window.Ya || (window.Ya = {});
      window.yaContextCb = window.yaContextCb || [];
        
      window.article_id || (window.article_id = 0);
      
      _addJS("//yandex.ru/ads/system/header-bidding.js");
      _addJS("//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js");
      _addJS("//yandex.ru/ads/system/context.js");
      //_addJS("//www.googletagmanager.com/gtag/js?id=UA-47915019-7");
      
      var adfoxBiddersMap = {
        "betweenDigital": "1989202",
        "adriver": "2228322",
        "myTarget": "1989200"
      };

      var adUnits = [
        {
          "code": "adfox_167965133368025704",
          "sizes": [[300, 300]],
          "bids": [
            {"bidder": "myTarget", "params": {"placementId": "1237573"}},
            {"bidder": "betweenDigital", "params": {"placementId": "4702655"}},
            {"bidder": "adriver", "params": {"placementId": "79:lafoy_300x300", "additional": {"ext": {"query" : "custom=10=79&cid="+localStorage.getItem('adrcid')} }}}
          ]
        }
      ];
      
      var userTimeout = 1500;
      
      window.YaHeaderBiddingSettings = {
        biddersMap: adfoxBiddersMap,
        adUnits: adUnits,
        timeout: userTimeout
      };      
      
  }
  
  
    $(function() {
        $('div.postRepost').each(function(idx) {
            var el = $(this),
                u = el.attr('data-url'),
                t = el.attr('data-title'),
                i = el.attr('data-image'),
                d = el.attr('data-description');
            if (!u) u = location.href;

            if (!t) t = document.title;
            if (!d) {
                var meta = $('meta[name="description"]').attr('content');
                if (meta !== undefined) d = meta;
                else d = '';
            }
            u = encodeURIComponent(u);
            t = encodeURIComponent(t);
            t = t.replace(/\'/g, '%27');
            i = encodeURIComponent(i);
            d = encodeURIComponent(d);
            d = d.replace(/\'/g, '%27');
            var vkImage = '';
            if (i != 'null' && i != '') vkImage = '&image=' + i;
            var s = new Array(
                '<span class="btn postRepost__item postRepost__item--fb" onclick="window.open(\'//www.facebook.com/sharer/sharer.php?u=' + u + '\', \'_blank\', \'scrollbars=0, resizable=1, menubar=0, left=100, top=100, width=550, height=440, toolbar=0, status=0\');return false"><i class="icon icon--bigFb"></i></span>',
                
                '<span class="btn postRepost__item postRepost__item--vk" onclick="window.open(\'//vk.com/share.php?url=' + u + '&title=' + t + '&image=' + vkImage + '&description=' + d + '\', \'_blank\', \'scrollbars=0, resizable=1, menubar=0, left=100, top=100, width=550, height=440, toolbar=0, status=0\');return false"><i class="icon icon--bigVk"></i></span>',
                
                '<span class="btn postRepost__item postRepost__item--twitter" onclick="window.open(\'//twitter.com/intent/tweet?text=' + t + '&url=' + u + '\', \'_blank\', \'scrollbars=0, resizable=1, menubar=0, left=100, top=100, width=550, height=440, toolbar=0, status=0\');return false"><i class="icon icon--bigTwitter"></i></span>',
                
                '<span class="btn postRepost__item postRepost__item--odnoklassniki" onclick="window.open(\'//ok.ru/dk?st.cmd=addShare&st._surl=' + u + '&title=' + t + '\', \'_blank\', \'scrollbars=0, resizable=1, menubar=0, left=100, top=100, width=550, height=440, toolbar=0, status=0\');return false"><i class="icon icon--bigOdnoklassniki"></i></span>',
                
                '<span class="btn postRepost__item postRepost__item--pinterest" onclick="window.open(\'//pinterest.com/pin/create/button/?url=' + u + '&media=' + i + '&description=' + t + '\', \'_blank\', \'scrollbars=0, resizable=1, menubar=0, left=100, top=100, width=600, height=300, toolbar=0, status=0\');return false"><i class="icon icon--bigPinterest"></i></span>',
            );
            var l = '';
            for (j = 0; j < s.length; j++) l += s[j];
            el.html(l);
        })
    })

  
  $(document).ready(function(){
      
      fetch('/cdn-cgi/trace').then(res=>res.text()).then(data=>{
          let arr = Object.fromEntries(data.trim().split('\n').map(e=>e.split('=')));

          g_country = arr.loc || 'xx';
          g_country = g_country.toLowerCase();

          console.log('Country = ' + g_country);
          loadJS();
          loadAds();

          $(window).on('scroll', function(e) {
              loadAds();
          });
                    
          if (window.location.href != window.location.origin && window.location.href != window.location.origin + '/' && !sessionStorage.getItem('lf_loadFullScreenAd')) 
          if ((!is_dev)) 
          {
              $(window).one('scroll', function(e) {
                  setTimeout(function() { 
                      sessionStorage.setItem('lf_loadFullScreenAd', true);
                      loadFullScreenAd(g_country);
                  }, 10000);  
              });
          }
      })

      setTimeout(function() { loadJS() }, 1);  

      $(window).on('mousemove scroll', function(e) {
          if (!js_is_loaded) {
              js_is_loaded = true;
              loadJS();
          }
          if (!counters_is_loaded) {
              counters_is_loaded = true;
              loadCounters();
          }
          if (!video_is_loaded) {
              resizeVideo();
              video_is_loaded = true;
          }
      });

      //$(window).on('scroll', function(e) {
      //    loadAds();
      //});
      
      $(window).on('load scroll', function(e) {
          //loadAds();
          loadImages();
          //loadBlocks();
          loadRelatedArticles();
      });

      setTimeout(function() { 
          if (!counters_is_loaded) {
              counters_is_loaded = true;
              loadCounters();
          }
      }, 5);  

      loadImages();
      stickyBanner();

      actionModalMobileMenu();
      actionModalSearch();
      hiddenModalSearchFormPlaceholder();
      scrollToTop(); 
      loadCE();

  });
  
