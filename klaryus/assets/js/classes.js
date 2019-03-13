var Util = {
    _soLetras: function (v) {
        return v.replace(/\d/g,"") 
    }, 
    _stickyNav: function (selector) {
        var selector = $(selector);
        selector.before(selector.clone(true).addClass("-sticky"));
        $(window).scroll(function(t) {
            var a = $(window).scrollTop();
            if(a>$('header').outerHeight())
                $('.-sticky').addClass("-stuck"),
                $('header:not(.-sticky)').css('opacity', 0);
            else 
                $('.-sticky').removeClass("-stuck"),
                $('header:not(.-sticky)').css('opacity', 1);
        })
    },       
    _closeModal: function (selector){
        var popup = $(selector);
        if(popup.is('.toggle'))
        {
            popup.removeClass('toggle'),
            popup.find('.thumbnail').css('background-image', ''),
            popup.find('.title').text(''),
            popup.find('.text').text(''),            
            $('body').css('overflow', 'initial');
        }
    },
    _mobileNavigation: function (e) {
        $('body').css('overflow', 'hidden'),
        $('.tcon').addClass('tcon-transform'),
        $('.mobile-navigation').addClass('toggle');

        $(document).mouseup(function (e)
        {
            var container = $(e).children();
    
            if (!container.is(e.target) 
                && container.has(e.target).length === 0)
            {
                $('body').css('overflow', 'initial'),
                $('.tcon').removeClass('tcon-transform'),
                $('.mobile-navigation').removeClass('toggle');
            }
        });         
    },     
    _cnpj: function(selector){
        $(selector).mask('99.999.999/9999-99', {reverse: true});
    }
};