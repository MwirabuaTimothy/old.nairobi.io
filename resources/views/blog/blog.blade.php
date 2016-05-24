@extends('frontend.master')

@section('content')
			
	<div class="blog">

		@yield('sub-content')
		

		@include('partials.modals')

	</div> <!-- /.blog -->

@stop


@section('css')
@parent

{{-- Html::style('assets/css/editor.css') --}}

	<style>
		#header.transparent {
			background-color: #1ac8b2;
		    /*border-bottom: 20px solid #3F8A81;*/
			padding: 0;
			min-width: 40%;
		}
		#header .header-in {
		    height: 155px;
		    /*background-image: url('/assets/img/sil.png');
		    background-size: auto 100%;
		    background-position: 100% 5px;
			background-repeat: no-repeat;*/
		}
		#header img.nai {
			display: block !important;
			position: absolute;
			right: 5%;
			bottom: 0;
			max-width: 90%;
			max-height: 100%;
			z-index: -1;
		}
		#header a#blog {
			text-decoration: underline;
		}
		.navigation > ul {
			display: none;
		}
		form.search {
			display: block;
			margin-top: 10px;
			color: #fff;
		}
		form.search .icon {
			position: absolute;
			font-size: 20px;
			font-weight: lighter;
			padding: 10px 8px;
			color: #fff;
			line-height: 25px;
			margin: 0px;
		}

		form.search .icon.icon-pencil {
		    margin-left: -43px;
		}
		form.search input, 
		form.search input:focus {
			/*border: 1px solid #fff;*/
    		border: 0.5px solid rgb(85, 227, 209);
			font-size: 20px;
			padding: 10px 0px;
			padding-left: 42px;
		    color: inherit;
    		font-family: sans-serif;
		}
		
		/* search input placeholder color */
		/* do not group these rules */
		form.search input::-webkit-input-placeholder {
		    color: inherit;
		}
		form.search input:-moz-placeholder {
		    /* FF 4-18 */
		    color: inherit;
		}
		form.search input::-moz-placeholder {
		    /* FF 19+ */
		    color: inherit;
		}
		form.search input:-ms-input-placeholder {
		    /* IE 10+ */
		    color: inherit;
		}

		/* header animation */
		#header form.search {
			/*-webkit-transition: font-size .25s ease;*/
			/*transition: font-size .25s ease;*/
		}
		#header .header-in {
			-webkit-transition: height .25s ease;
			transition: height .25s ease;
		}

		#header.header-shrink form.search {
			display: none;
		}
		#header.header-shrink .header-in {
			height: 70px;
		}
		.tagz {
			clear: both;
			display: block;
		}
		span.badge {
		    background-color: #1AC8B2;
		    padding: 1px 5px;
		    border-radius: 6px;
		    color: #fff;
    		font-size: 12px;
		}
		span.stars {
		    background-color: #fff;
		    padding: 1px 5px;
		    border-radius: 6px;
		    color: #1AC8B2;
		    font-size: 14px;
		    float: right;
		}

		.blog {
			position: relative;
			width: 100%;
			padding: 0 5%;
			background-color: rgba(0, 0, 0, 0.5);
			float: left;
			z-index: 5;
		}
		.blog > * {
			padding: 0px;
			padding-top: 20px;
		} 
		h2.title {
			font-size: 30px;
			font-weight: 300;
			color: #fff;
			font-family: 'Roboto', sans-serif;
			line-height: 1.5em;
			margin-bottom: 0px;
		}

		#footer .copyright .hide { 
			display: inline-block;
		}
		#footer .parallax .container { 
			display: none;
		}
		#footer .parallax { 
			padding: 0;
		}


