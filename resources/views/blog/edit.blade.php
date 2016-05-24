@extends('articles.blog')

@section('title')
	@parent
	 | Editing Article
@stop

@section('sub-content')

    <!-- article -->
	<section class="article">

	    <div class="panel">
			
			{{ Form::model($article, array('method' => 'PATCH', 'route' => array('blog.update', $article->slug), 'files' => true, 'enctype' => 'multipart/form-data')) }}

	        <div class="panel-heading">
	          	<h2 class="title text-center"><span class="icon-sun-2"></span></h2>

	          	{{ $errors->first('title', '<span class="help-block">:message</span>') }}
				{{ Form::text('title', $article->title, array('class' => 'form-control text-center title')) }}

	            <div class="author text-center">
                    
                    <a href="{{ route('users.show', $article->user->username) }}" class="author">{{ $article->user->name() }}</a>
	                <span class="">
	                	{{ Date::parse($article->created_at)->format('d M Y') }}
	                </span>
	            </div>
	        </div>

			<div class="panel-body">

				@if(isAdmin())
				<span class="pull-right">
					{{-- All::getDeleteLink($article) --}}

					{{ Form::select('public', array('1' => 'Public', '0' => 'Not Public',), 
					Input::old('public', $article->public), 
					array('class'=>'btn btn-sm green', 'id'=>'public')) }}
				</span>
				@endif
				

				{{ $errors->first('body', '<span class="help-block">:message</span>') }}
				{{ Form::label('body', 'Body', array('class' => 'control-label')) }}
				{{ Form::textarea('body', $article->body, array('rows' => '30', 
				'class' => 'form-control rich')) }}

				{{ $errors->first('tags[]', '<span class="help-block">:message</span>') }}
				{{ Form::label('tags', 'Tags', array('class' => 'control-label')) }}
				{{ Form::select('tags[]', $article->tagz(), $article->tagz(), 
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
        	$(".s2").select2({
        		tags: true,
        		maximumSelectionLength: 5,
        		tokenSeparators: [',', ' ']
        	});
        	App.richEditor();
        });
    </script>
@stop
