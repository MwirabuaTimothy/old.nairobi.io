@extends('articles.blog')

@section('title')
{{ $article->title }}
@stop

@section('sub-content')

    <!-- article -->
	<section class="article">

	    <div class="panel">

	        <div class="panel-heading">
	          	<h2 class="title text-center"><span class="icon-sun-2"></span></h2>
	          	<h2 class="title text-center">{{ $article->title }}</h2>
	            <div class="author text-center">
                    
                    <a href="{{ route('users.show', $article->user->username) }}" class="author">{{ $article->user->name() }}</a>
	                <span class="">
	                	{{ Date::parse($article->created_at)->format('d M Y') }}
	                </span>

	                <div class="action-buttons">		     
				      @if(isAdmin())

				      	<?php 
				      	$class = $article->highlighted ? 'yellow' : 'white';
				      	$title = $article->highlighted ? 'Highlighted' : 'Not Highlighted';
				      	?>
				        {{ link_to_route('blog.highlight', $title, array($article->id), 
				          array('class' => 'btn '.$class)) }}

				      	<?php 
				      	$class = $article->top_story ? 'blue' : 'white';
				      	$title = $article->top_story ? 'Top Story' : 'Not Top Story';
				      	?>
				        {{ link_to_route('blog.top', $title, array($article->id), 
				          array('class' => 'btn '.$class)) }}

				      @endif

				      @if(!$article->public)
				        <span class='btn btn-danger btn-sm'>Unlisted!</span>
				      @endif

				      @if(canEdit($article))
				        {{ link_to_route('blog.edit', 'Edit', array($article->slug), 
				          array('class' => 'btn white')) }}
				      @endif
				    </div>

	            </div>
	        </div>

	        <div class="panel-body">

	            <div class="body">
	                {{ $article->body }}
	            </div>
				
				<hr/>

          		<div class="tagz">
	          		@foreach($article->tags as $tagg)
	                <a href="{{ route('tags.show', $tagg->slug) }}"><span class="tag badge">{{ $tagg->name }}</span></a>
	               	@endforeach
	                <!-- <a href="/blog/write"><span class="tag badge write icon-pencil">Write</span></a> -->
          		</div>
	          	
		         <div class="sharer">
					<?php 
					$url = Request::url();
					$title = trim(preg_replace('/\s\s+/', ' ', $article->title));
					$stars = $article->starsCount();
					?>

					@if(isset($auth))
						@if($auth->starred($article))
					    <a href="{{ route('blog.unstar', $article->slug) }}" title="UnStar Article">
					        <div class="star starred"><i class="icon-star"></i> {{ $stars }}</div>
					    </a>
					    @else
					    <a href="{{ route('blog.star', $article->slug) }}" title="Star Article">
					        <div class="star"><i class="icon-star"></i> {{
					         $stars }}</div>
					    </a>
					    @endif
				    @else
				    <a href="#signin" data-toggle="modal" title="UnStar Article">
				        <div class="star starred"><i class="icon-star"></i> {{ $stars }}</div>
				    </a>
				    @endif

				    <a href="javaScript:void(0);" title="Share on Facebook" onclick="social_popup('fb', '{{ $url }}', '{{ $title }}');">
				        <div class="facebook"><i class="icon-facebook"></i> Share </div>
				    </a>
				    <a href="javaScript:void(0);" title="Share on Twitter" onclick="social_popup('tw', '{{ $url }}', '{{ $title }}');">
				        <div class="twitter"><i class="icon-twitter"></i> Tweet</div>
				    </a>
				    <a href="javaScript:void(0);" title="Share on Google Plus" onclick="social_popup('g+', '{{ $url }}', '{{ $title }}');">
				        <div class="gplus"><i class="icon-gplus"></i> Plus </div>
				    </a>
				    <a href="javaScript:void(0);" title="Share on Linkedin" onclick="social_popup('ln', '{{ $url }}', '{{ $title }}');">
				        <div class="linkedin"><i class="icon-linkedin"></i> Linkedin</div>
				    </a>
	          	</div>


	        </div>
	      
	    </div>
	    <!--tab nav start--> 
	                   
	</section>
	<!-- page end-->
	
	<!-- disqus -->
		<div id="disqus_thread"></div>

		<script>
		/**
		* RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
		* LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables
		*/
		/*
		var disqus_config = function () {
		this.page.url = PAGE_URL; // Replace PAGE_URL with your page's canonical URL variable
		this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
		};
		*/
		(function() { // DON'T EDIT BELOW THIS LINE
		var d = document, s = d.createElement('script');

		// s.src = '//nairobiio.disqus.com/embed.js';
		s.src = '//thedevslocalhost.disqus.com/embed.js';

		s.setAttribute('data-timestamp', +new Date());
		(d.head || d.body).appendChild(s);
		})();
		</script>
		<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript" rel="nofollow">comments powered by Disqus.</a></noscript>

    <!-- /disqus -->

@stop


@section('css')
@parent
	<style>
		span.badge {
			font-size: 16px;
		}
		/* .sharer */
		.sharer {
			text-align: center;
			padding-top: 20px;
		}
		.sharer a {
			color: #fff;
    		line-height: 21px;
    		display: inline-block;
    	}
		.sharer a div {
			color: #fff;
			float: left;
			padding: 7px 20px;
			border-radius: 2px;
			margin-right: 4px;
			display: inline-block;
		}
		.sharer a div.star {
			background: #1AC8B2;
    		color: #fff;
		}
		.sharer a div.star:hover {
			/*border: 1px solid;*/
		}
		.sharer a div.star.starred {
			background: #fff;
    		color: #1AC8B2;
		}
		.sharer a div.facebook {
			background: #2d609b;
		}
		.sharer a div.twitter {
		    background: #00c3f3;
		}
		.sharer a div.gplus {
		    background: #d34836;
		}
		.sharer a div.linkedin {
		    background: #007bb5;
		}

	</style>

	{{ HTML::style('assets/css/grid-animations.css') }}
	{{ HTML::style('assets/css/article.css') }}

@stop

@section('js')
@parent

    <script type="text/javascript">
		function social_popup(mode, url, text) {
			url = encodeURIComponent(url);
			switch (mode) {
				case 'fb':
				url = 'http://www.facebook.com/sharer/sharer.php?u=' + url;
				break;
				case 'g+':
				url = 'https://plus.google.com/share?url=' + url;
				break;
				case 'tw':
				url = 'https://twitter.com/share?url=' + url + '&text=' + text + '&via=nairobiio';
				break;
				case 'ln':
				url = 'http://www.linkedin.com/shareArticle?mini=true&url=' + url;
				break;
			}
			window.open(url, 'facebook_share', 'height=320, width=640, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, directories=no, status=no');
		}
		// function starArticle(article_id, user_id) {

		// }
    </script>

    <script id="dsq-count-scr" src="//nairobiio.disqus.com/count.js" async></script>

@stop