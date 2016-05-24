@extends('articles.blog')

@section('title')
  @parent {{ $title }}
@stop

@section('sub-content')

<section class="article">

	<h3>
		{{ $title }}
		<div class="pull-right">
			<a href="{{ route('blog.create') }}" class="btn btn-sm btn-info"><i class="fa fa-plus-sign icon-white"></i> Create</a>
		</div>
	</h3>

	<div class="pull-right">
		{{ $articles->links() }}
	</div>

	<!-- @ if(isAdmin()) -->
	<!-- <a class="btn btn-medium" href="{{ URL::to('admin/articles?withTrashed=true') }}">Include Deleted Articles</a> -->
	<!-- <a class="btn btn-medium" href="{{ URL::to('admin/articles?onlyTrashed=true') }}">Show Only Deleted</a> -->
	<!-- @ endif -->

	<table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered  admin">
		<thead>
			<tr>
				<th class="col-xs-1">id</th>
				<th class="col-xs-3">title</th>
				<th class="col-xs-2">author</th>
				<th class="col-xs-3">tags</th>
				<th class="col-xs-1">public</th>
				<th class="col-xs-2">actions</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($articles as $article)
			<tr>
				<td>{{ $article->id }}</td>
				<td>{{ link_to_route('blog.show', $article->slug, array($article->slug)) }}</td>
				<td>{{ isset($article->user) ? $article->user->name : '-' }}</td>
				<td>{{ implode($article->tagz(), ', ') }}</td>
				<td>{{ $article->public ? 'yes' : 'no' }}</td>
				<!-- <td>{{ $article->created_at->diffForHumans() }}</td> -->
				<td>
	        
		        @if(canEdit($article))
		        
		          {{ link_to_route('blog.edit', 'Edit', array($article->slug), 
		          array('class' => 'btn btn-info btn-sm')) }}

		          @if ( $article->deleted_at >= "0000-00-00 00:00:00")
		            <a href="{{ route('admin.restore.article', $article->id) }}" class="btn btn-sm btn-warning">restore</a>
		          @else
		            <a href="{{ route('admin.delete.article', $article->id) }}" class="btn btn-sm btn-danger">delete</a>
		          @endif
	          
				@endif
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>

</section>

@stop

@section('css')
@parent
	<style type="text/css" media="screen">

		th {
			float: none !important;
		}
		
	</style>

@stop

@section('js')

  <!-- advanced datatables -->
  {{ HTML::script('assets/plugins/advanced-datatable/media/js/jquery.dataTables.js') }}

  <script>

    // Initialse DataTables
	$('table.admin').dataTable( {
	    "aoColumnDefs": [
	        { "bSortable": false, "aTargets": [ 0 ] }
	    ],
	    "aaSorting": [[0, 'desc']],
	    "bPaginate": false,
	    "bInfo":   false,
	});

  </script>

@stop
