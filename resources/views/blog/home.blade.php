@extends('blog.blog')

@section('title')
  @parent
  	| Blog
@stop

@section('sub-content')

    @include('includes.tags')
	    
    <!-- latest -->
    <div class="col-md-5">

		<h2 class="title text-right">LATEST</h1>

	    <div class="grid">

	        <!-- @ if ($blogs->count()) -->
	        @if (isset($blogs) && count($blogs))

	        @foreach($blogs as $blog)
	        <li id="{{ $blog->id }}">
                <div>
	                <div class="image col-sm-4">
	                    <a href="{{ route('blog.show', $blog->slug) }}" class="lazy">
	                        <!-- data-original="{{ $blog->image }}"  -->
	                        <!-- <img src="{{ $blog->image }}"  -->
	                        <!-- <img src="/assets/img/nyayo.jpg"  -->
	                        <img src="/assets/img/nai.jpg" 
	                        alt="" class="lazy" height="100%" width="300" >
	                    </a>
	                </div>
	                <div class="title col-sm-8">
	                    <a href="{{ route('blog.show', $blog->slug) }}" class="read_more">{{ $blog->title }}</a>
		                <br>
		                <?php $d = Date::parse($blog->created_at); ?>
		                <div class="author">
		                    By <a href="{{ route('users.show', $blog->user->username) }}">{{ $blog->user->name() }}</a> 
		                    <span class="updated_at">{{ $d->format('d M Y') }}</span>
		                </div>

		                <div class="tagz">
		                  @foreach($blog->tags as $tagg)
		                  <a href="{{ route('tags.show', $tagg->slug) }}"><span class="badge">{{ $tagg->name }}</span></a>
		                  @endforeach
		                  <span class="stars"><i class="icon icon-star"></i>{{ $blog->starsCount() }}</span>
		                </div>
	                </div>
	            </div>
	        </li>
	        @endforeach


	        @else
	          There are no posts.
	        @endif

	    </div>
    
    </div>
	<!-- /LATEST -->

    <!-- trending -->
    <div class="col-md-5">

		<h2 class="title text-right">TRENDING</h1>
 		
 		<div class="grid">

	        @if (isset($blogs) && count($blogs))
	        
	        <?php
			    $trending = Article::select(DB::raw('blogs.*, count(*) as `aggregate`'))
				    ->join('stars', 'blogs.id', '=', 'stars.blog_id')
				    ->groupBy('blog_id')
				    ->orderBy('aggregate', 'desc')->paginate(10);
		    ?>

	        @foreach($trending as $blog)
	        <li class="block-{{ rand(1,3) }}" id="{{ $blog->id }}">
                <div>
	                <div class="image col-sm-4">
	                    <a href="{{ route('blog.show', $blog->slug) }}" class="lazy">
	                        <!-- data-original="{{ $blog->image }}"  -->
	                        <!-- <img src="{{ $blog->image }}"  -->
	                        <!-- <img src="/assets/img/nyayo.jpg"  -->
	                        <img src="/assets/img/nai.jpg" 
	                        alt="" class="lazy" height="100%" width="300" >
	                    </a>
	                </div>
	                <div class="title col-sm-8">
	                    <a href="{{ route('blog.show', $blog->slug) }}" class="read_more">{{ $blog->title }}</a>
		                <br>
		                <?php $d = Date::parse($blog->created_at); ?>
		                <div class="author">
		                    By <a href="{{ route('users.show', $blog->user->username) }}">{{ $blog->user->name() }}</a> 
		                    <span class="updated_at">{{ $d->format('d M Y') }}</span>
		                </div>

		                <div class="tagz">
		                  @foreach($blog->tags as $tagg)
		                  <a href="{{ route('tags.show', $tagg->slug) }}"><span class="badge">{{ $tagg->name }}</span></a>
		                  @endforeach
		                  <span class="stars"><i class="icon icon-star"></i>{{ $blog->starsCount() }}</span>
		                </div>
	                </div>
	            </div>
	        </li>
	        @endforeach


	        @else
	          There are no posts.
	        @endif

	    </div>
	</div>
    <!-- /trending -->

    @if (isset($blogs) && count($blogs))
    <div id="pagination">
      {{ $blogs->links() }}
    </div>
    @endif


@stop


@section('css')
@parent
	{{ Html::style('assets/css/grid-animations.css') }}

	<style type="text/css">
		.blog {
			padding-top: 150px;
		}
	</style>
@stop

@section('js')
@parent
@stop