		<div class="grid">

	        <!-- @ if ($articles->count()) -->
	        @if (isset($articles) && count($articles))

		        <?php $i = 0 ?>
		        @foreach($articles as $article)
		        <li class="{{ $i % 2 == 0 ? 'col-md-7' : 'col-md-5'; $i++ }}" id="{{ $article->id }}">
	                <div>
		                <div class="image col-sm-4">
		                    <a href="{{ route('blog.show', $article->slug) }}" class="lazy">
		                        <!-- data-original="{{ $article->image }}"  -->
		                        <!-- <img src="{{ $article->image }}"  -->
		                        <!-- <img src="/assets/img/nyayo.jpg"  -->
		                        <img src="/assets/img/nai.jpg" 
		                        alt="" class="lazy" height="100%" width="300" >
		                    </a>
		                </div>
		                <div class="title col-sm-8">
		                    <a href="{{ route('blog.show', $article->slug) }}" class="read_more">{{ $article->title }}</a>
			                <br>
			                <?php $d = Date::parse($article->created_at); ?>
			                <div class="author">
			                    By <a href="{{ route('users.show', $article->user->username) }}">{{ $article->user->name() }}</a> 
			                    <span class="updated_at">{{ $d->format('d M Y') }}</span>
			                </div>

			                <div class="tagz">
			                  @foreach($article->tags as $tagg)
			                  <a href="{{ route('tags.show', $tagg->slug) }}"><span class="badge">{{ $tagg->name }}</span></a>
			                  @endforeach
			                </div>
		                </div>
		            </div>
		        </li>
		        @endforeach
			    <div id="pagination">
			      {{ $articles->links() }}
			    </div>

	        @else
	          There are no articles.
	        @endif

	    </div>
