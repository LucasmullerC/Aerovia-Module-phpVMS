@extends('blank')
@section('title', 'Flights')


@section('content')

@widget('DBasic::Map', ['source' => 'aircraft','uid' => $aircraft->id])

@endsection
