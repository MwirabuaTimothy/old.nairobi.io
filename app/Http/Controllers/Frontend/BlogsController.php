<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Request;

use App\Http\Requests;
use App\Blog;

class BlogsController extends Controller
{
    
	protected $blog;

	public function __construct(Blog $blog)
	{
	    // parent::__construct();
	    $this->blog = $blog;
	    $this->middleware('auth', ['only' =>
	    	['listing', 'create', 'store', 'edit', 'update', 'destroy', 'restore', 'star', 'unstar']
	    ]);
	    $this->middleware('admin', ['only' =>['highlight']]);
	}

	/**
	 * Display all of blogs on grid
	 *
	 * @return Response
	 */
	public function index()
	{
		$blogs = $this->blog->where(['public'=>1])->orderBy('created_at', 'desc')->paginate(10);
		$tags = Tag::paginate(50);
		// return $blogs;

		$title = 'All Blogs';
		// return compact('title', 'blogs', 'tags');
		return view('blogs.home', compact('title', 'blogs', 'tags'));
	}

	/**
	 * listing of blogs for admin
	 *
	 * @return Response
	 */
	public function listing()
	{
		$blogs = $this->blog->latest()->withTrashed()->paginate(20);

		$title = 'All Blogs';
		return view('blogs.list', compact('title'), compact('blogs'));
	}

	/**
	 * Show the form for creating a new blog
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('blogs.create');
	}

	/**
	 * Store a newly created blog in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$input['public'] = !isset($input['public']) ? 1 : $input['public']; //autoshow posts

		$validator = Validator::make($input, Blog::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$input['user_id'] = $this->auth->id;

		if(isset($input['tags'])){ // save tags
			$tags = [];
			foreach ($input['tags'] as $key => $name) {
				if($tag = Tag::where('name', $name)->first()){
					$tags[] = $tag;
				}
				else{
					$tags[] = Tag::create(['name'=>$name, 'creator'=>$this->auth->id]);
				}
			}
			unset($input['tags']);
			$blog = Blog::create($input); // create blog
			$blog->tags()->saveMany($tags);
		}
		else{
			$blog = $this->blog->create($input);
		}

		$blog['image'] = $this->auth->image;

		/*
		* send gcm alerts:
		*/
		function gcm(){
			$auth = $this->auth;

			// new algorithm	
			$follower_ids = $auth->followers()->lists('user_id');
			// return $follower_ids;

			$followers = User::whereIn('id', $follower_ids)->get();
			// return $followers;
			
			$reg_ids = [];
			
			foreach ($followers as $usr) {
				$reg_ids[] = $usr->gcm;
			}

			// $reg_ids = User::lists('gcm'); // pushing to all devices
			$reg_ids = array_values(array_unique($reg_ids));
			
			if(count($reg_ids)){
				$res = $blog->gcm($reg_ids); //gcm push!
			}
		}


