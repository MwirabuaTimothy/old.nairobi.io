    <div class="top-tags col-md-2">
    	<h2 class="title">TOP TAGS</h1>
    	<div class="tagz">
    		@foreach($tags as $tagg) <!-- not to overflow to the global $tag -->
    		<a href="{{ route('tags.show', $tagg->slug) }}"><span class="badge">{{ $tagg->name }}</span></a>
    		@endforeach
    	</div>
    </div>