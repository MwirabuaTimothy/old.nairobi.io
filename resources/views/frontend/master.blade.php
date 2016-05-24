<!DOCTYPE html>
<!--[if lte IE 8]>               <html class="ie8 no-js" lang="en">    <![endif]-->
<!--[if lte IE 10]>              <html class="ie10 no-js" lang="en">   <![endif]-->
<!--[if !IE]>-->                 <html class="not-ie no-js" lang="en"> <!--<![endif]-->
<head>

<head>
    <title>
        @section('title')
           Nairobi IO
        @show
    </title>

    <!-- Google Web Fonts
    ================================================== -->
    <link href='http://fonts.googleapis.com/css?family=Roboto:100,300,300italic,400,700|Julius+Sans+One|Roboto+Condensed:300,400' rel='stylesheet' type='text/css'>

    <!-- Meta -->
    <!-- Basic Page Needs
    ================================================== -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Favicons
    ================================================== -->
    <link rel="shortcut icon" href="/assets/img/favicon.png">

    <!-- Mobile Specific Metas
    ================================================== -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    
    <!-- CSS
    ================================================== -->
    {{ Html::style('assets/css/style.css') }}
    {{ Html::style('assets/css/grid.css') }}
    {{ Html::style('assets/css/layout.css') }}
    {{ Html::style('assets/css/fontello.css') }}
    {{ Html::style('assets/css/animation.css') }}
    
    {{ Html::style('assets/plugins/layerslider/css/layerslider.css') }}
    {{ Html::style('assets/plugins/flexslider/flexslider.css') }}
    
    @yield('css')

    <!-- Html5 Shiv
    ================================================== -->
    {{ Html::script('assets/plugins/jquery.modernizr.js') }}

</head> 
<body data-spy="scroll" data-target="#navigation" class="home">

    <!-- Facebook like box -->
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=525227957610582&version=v2.0";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

   


    <!-- - - - - - - - - - - - - - Wrapper - - - - - - - - - - - - - - - - -->

    <div id="wrapper">
        @include('includes.header')
        @yield('content')
    </div><!--/ #wrapper-->

    <!-- - - - - - - - - - - - - end Wrapper - - - - - - - - - - - - - - - -->

    @include('includes.footer')

    <!-- backtotop -->
    <div class="backtotop">
        <a href="#welcome" class="scroll">
            <span></span>
        </a>
    </div>
    <a href="#" id="back-top" title="Back To Top"></a>
    <!-- /backtotop -->

    <!-- JS Global Compulsory -->     
    {{ Html::script('assets/plugins/jquery.min.js') }}
    {{ Html::script('assets/plugins/jquery-ui.js') }}
    {{ Html::script('assets/plugins/bootstrap/js/bootstrap.min.js') }}
   
    <!-- new flame -->
    {{ Html::script('assets/plugins/flexslider/jquery.flexslider.js') }}
    {{ Html::script('assets/plugins/jquery.nicescroll.js') }}

    <!-- JS Page Level -->           
    {{ Html::script('assets/js/app.js') }}
    {{ Html::script('assets/js/pages/index.js') }}
    {{ Html::script('assets/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js') }}
    {{ Html::script('assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}


    @yield('js')


    <script type="text/javascript">
        jQuery(document).ready(function() {
            App.init();
            App.initSliders();
            App.scrollSweet();
            
         /* Vector Map */
        // var jvm_wm = new jvm.WorldMap({container: $('#africa'),
        $('#africa').vectorMap({
            map: 'world_mill_en', 
            backgroundColor: 'rgba(255, 255, 255, 0)',                                      
            regionsSelectable: true,
            regionStyle: {selected: {fill: '#B64645'},
                            initial: {fill: '#ddd'}},

            markerStyle: {initial: {fill: '#00c2a9',
                           stroke: '#00c2a9'}},
            // markers: [{latLng: [51.51, -0.13], name: 'London'},
            //           {latLng: [40.71, -74.00], name: 'New York'},
            //           {latLng: [-1.2833, 36.8167], name: 'Nairobi'}],
            markers: [{latLng: [-1.2833, 36.8167], name: 'Nairobi City'}],
            selectedRegions: ["KE"],
            focusOn: {
                  x: 0.52,
                  y: 0.65,
                  scale: 4
                },
            zoomOnScroll: false,
            zoomMax: 20,
            hoverColor: '#o9baff',
        });    

        /* END Vector Map */

        });
    </script>

    <!-- toastr stuff -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">
    <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}" type="text/javascript"></script>
    @include('includes.toastr')
    <!--[if lt IE 9]>
        <script src="assets/plugins/respond.js"></script>
    <![endif]-->
</body>

<!-- Common JS Libs -->

</html>