		return Redirect::route('blog.show', $blog->slug);

	}

	/**
	 * Display the specified blog.
	 *
	 * @param  string $slug
	 * @return Response
	 */
	public function show($slug)
	{
		$blog = $this->blog->whereSlug($slug)->firstOrFail();

		return $this->display($blog);
	}

	/**
	 * Display the specified blog.
	 *
	 * @param  model $blog
	 * @return Response
	 */
	public function display($blog)
	{
		if(in_array('api', Request::segments())){
			return $blog;
		}
		return view('blogs.show', compact('blog'));
	}

	/**
	 * Show the form for editing the specified blog.
	 *
	 * @param  string $slug
	 * @return Response
	 */
	public function edit($slug)
	{
		$blog = $this->blog->findBySlug($slug);

		return view('blogs.edit', compact('blog'));

	}

	/**
	 * Update the specified blog in storage.
	 *
	 * @param  string $slug
	 * @return Response
	 */
	public function update($slug)
	{
		$input = Input::all();
		// return $input;

		$validator = Validator::make($input, Blog::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}
		
		$blog = $this->blog->findBySlug($slug);

		$blog->tags()->detach();

		if(isset($input['tags'])){
			$tags = [];
			foreach ($input['tags'] as $key => $name) {
				if($tag = Tag::where('name', $name)->first()){
					$tags[] = $tag;
				}
				else{
					$tags[] = Tag::create(['name'=>$name, 'creator'=>$this->auth->id]);
				}
			}
			unset($input['tags']);
			$blog->update($input);
			$blog->tags()->saveMany($tags);
		}
		else{
			$blog->update($input);
		}

		return view('blogs.show', compact('blog'));
	}

	/**
	 * Trash the specified blog
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$blog = $this->blog->withTrashed()->findOrFail($id);
		$blog->delete();
		return Redirect::back()->with('success', 'Deleted blog '.$id.' successfully');
		// return Redirect::route('admin.blogs')->with('success', 'Deleted blog '.$id.' successfully');
	}

	/**
	 * Return the specified blog to view
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function restore($id)
	{
		$blog = $this->blog->withTrashed()->findOrFail($id);
		$blog->restore();
		return Redirect::back()->with('success', 'Restored blog '.$id.' successfully');
		// return Redirect::route('admin.blogs')->with('success', 'Restored blog '.$id.' successfully');
	}
	
	public function highlight($id){
		if(!isAdmin()):
			return Redirect::back()->with(['error' => 'Admin only feature!']);
			// return ['error' => 'Admin only feature'];
		endif;

		$blog = $this->blog->findOrFail($id);
		if($blog->highlighted):
			$blog->highlighted = false;
			$blog->save();
			$msg = "removed from";
		else:
			$blog->highlighted = true;
			$blog->save();
			$msg = "added to";
		endif;
		return Redirect::back()->with(['success' => 'Blog has been '.$msg.' this week\'s highlights!']);
		// return ['success' => $blog->highlighted];
	}
	public function highlights(){

		$blogs = $this->blog->where(['highlighted'=>1, 'public'=>1])->orderBy('created_at', 'desc')->paginate(20);
		if(in_array('api', Request::segments())) { //its from api
			return $blogs;
		}
		$title = 'This Week\'s Highlights';
		$mapped = 1;

		return view('blogs.home', compact(['title', 'blogs', 'mapped']));
	}
	public function top($id){
		if(!isAdmin()):
			return Redirect::back()->with(['error' => 'Admin only feature!']);
		endif;

		$blogs = $this->blog->withTrashed()->where(['top_story'=>1])->get();
		foreach ($blogs as $blog) {
			$blog->top_story = false;
			$blog->save();
		}
		$blog = $this->blog->findOrFail($id);
		if($blog->top_story):
			$blog->top_story = false;
			$blog->save();
			$msg = "is not";
		else:
			$blog->top_story = true;
			$blog->save();
			$msg = "is now";
		endif;
		return Redirect::back()->with(['success' => 'Blog '.$msg.' the current Top Story!']);
		// return ['success' => $blog->top_story];
	}
	public function topStory(){

		$blog = $this->blog->where(['top_story'=>1, 'public'=>1])->first();
		if(in_array('api', Request::segments())) { //its from api
			return $blog;
		}
		return view('blogs.show', compact('blog'));
	}
	public function star($slug){

		$blog = $this->blog->whereSlug($slug)->firstOrFail();

		Star::create(['blog_id'=> $blog->id, 'user_id'=> $this->auth->id]);
		
		return success('You have starred this blog!', route('blog.show', $slug), $blog);
	}
	public function unstar($slug){

		$blog = $this->blog->whereSlug($slug)->firstOrFail();

		$blog->stars()->where(['user_id' =>$this->auth->id])->delete();
		
		return success('You have unstarred this blog!', route('blog.show', $slug), $blog);
	}

	public function emptySearch(){
		return Redirect::to('blog'); // default press
	}
	public function search(){

		$query = Input::get('query');
		
		if($query == 'Search Blog...') return Redirect::to('blog'); // default press

		$query = str_replace('%20', '_', $query); // replace space with underscores
		$query = str_replace(' ', '_', rawurldecode($query)); // replace space with underscores

		return Redirect::route('blog.search.get', compact('query'));
		// return $this->getSearch($query);
	}

	public function getSearch($query){

		$query = str_replace('_', ' ', $query);

		$blogs = $this->blog
			->where('title', 'like', '%'.$query.'%')
			->orWhere('body', 'like', '%'.$query.'%')
			->orderBy('created_at', 'desc')
			->paginate(10);

		$tags = Tag::paginate(50);
		// return $blogs;

		$title = 'Searched: '.$query;
		return view('blogs.index', compact('title', 'blogs', 'tags', 'query'));
	}
}
