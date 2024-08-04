@extends('blank')
@section('title', $airline->name)

@section('content')
@widget('DBasic::Map', ['source' => $airline->id])
@endsection
