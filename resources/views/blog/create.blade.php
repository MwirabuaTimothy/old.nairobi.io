@extends('articles.blog')

@section('title')
	@parent
	| Create An Article
@stop

@section('sub-content')

	<section class="article">

		<div class="panel">

			{{ Form::open(array('route' => 'blog.store', 'files' => true, 'enctype' => 'multipart/form-data')) }}

			<div class="panel-heading">
	          	<h2 class="title text-center"><span class="icon-sun-2"></span></h2>

	          	{{ $errors->first('title', '<span class="help-block">:message</span>') }}
				{{ Form::text('title', null, array('class' => 'form-control text-center title')) }}

	            <div class="author text-center">
                    
                    <a href="{{ route('users.show', $auth->username) }}" class="author">{{ $auth->name() }}</a>
	                <span class="">
	                	{{ (new Date)->format('d M Y') }}
	                </span>
	            </div>
	        </div>

			<div class="panel-body">

				@if(isAdmin())
				<span class="pull-right">
					{{ Form::select('public', array('1' => 'Public', '0' => 'Not Public',), null, 
					array('class'=>'btn btn-sm green', 'id'=>'public')) }}
				</span>
				@endif

				{{ $errors->first('body', '<span class="help-block">:message</span>') }}
				{{ Form::label('body', 'Body:', array('class' => 'control-label')) }}
				{{ Form::textarea('body', null, array('rows' => '10', 'class' => 'form-control rich')) }}

				{{ $errors->first('tags[]', '<span class="help-block">:message</span>') }}
				{{ Form::label('tags', 'Add tags:', array('class' => 'control-label')) }}
				{{ Form::select('tags[]', [], null,
				array('class' => 'form-control s2', 'multiple'=>'multiple')) }}

				<button class="submit" type="submit" id="submit">
					<i class="icon-paper-plane-2"></i>
					SUBMIT
				</button>
			</div>

			{{ Form::close() }}

		</div>
	</section>

@stop
@section('css')
	@parent
	{{ HTML::style('assets/plugins/select2/select2.min.css') }}
	{{ HTML::style('assets/css/editor.css') }}
@stop

@section('js')
	@parent

	{{ HTML::script('assets/plugins/select2/select2.full.js') }}
	{{ HTML::script('assets/plugins/tinymce/tinymce.min.js') }}

	<script type="text/javascript">
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
			$(".s2").select2({
				tags: true,
				maximumSelectionLength: 5,
				tokenSeparators: [',', ' ']
			});
			App.richEditor();
		});
	</script>
@stop



