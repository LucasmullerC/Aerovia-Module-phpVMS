@extends('blank')
@section('title', 'Flights')


@section('content')
    <table class="table">
        <thead>
          <tr>
            <th>@sortablelink('airline_id', __('common.airline'))</th>
            <th>@sortablelink('flight_number', __('flights.flightnumber'))</th>
            <th>@sortablelink('dpt_airport_id', __('airports.departure'))</th>
            <th>@sortablelink('arr_airport_id', __('airports.arrival'))</th>
            <th>@sortablelink('dpt_time', 'STD')</th>
            <th>@sortablelink('arr_time', 'STA')</th>
            <th>@sortablelink('distance', 'Distance')</th>
            <th>@sortablelink('flight_time', 'Flight Time')</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($flights as $flight)
                <tr>
                    <td>{{ $flight->id }}</td>
                    <td>{{ $flight->flight_number }}</td>
                    <td>{{$flight->dpt_airport_id}}</td>
                    <td>{{$flight->arr_airport_id}}</td>
                    <td>{{ $flight->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
