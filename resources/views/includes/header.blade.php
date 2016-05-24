  <!-- - - - - - - - - - - - - - Header - - - - - - - - - - - - - - - - --> 
  

  <header id="header" class="transparent">

    <div class="header-in clearfix">

      <div id="top-left" class="col-md-6 col-sm-12 col-xs-12">
          <h1 id="logo"><a href="{{ Request::path() == 'blog' ? route('home') : '/blog' }}">NAIROBI.IO</a></h1> 
          <br/>
          <h4 id="creed">Technology From Africa</h4>
          <form action="{{ route('blog.search') }}" method="post" accept-charset="utf-8" class="search">
            <button type="submit" class="icon icon-search-1"></button>
            <input type="hidden" name="_token" value="{{ csrf_token() }}" >
            <input type="text" name="query" value="{{ isset($query) ? $query : 'Search Blog...' }}" placeholder="Search Blog..." 
                onclick="this.placeholder='Type...';this.value=='Search Blog...'?this.value='':true" 
                onblur="this.value=this.value==''?'Search Blog...':this.value;this.placeholder='Search Blog...'" required>

            @if(Auth::check())
                <a href="{{ route('blog.create') }}" class="icon icon-pencil"></a>
            @else
                <a>Log In</a> &#8226; 
                <a href="#signin" data-toggle="modal" class="icon icon-pencil"></a>
            @endif
          </form><!--/ .search-form--> 
      </div>


      <a id="responsive-nav-button" class="responsive-nav-button" href="#"></a>

      <nav id="navigation" class="navigation">

        <ul>
          <?php $home = Request::segment(1) ? route('home') : ''; ?>
          <li><a href="{{ '/blog' }}" id="blog">Blog</a></li>
          <li><a href="{{ $home }}#about">About</a></li>
          <li><a href="{{ $home }}#folio">Folio</a></li>
          <!-- <li><a href="{{ $home }}#partners">Partners</a></li> -->
          <!-- <li><a href="{{ $home }}#testimonials">Testimonials</a></li> -->
          <li><a href="{{ $home }}#team">Team</a></li>
          <li><a href="#footer">Contacts</a></li>
        </ul>

      </nav><!--/ #navigation-->

      <img src="/assets/img/sil.png" alt="" class="nai hide">

    </div><!--/ .header-in-->

  </header><!--/ #header-->


  <!-- - - - - - - - - - - - - end Header - - - - - - - - - - - - - - - -->