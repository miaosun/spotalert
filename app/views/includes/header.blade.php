<div class="navbar">
	<div class="navbar-inner">
		<ul class="nav">
			<li><a href="/"><img src="{{asset('assets/images/logo_manyskill.png')}}" height="42"></a></li>
			<li><a href="/eyewitness">Eye Witness</a></li>
			<li><a href="/taqueto">Filter</a></li>
			<li><a href="/poetemanso">Contacts</a></li>
            <li><a href="/tirapata">Log in</a></li>
            <li>
            	<!-- FIXME put option: 'route'=> 'controler for search' -->
            	{{ Form::open(array('method' => 'get', 'name' => 'search', 'id'=> 'search'  )) }}
            		<input id="search-input" placeholder=" 🔍 SEARCH"name="Search" type="text">
            	{{ Form::close() }}
            </li>
            <li><a href="/en">EN</a></li><li><a href="/pt">PT</a></li>
		</ul>
	</div>
</div>

