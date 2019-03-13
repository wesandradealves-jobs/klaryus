var Controller = {
    getController: function () {
        if ($('body').attr('data-controller')) {
            eval('Controller.' + $('body').attr('data-controller') + '();');
        }
    },
    global: function () {
        Util._cnpj('.cnpj');
        Util._stickyNav('header');
    },   
    home: function () {
        $('.webdoor-carousel').owlCarousel({
            items: 1,
            loop: true,
            dots: false,
            nav: true,
            navText: ["<i class='owl-prev-arrow fal fa-angle-left'></i>","<i class='owl-next-arrow fal fa-angle-right'></i>"]
        });
    },     
    fale_conosco: function () {
        $( ".contact-tabs-navigation" ).find('a').click(function() {
            var form_type = $(this).attr('data-tab'),
                $this = $(this);

            console.log(form_type);

            $this.closest('ul').find('.active').not($this.parent()).removeClass('active');

            $this.closest('li').addClass('active');

            $this.closest('.contact-tabs')
            .find('.contact-form .title').text($this.text());

            if(form_type == 'parceiro'){
                $this.closest('.contact-tabs')
                .find('.contact-form .empresa-field')
                .show();
            } else {
                $this.closest('.contact-tabs')
                .find('.contact-form .empresa-field')
                .hide();
            }

            $('#form_type').attr('value', form_type).val(form_type);
        });  
        $( "#seja_fornecedor" ).click(function() {
            $('.contact-tabs-navigation').find('[data-tab="parceiro"]').trigger('click'),
            $('html, body').stop(true, false).animate({
                scrollTop: $('.contact-form').offset().top
            }, 500);
        });      
    },
    fornecedores: function () {

    },       
    archive: function () {

    },      
    search: function () {

    },      
    single: function () {

    },      
    blog: function () {

    },       
    guia_de_limpeza: function () {

    },    
    a_marca: function () {

    },      
    blog: function () {

    },      
    produtos: function () {
        var produto = $('.produtos-list').children(),
            navItems = $('.popupnav'),
            prodList = $('.produtos-list'),
            nav = $('.produtos-navigation ul').children();
        produto.each(function() {
            var $this = $(this);
            $this.click(function() {
                var text = $this.children('div').attr('data-content'),
                    popup = $('.produtos-popup'),
                    title = $this.find('.title').text(),
                    thumbnail = $this.find('.thumbnail').attr('data-thumbnail-big');
                    
                    popup.toggleClass('toggle'),
                    popup.find('.thumbnail').css('background-image', 'url('+thumbnail+')'),
                    popup.find('.title').text(title),
                    popup.find('.text').html(text);

                    $('html, body').stop(true, false).animate({
                        scrollTop: $('body').offset().top
                    }, 500),  $('body').css('overflow', 'hidden');
            });  
        }); 

        nav.each(function() {
            $(this).click(function() {
                window.location = window.location.pathname + '?cat=' + escape($(this).attr('data-type'));
            });
        });

        // navigation between products
        navItems.click(function() {
            var $this = $(this),
                $max = prodList.children().length,
                $count = parseInt(prodList.attr('data-counter')),
                $index = $this.index();
                if($index != 0){
                    if($count < ($max - 1))
                    {
                        prodList.attr('data-counter', $count + 1);
                    }
                } else {
                    if($count > 0)
                    {
                        prodList.attr('data-counter', $count - 1);
                    }
                }
                Util._closeModal('.produtos-popup'),
                setTimeout(function(){ 
                   prodList.children().eq(parseInt(prodList.attr('data-counter'))).trigger( "click" );
                }, 300);
        });         
    },        
};

$(document).ready(function (){
    Controller.getController(); 
    Controller.global();    
});
      
      