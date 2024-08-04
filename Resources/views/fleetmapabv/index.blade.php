@extends('blank')
@section('title', $airline->name)

@section('content')
@widget('DBasic::Map', ['source' => 'fleet', 'airline' => $airline->id])
@endsection
