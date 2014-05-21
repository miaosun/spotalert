<div class="filter-opt filter-risk">{{Lang::get('home.filter.risk_extreme')}}</div>
    <hr>
<div class="filter-opt filter-risk">{{Lang::get('home.filter.risk_medium')}}</div>
    <hr>
<div class="filter-opt filter-risk">{{Lang::get('home.filter.risk_low')}}</div>
    <hr>
<div>
    <a class="trigger right-caret">{{Lang::get('home.filter.type')}}</a>
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
    <a class="trigger right-caret">{{Lang::get('home.filter.country')}}</a>
    <div class="dropdown-menu sub-menu">
        <div class="filter-opt filter-all">All countries</div>
        <div style="height:80px;width:218px;" class="scrollable" style="overflow-y: scroll;">
        
            @foreach (Country::all() as $country)
            <div class="filter-opt filter-country">{{{$country->name}}}</div>
            @endforeach
        
        </div>
        <hr>
        <div class="filter-ok">OK</div>
    </div>
</div>