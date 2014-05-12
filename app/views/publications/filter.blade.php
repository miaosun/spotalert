<div>{{Lang::get('home.filter.risk_extreme')}}</div>
<div>{{Lang::get('home.filter.risk_medium')}}</div>
<div>{{Lang::get('home.filter.risk_low')}}</div>
<div>
    <a class="trigger right-caret">{{Lang::get('home.filter.type')}}</a>
    <div class="dropdown-menu sub-menu">
        <div>
        @foreach (EventType::all() as $eventType)
            <div>{{{$eventType->name}}}</div>
        @endforeach
        </div>
        <div>OK</div>
    </div>
</div>
<div>
    <a class="trigger right-caret">{{Lang::get('home.filter.country')}}</a>
    <div class="dropdown-menu sub-menu">
        <div>All countries</div>
        <div style="height:80px;width:218px;" class="scrollable">
        @foreach (Country::all() as $country)
            <div>{{{$country->name}}}</div>
        @endforeach
        </div>
        <div>OK</div>
    </div>
</div>