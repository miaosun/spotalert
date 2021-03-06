<div class="filter-opt filter-risk">{{Lang::get('home.filter.risk_extreme')}}</div>
    <hr>
<div class="filter-opt filter-risk">{{Lang::get('home.filter.risk_medium')}}</div>
    <hr>
<div class="filter-opt filter-risk">{{Lang::get('home.filter.risk_low')}}</div>
    <hr>
<div>
    <a class="trigger">{{Lang::get('home.filter.type')}}  <span class="glyphicon glyphicon-chevron-right"></span></a>
    <div class="dropdown-menu sub-menu">
        <div>
        @foreach (EventType::all() as $eventType)
            <div class="filter-opt filter-eventType">{{{$eventType->name}}}</div>
            <hr>
        @endforeach
        </div>
        <div class="filter-ok">OK</div>
    </div>
        <hr>
</div>
<div>
    <a class="trigger">{{Lang::get('home.filter.country')}} <span class="glyphicon glyphicon-chevron-right"></span></a>
    <div class="dropdown-menu sub-menu">
        <div class="filter-opt filter-all">All countries</div>
        <div id="filter-country-list">
            @foreach (Country::all() as $country)
            <div class="filter-opt filter-country">{{{$country->name}}}</div>
            @endforeach
        </div>
        <hr>
        <div class="filter-ok">OK</div>
    </div>
</div>