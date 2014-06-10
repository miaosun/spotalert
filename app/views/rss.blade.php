<Publications>
@foreach($all_publications as $publication)
    <publication id="{{$publication['id']}}">

        <initial_date>{{$publication['initial_date']}}</initial_date>
        <final_date>{{$publication['final_date']}}</final_date>
        <risk>{{$publication['risk']}}</risk>
        <type>{{$publication['type']}}</type>
        <title>{{$publication['title']}}</title>
        <affected_countries>
            @foreach($publication['affected_countries'] as $country)
            <country>{{$country}}</country>
            @endforeach
        </affected_countries>
        <event_types>
            @foreach($publication['event_types'] as $event_type)
            <event>{{$event_type}}</event>
            @endforeach
        </event_types>

    </publication>
@endforeach
</Publications>