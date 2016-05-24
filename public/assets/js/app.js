/*   
 * Template Name: Unify - Responsive Bootstrap Template
 * Description: Business, Corporate, Portfolio and Blog Theme.
 * Version: 1.3
 * Author: Html Stream
 * Website: http://htmlstream.com/preview/unify
*/

var App = function () {

    function handleIEFixes() {
        //fix html5 placeholder attribute for ie7 & ie8
        if (jQuery.browser && jQuery.browser.msie && jQuery.browser.version.substr(0, 1) < 9) { // ie7&ie8
            jQuery('input[placeholder], textarea[placeholder]').each(function () {
                var input = jQuery(this);

                jQuery(input).val(input.attr('placeholder'));

                jQuery(input).focus(function () {
                    if (input.val() == input.attr('placeholder')) {
                        input.val('');
                    }
                });

                jQuery(input).blur(function () {
                    if (input.val() == '' || input.val() == input.attr('placeholder')) {
                        input.val(input.attr('placeholder'));
                    }
                });
            });
        }
    }

    function handleBootstrap() {
        jQuery('.carousel').carousel({
            interval: 15000,
            pause: 'hover'
        });
        jQuery('.tooltips').tooltip();
        jQuery('.popovers').popover();
    }

    function handleSearch() {    
        jQuery('.search').click(function () {
            if(jQuery('.search-btn').hasClass('icon-search')){
                jQuery('.search-open').fadeIn(500);
                jQuery('.search-btn').removeClass('icon-search');
                jQuery('.search-btn').addClass('icon-remove');
            } else {
                jQuery('.search-open').fadeOut(500);
                jQuery('.search-btn').addClass('icon-search');
                jQuery('.search-btn').removeClass('icon-remove');
            }   
        }); 
    }

    function handleSwitcher() {    
        var panel = jQuery('.style-switcher');

        jQuery('.style-switcher-btn').click(function () {
            jQuery('.style-switcher').show();
        });

        jQuery('.theme-close').click(function () {
            jQuery('.style-switcher').hide();
        });
        
        jQuery('li', panel).click(function () {
            var color = jQuery(this).attr("data-style");
            var data_header = jQuery(this).attr("data-header");
            setColor(color, data_header);
            jQuery('.list-unstyled li', panel).removeClass("theme-active");
            jQuery(this).addClass("theme-active");
        });

        var setColor = function (color, data_header) {
            jQuery('#style_color').attr("href", "assets/css/themes/" + color + ".css");
            if(data_header == 'light'){
                jQuery('#style_color-header-1').attr("href", "assets/css/themes/headers/header1-" + color + ".css");
                jQuery('#logo-header').attr("src", "assets/img/logo1-" + color + ".png");
                jQuery('#logo-footer').attr("src", "assets/img/logo2-" + color + ".png");
            } else if(data_header == 'dark'){
                jQuery('#style_color-header-2').attr("href", "assets/css/themes/headers/header2-" + color + ".css");
                jQuery('#logo-header').attr("src", "assets/img/logo1-" + color + ".png");
                jQuery('#logo-footer').attr("src", "assets/img/logo2-" + color + ".png");
            }
        }
    }

    function handleBoxed() {
        jQuery('.boxed-layout-btn').click(function(){
            jQuery(this).addClass("active-switcher-btn");
            jQuery(".wide-layout-btn").removeClass("active-switcher-btn");
            jQuery("body").addClass("boxed-layout container");
        });
        jQuery('.wide-layout-btn').click(function(){
            jQuery(this).addClass("active-switcher-btn");
            jQuery(".boxed-layout-btn").removeClass("active-switcher-btn");
            jQuery("body").removeClass("boxed-layout container");
        });
    }
    
    function productsGridSize() {
        var $window = $(window);
        return (window.innerWidth < 400) ? 2 :
        (window.innerWidth < 600) ? 3 :
        (window.innerWidth < 800) ? 4 :
        (window.innerWidth < 900) ? 5 : 6;
    }
    function clientsGridSize() {
        var $window = $(window);
        return (window.innerWidth < 200) ? 2 :
        (window.innerWidth < 300) ? 3 :
        (window.innerWidth < 500) ? 4 :
        (window.innerWidth < 700) ? 5 :
        (window.innerWidth < 900) ? 6 : 8;
    }
    function loadProds(productsGridSize){
        page = $("#products ul.slides").children().length;
        $("#products").on('click', 'ul.flex-direction-nav li:eq(1) a', function(){
            console.log('call the ajax function to the api');
            console.log('start adding from page: ' + page);
            console.log('productsGridSize: ' + productsGridSize);
            // $.get('products/api', function(data) {
            //     list = 'create html string from data';
            //     $("#products ul.slides").append(list);
            // });
            // slider.addSlide(".step1", 1);
        });
    }
    function loadClients(clientsGridSize){
        page = $("#clients ul.slides").children().length;
        $("#clients").on('click', 'ul.flex-direction-nav li:eq(1) a', function(){
            console.log('call the ajax function to the api');
            console.log('start adding from page: ' + page);
            console.log('clientsGridSize: ' + clientsGridSize);
            // $.get('clients/api', function(data) {
            //     list = 'create html string from data';
            //     $("#clients ul.slides").append(list);
            // });
            // slider.addSlide(".step1", 1);
        });
    }
    function adjust(){
        // $('#how-to ol.flex-control-paging li a')
        // .css('height', $('#how-to ol.flex-control-paging li a').width()+"px");
    }


    return {
        init: function () {
            handleBootstrap();
            handleIEFixes();
            handleSearch();
            handleSwitcher();
            handleBoxed();
        },

        initSliders: function () {

            $('#products.flexslider').flexslider({
                animation: "slide",
                easing: "swing",
                animationLoop: true,
                itemWidth: 1,
                itemMargin: 1,
                minItems: 2,
                maxItems: productsGridSize(),
                controlNav: false,
                directionNav: true,
                move: 2,
                start: loadProds(productsGridSize())
            });
            $('#clients.flexslider').flexslider({
                animation: "slide",
                easing: "swing",
                animationLoop: true,
                itemWidth: 1,
                itemMargin: 1,
                minItems: 2,
                maxItems: clientsGridSize(),
                controlNav: false,
                directionNav: true,
                move: 2,
                start: loadClients(clientsGridSize()) //load biggest clients
            });
            
            $('#how-to.flexslider').flexslider({
                animation: "slide",
                slideshow: false,
                easing: "swing",
                animationLoop: true,
                itemWidth: 1,
                itemMargin: 1,
                minItems: 2,
                maxItems: 1,
                controlNav: true,
                directionNav: true,
                move: 2,
                start: adjust()
            });
            
            $('#testimonal_carousel').collapse({
                toggle: false
            });
        },

        initFancybox: function () {
            jQuery(".fancybox-button").fancybox({
            groupAttr: 'data-rel',
            prevEffect: 'none',
            nextEffect: 'none',
            closeBtn: true,
            helpers: {
                title: {
                    type: 'inside'
                    }
                }
            });
        },

        initBxSlider: function () {
            $('.bxslider').bxSlider({
                minSlides: 4,
                maxSlides: 4,
                slideWidth: 360,
                slideMargin: 10
            });            

            $('.bxslider1').bxSlider({
                minSlides: 3,
                maxSlides: 3,
                slideWidth: 360,
                slideMargin: 10,
            });            

            $('.bxslider2').bxSlider({
                minSlides: 2,
                maxSlides: 2,
                slideWidth: 360,
                slideMargin: 10
            });            
        },
        scrollSweet: function () {
           //smoothscroll
            $('a[href*=#]:not([href=#]):not([data-toggle])').click(function() {
                if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
                  var target = $(this.hash);
                  target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
                  if (target.length) {
                    $('html,body').animate({
                      scrollTop: target.offset().top -3
                    }, 1000);
                    return false;
                  }
                }
            }); 

            // niceScroll
            $("html").niceScroll({
                styler:"fb", 
                cursorcolor:"#00C2A9", 
                cursorwidth: '6', 
                cursorborderradius: '10px', 
                background: '#ccc', 
                spacebarenabled:false, 
                cursorborder: '', 
                zindex: '1000'
            });
        },
        richEditor: function(){
            tinymce.init({
              selector: "textarea.rich",
              height : 500,
              // inline: true,
              content_css : "/assets/css/article.css",
              // theme: 'advanced'

              // fontsize_formats: "12px 14px 20px 24px 36px",

              style_formats: [
                  { title: 'Headings', items: [
                      {title: "Header 1", format: "h1"},
                      {title: "Header 2", format: "h2"},
                      {title: "Header 3", format: "h3"},
                      {title: "Header 4", format: "h4"},
                      {title: "Header 5", format: "h5"},
                      {title: "Header 6", format: "h6"}
                  ]},
                  {title: 'Highlight', inline: 'span', styles: { color: '#ffffff', backgroundColor: '#e0e', padding: '2px 5px' } },
                  {title: '"Quote block"', format: 'blockquote'},
                  // { title: 'Red', inline: 'span', styles: { color: '#ff0000' } },
                  // { title: 'Blue', inline: 'span', styles: { color: '#0088CC' } },
                  // { title: 'Yellow', inline: 'span', styles: { color: '#fff000' } },
                  // { title: 'Green', inline: 'span', styles: { color: '#00CC00' } },
                  // { title: 'Badge', inline: 'span', styles: { display: 'inline-block', border: '1px solid', 'border-radius': '5px', padding: '2px 5px', margin: '0 2px' } },
                  // {title: "Bold", icon: "bold", format: "bold"},
                  // {title: "Italic", icon: "italic", format: "italic"},
                  // {title: "Underline", icon: "underline", format: "underline"}
                  {title: "Superscript", icon: "superscript", format: "superscript"},
                  {title: "Subscript", icon: "subscript", format: "subscript"},
                  {title: "Remove Formating", icon: "removeformat", format: "removeformat"},
              ],
              
              plugins: [
                "advlist autolink lists link charmap print anchor",
                "searchreplace wordcount visualblocks code fullscreen",
                "insertdatetime media table paste jbimages spellchecker hr"
              ],
              menu: {
                file: {title: 'File', items: 'newdocument | print'},
                edit: {title: 'Edit', items: 'undo redo | cut copy paste pastetext | selectall | searchreplace'},
                insert: {title: 'Insert', items: 'media link jbimages hr | anchor charmap  insertdatetime'}, 
                table: {title: 'Table', items: 'inserttable tableprops deletetable | cell row column'},
                code: {title: 'Code', items: 'code'},
                // code: {title: 'Code'}
              },

              toolbar: "undo redo | styleselect | bold italic underline strikethrough removeformat | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link jbimages emoticons",

              relative_urls: false,
              // auto_focus: "body"
              
            });

            $(document).on('focusin', function(e) { //fixing focus on tinymce popup input 
              if ($(e.target).closest(".mce-window").length) {
                  e.stopImmediatePropagation();
              }
            });
        },

    };


}();