.modal {
    position: fixed;
    height: 100%;
    width: 100%;
    top: 0;
    left: 0;
    padding: 0;
    background-color: rgba(255, 255, 255, 0.8);
    display: none;
}
.modal-header h4 {
	font-size: 20px;
}
.modal-header {
    cursor: move;
    padding: 10px 10px 0px 10px;
}
.modal-body {
    padding: 0px 10px 10px 10px;
}
.modal-dialog {
    top: 25%;
    border-radius: 3px;
    background:white;
    margin:auto;
    width:500px;
    position:relative;
    box-shadow: 0px 0px 10px 5px #1AC8B2;
    border-radius:3px;
}
button.close {
    position:absolute;
    right:10px;
    top:3px;
    color:#cecece;
    font-size:18px;
    text-decoration:none;
}
button.close:hover {
    color: #e55753;
    text-decoration:none;
}
.modal .oauth {
    display: flex;
    margin-bottom: 10px;
}
.modal .oauth a {
    height: 45px;
    border-radius: 5px;
}
.modal .oauth a span, 
.modal .oauth a i {
    color: white;
    font-size: 15px;
    font-weight: normal;
}
.modal .oauth a i {
    margin-right: 5px;
    font-size: 20px;
    line-height: 40px;
}
.modal .oauth a.facebook {
   margin-right: 5px;
   border-color: #344e86;
   background-color: #3b5998;
   background-color: #4264aa;
   background-image: deprecated-webkit-gradient(linear,left top,left bottom,#4264aa,#3b5998);
   background-image: -webkit-linear-gradient(top,#4264aa,#3b5998);
   background-image: -moz-linear-gradient(top,#4264aa,#3b5998);
   background-image: -ms-linear-gradient(top,#4264aa,#3b5998);
   background-image: -o-linear-gradient(top,#4264aa,#3b5998);
   background-image: linear-gradient(top,#4264aa,#3b5998);
}
.modal .oauth a.google {
   margin-left: 5px;
   border-color: #d73925;
   background-color: #dd4b39;
   background-color: #e15f4f;
   background-image: deprecated-webkit-gradient(linear,left top,left bottom,#e15f4f,#dd4b39);
   background-image: -webkit-linear-gradient(top,#e15f4f,#dd4b39);
   background-image: -moz-linear-gradient(top,#e15f4f,#dd4b39);
   background-image: -ms-linear-gradient(top,#e15f4f,#dd4b39);
   background-image: -o-linear-gradient(top,#e15f4f,#dd4b39);
   background-image: linear-gradient(top,#e15f4f,#dd4b39);
}

.modal input.form-control {
    margin-bottom: 10px;
    font-size: 20px;
    padding: 10px;
}
.modal input.button {
	line-height: 25px;
}
.modal form label {
	line-height: 40px;
	font-size: 16px;
}

#back-top {
    border: 1px solid #1AC8B2;
    opacity: 0.8;
}
#back-top:after {
    color: #1AC8B2;
}
#back-top:hover {
    opacity: 1;
}



/*new*/
		#header {
			/*position: relative;*/
		}
		section.article {
			font-weight: normal;
			font-size: 20px;
			line-height: 1.5;
			float: none;
			margin: 0 auto;
			/*max-width: 1200px;*/
			min-height: 630px;
			padding-left: 50px;
			padding-right: 50px;
			padding-top: 200px;
			padding-bottom: 80px;
		}

		@media screen and (max-width: 600px) {			
			section.article { 
	     		padding-left: 10px; 
	     		padding-right: 10px; 
			}
		}
		section.article .panel {
			max-width: 800px;
		    margin: 0 auto;
		}

		section.article .panel form {
			max-width: 800px;
		    margin: 0 auto;
		}
		section.article #sharethis {
			margin-top: 50px;
		}
		section.article .panel-heading{
			padding-bottom: 20px;
		}
		section.article .panel-body > hr {
			margin: 50px auto;
			border: none;
			border-top: 2px solid #1AC8B2;
			height: 0px;
			text-align: center;
		}
		section.article .panel-body > hr:before {
			position: relative;
			content: "";
			width: 0;
			height: 0;
			border-bottom: 8px solid #1AC8B2;
			border-left: 25px solid transparent;
			border-right: 25px solid transparent;
			z-index: 0;
			top: -35px;
			left: 25px;
		}
		section.article .panel-body > hr:after {
			position: relative;
			content: "";
			width: 0;
			height: 0;
			border-top: 8px solid #1AC8B2;
			border-left: 25px solid transparent;
			border-right: 25px solid transparent;
			z-index: 0;
			top: 4px;
			right: 25px;
		}

		section.article a {
			/*color: #E0E;*/
			/*color: #1AC8B2;*/
		}
		section.article .body a {
			text-decoration: underline;
		}
		section.article span.icon-sun-2,
		section.article h2.title, 
		section.article {
		    color: #333 !important;
		}
		section.article {
		    background-color: rgba(255, 255, 255, 0.8);
		}
		section.article.dark span.icon-sun-2,
		section.article.dark h2.title, 
		section.article.dark {
		    color: #bbb !important;
		}
		section.article.dark {
			background-color: rgba(0, 0, 0, 0.5);
		}
		section.article.black span.icon-sun-2,
		section.article.black h2.title, 
		section.article.black {
		    color: #bbb !important;
		}
		section.article.black {
		    background-color: rgb(0, 0, 0);
		}
		section.article.white span.icon-sun-2,
		section.article.white h2.title, 
		section.article.white {
		    color: #666 !important;
		}
		section.article.white {
		    background-color: rgb(255, 255, 255);
		}
		section.article .panel {
			max-width: 800px;
		    margin: 0 auto;
		}
		.blog > #disqus_thread {
			padding-top: 0px;
		} 
		.stButton .stFb, .stButton .stTwbutton, .stButton .stMainServices {
			height: auto !important;
		}


	</style>

	{{ Html::style('assets/plugins/jvectormap/jquery-jvectormap-2.0.2.css') }}

@stop

@section('js')
@parent
	{{ Html::script('assets/plugins/jquery.lazyload.min.js') }}
	<script type="text/javascript">
	
		$(".modal-dialog").draggable();

		$('a[href="#signin"]').click(function (e) {
			e.preventDefault();
			$(".modal#signup").modal('hide');
		});

		$('a[href="#signup"]').click(function (e) {
			e.preventDefault();
			$(".modal#signin").modal('hide');
		});


    	var win = $(window);
    	var header = $('#header');
    	var backTop = $('#back-top');
		win.scrollTop() > 0 ? header.addClass('header-shrink') : header.removeClass('header-shrink');
		win.scrollTop() > 200 ? backTop.fadeIn(400) : backTop.fadeOut(400);
		backTop.on('click', function (e) {
			$('html, body').animate({ scrollTop: 0 }, 800);
			e.preventDefault();
		});

		$(window).on('scroll.OnePage', function (e) {
			// Back To Top
			win.scrollTop() > 200 ? backTop.fadeIn(400) : backTop.fadeOut(400);
			// Sticky Header
			win.scrollTop() > 0 ? header.addClass('header-shrink') : header.removeClass('header-shrink');
		});

		//theme switcher...

        $(document).ready(function() {
        	var theme = ['', 'dark', 'white', 'black'];
        	var i = 0;
        	$('section.article span.icon-sun-2').click(function () {
        		i++;
        		i = i%4;


        		$('section.article')
        		.removeClass('black')
        		.removeClass('white')
        		.removeClass('dark')
        		.addClass(theme[i]);

        		var iframe = $('iframe:last');
        		$('body#tinymce', iframe.contents())
        		.removeClass('black')
        		.removeClass('white')
        		.removeClass('dark')
        		.addClass(theme[i]);

        	});
        });

	</script>
@stop