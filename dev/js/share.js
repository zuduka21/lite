(function($) {
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
})(jQuery);