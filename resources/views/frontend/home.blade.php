@extends('frontend.master')


@section('content')

    @include('includes.about')

    @include('includes.description')

    @include('includes.details')

    @include('includes.folio')

    <!-- @ include('includes.partners') -->

    <!-- @ include('includes.testimonials') -->

    <!-- @ include('includes.team') -->

@stop


@section('css')

    <link href="assets/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet" />
    <link href="assets/plugins/jvectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet" />

@stop

@section('js')
    <!--[if lt IE 9]>
    <script src="js/respond.min.js"></script>
    <![endif]-->
    {{ Html::script('assets/plugins/jquery.queryloader2.js') }}
    {{ Html::script('assets/plugins/waypoints.min.js') }}
    {{ Html::script('assets/plugins/jquery.easing.1.3.min.js') }}
    {{ Html::script('assets/plugins/jquery.cycle.all.min.js') }}
    {{ Html::script('assets/plugins/layerslider/js/layerslider.transitions.js') }}
    {{ Html::script('assets/plugins/layerslider/js/layerslider.kreaturamedia.jquery.js') }}
    {{ Html::script('assets/plugins/jquery.mixitup.js') }}
    {{ Html::script('assets/plugins/jquery.mb.YTPlayer.js') }}
    {{ Html::script('assets/plugins/jquery.smoothscroll.js') }}
    {{ Html::script('assets/plugins/flexslider/jquery.flexslider.js') }}
    {{ Html::script('assets/plugins/jquery.touchswipe.min.js') }}
    {{ Html::script('assets/plugins/fancybox/source/jquery.fancybox.pack.js') }}

    {{ Html::script('assets/js/config.js') }}
    {{ Html::script('assets/js/custom.js') }}
    <script>
    $(document).ready(function(){

        // var done = false;
        // $(window).scroll(function() {
        //     if (done != true) {
        //         var scroll = $(window).scrollTop();
        //         if (scroll >= 500) {
        //             $('#about img').each(function(i, el){
        //                 console.log(el);
        //                 $(el).addClass('viewing')
        //                 setTimeout(function(){
        //                 }, 200)
        //                     $(el).removeClass('viewing')
        //                     $(el).addClass('viewed')
        //             })
        //             done = true;
        //         }
        //     }
        // });


        adjustSize = function() {
            var w = $(window).width()
            if(w < 650){
                var r =  w/650;
                var r2 =  (w+100)/650;
                $('#about img').each(function(i, el){
                    // console.log(w);
                    $(el).css('zoom', r)
                })
                $('#about .devices').css('height', r*500 + 'px')
                $('#about .explain').css('line-height', r*2 + 'em')
                $('#about .explain .title').css('font-size', r2*2 + 'em')
                $('#about .explain .subtitle').css('font-size', r2*1.8 + 'em')
                $('#about .explain .description').css('font-size', r2*1.5 + 'em')
                $('#footer .logo-in-footer h1 a').css('font-size', r2*0.8 + 'em')
            }

        }
        adjustSize();
        $(window).resize(function() {
           adjustSize()
        })

        //fancybox
        $(".fancybox").fancybox();



        //smoothscroll
        smoothScroll = function(url) {
            hash = hash.indexOf("#") == -1 ? "#" + hash : hash
            var target = $(hash); //target element by referenced id
            
            if (hash) {
                // console.log(hash);
                // console.log('ul.sub li a[href="'+currentPage+hash+'"]')
                var activeLi = $('ul.sub li a[href="' + dashboard + currentPage + hash + '"]')[0].parentNode;

                activeLi.classList.add('active');

                setTimeout(function() {
                    document.location.hash = hash;
                }, 1000);

                target = $(hash);
                if (target[0]) {
                    $('html,body').animate({
                        scrollTop: target.offset().top - 80
                    }, 1000);
                }

            }
        }

        //scroll to the hash after loading page
        $('a[href*=#]:not([href="#"])').on('click', function(e) { //watch all scroll links
            e.preventDefault();
            hash = $(e.target).attr('href');
            offset = $('header#header').height()
            
            target = $(hash);
            offset2 = target.offset().top - offset;
            
            if (target[0]) {
                setTimeout(function(){
                    $('html,body').animate({
                        scrollTop: offset2
                    }, 500);
                }, 500)
            }
            // return false;

        })

    })

    </script>
@stop
