@extends('blank')
@section('title', 'Hubs')


@section('content')

@widget('DBasic::Map', ['source' => $hub->id])

@endsection
