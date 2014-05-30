@if(isset($publications))

@if(isset($next_page) && $next_page == 2)
<div class="scroll">
@endif
    
    @foreach ($publications as $key => $publication)

    @if (($key % 3) == 0)
    <div class="row row-publ">
    @endif
    <div class="col-md-4">
        <div class="col-md-12 col-sm-12 publication-{{{$publication['type']}}} publ-risk{{{$publication['risk']}}} {{(isset($publication['inactive'])) ? 'inactive' : ''}}"
            id="publ-{{ $publication['id'] }}">

            <div class="publ_header">
                <div class="col-md-4 publ-risk">
                @if ($publication['type'] == 'alert')


                    @if($publication['risk'] >= 1 && $publication['risk'] <=2)
                        <div class="ray_low"></div>
                    @endif

                    @if($publication['risk'] >= 3 && $publication['risk'] <=4)
                        <div class="ray_medium"></div>
                    @endif

                    @if($publication['risk'] >= 5)
                        <div class="ray_high"></div>
                    @endif

                @else
                    <div class="plus"></div>

                @endif
                </div>
                <div class="col-md-4 publ-type">
                    @foreach ($publication['event_types'] as $eventType)
                        {{{$eventType}}}
                    @endforeach
                </div>

                <div class="col-md-4 publ-countr">
                    @foreach ($publication['affected_countries'] as $country)
                        {{{$country}}}<br>
                    @endforeach
                </div>
            </div>

            <br>
            <hr>
            <div class="publ_body">
                <div class="publ-title">{{{$publication['title']}}}</div>
                <div class="publ-colapse">
                    <hr>
                    <div class="publ-content">
                        <p></p>
                        <div class="publ-linked">
                        @if ($publication['type'] == 'alert')
                            <h1>{{ Lang::get('publication.titles.guide') }} 
                            @if($publication['risk'] >=5)
                                <button class="glyphicon glyphicon-chevron-right arrow_white publ-linked-toggle-btn" publicationid="{{ $publication['id'] }}"></button>
                            @else
                                <button class="glyphicon glyphicon-chevron-right arrow_gray publ-linked-toggle-btn" publicationid="{{ $publication['id'] }}"></button>
                            @endif        
                            </h1>        
                        @else
                            <h1>{{ Lang::get('publication.titles.alert') }} 
                            @if($publication['risk'] >=5)
                                <button class="glyphicon glyphicon-chevron-right arrow_white publ-linked-toggle-btn" publicationid="{{ $publication['id'] }}"></button>
                            @else
                                <button class="glyphicon glyphicon-chevron-right arrow_gray publ-linked-toggle-btn" publicationid="{{ $publication['id'] }}"></button>
                            @endif
                            </h1>
                        @endif
                        <div class="publ-linked-toggle"></div>
                        </div>
                        @include('publications.publicationShare')

                        <div class="publ-comments">
                            @if ($publication['risk'] >=5 && $publication['type'] == 'alert')
                                <h1>{{ Lang::get('publication.titles.comments.title') }} <button class="glyphicon glyphicon-chevron-right arrow_white publ-comments-toggle-btn" publicationid="{{ $publication['id'] }}"></button></h1>
                            @else
                                <h1>{{ Lang::get('publication.titles.comments.title') }}  <button class="glyphicon glyphicon-chevron-right arrow_gray publ-comments-toggle-btn" publicationid="{{ $publication['id'] }}"></button></h1>
                            @endif
                            <div class="publ-comments-toggle"></div>
                        </div>
                    </div>
                </div>
                <hr>
                @if(isset($publication['hidden']))
					<div class="publ-info publ-hidden">{{Lang::get('home.publications.hidden')}}</div>
				@elseif(isset($publication['inactive']))
					<div class="publ-info publ-inactive">{{Lang::get('home.publications.inactive')}}</div>
				@elseif(isset($publication['updated']) && $publication['risk'] >=5 && $publication['type'] == 'alert')
					<div class="publ-info upd-white">{{Lang::get('home.publications.updated')}}</div>
				@elseif(isset($publication['updated']))
					<div class="publ-info upd-red">{{Lang::get('home.publications.updated')}}</div>
				@endif
            </div>
            <div class="col-md-12 publ_footer">
                @if(Auth::check() && Auth::user()->type != 'normal')
                <div class="row">
                    <div class="button_edit" id="{{ $publication['id'] }}">
                        @if ($publication['risk'] >=5 && $publication['type'] == 'alert')
                           <button type="button" class="glyphicon glyphicon-remove btn_white"></button>
                        <a href="/publication/edit-alert/{{$publication['id']}}"><button class="glyphicon glyphicon-edit btn_white"></button></a>
                        @else
                            <button type="button" class="glyphicon glyphicon-remove btn_gray"></button>
                        <a href="/publication/edit-alert/{{$publication['id']}}"><button class="glyphicon glyphicon-edit btn_gray" onclick="location.href='publication/edit-alert/{{ $publication['id'] }}'"></button></a>
                        @endif

                    </div>
                </div>
                @endif

                <div class="row">
                    @if ($publication['risk'] >=5 && $publication['type'] == 'alert')
                        <button class="glyphicon glyphicon-chevron-down arrow_white publ-expand" publicationid="{{ $publication['id'] }}"></button>
                    @else
                        <button class="glyphicon glyphicon-chevron-down arrow_gray publ-expand" publicationid="{{ $publication['id'] }}"></button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if (($key % 3) == 2 || $key == count($publications) - 1)
        </div>
    @endif

    @endforeach

@if(isset($next_page))
   @if($type == 'search')
       <a class="jscroll-next" href="/publications/search/{{{$search_text}}}/{{{$next_page}}}">next page</a>
   @elseif($type == 'filter')
       <a class="jscroll-next" href="/publications/filter?risks={{{$risks}}}&event_types={{{$event_types}}}&affected_countries={{{$affected_countries}}}&next_page={{{$next_page}}}">next page</a>
   @else
       <a class="jscroll-next" href="/publications/next_page/{{{$next_page}}}">next page</a>
   @endif

   @if($next_page == 2)
   </div>
   @endif
@endif

    @if(Auth::check() && Auth::user()->type != 'normal')
    <!-- Modal dialog for deleting publication -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel">{{Lang::get('home.del-publ.delete')}}</h4>
          </div>
          <div class="modal-body">
            {{Lang::get('home.del-publ.confirm-msg')}}
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-success">{{Lang::get('home.del-publ.yes')}}</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">{{Lang::get('home.del-publ.no')}}</button>
          </div>
        </div>
      </div>
    </div>
    @endif
@endif
