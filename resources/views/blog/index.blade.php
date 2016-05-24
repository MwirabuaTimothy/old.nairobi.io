@extends('articles.blog')

@section('title')
  @parent
   | {{ $title }}
@stop

@section('sub-content')

	@include('partials.tags')

	<!-- tagged -->
    <div class="col-md-10">

		<h2 class="title">{{ $title }}</h1>

		@include('articles.grid')

    </div>
	<!-- /tagged -->

    @if (isset($articles) && count($articles))
    <div id="pagination">
      {{ $articles->links() }}
    </div>
    @endif

@stop


@section('css')
@parent
	{{ HTML::style('assets/css/grid-animations.css') }}
	<style type="text/css">
		.blog {
			padding-top: 150px;
		}
	</style>
@stop

@section('js')
@parent
@stop