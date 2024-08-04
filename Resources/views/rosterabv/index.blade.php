@extends('blank')
@section('title', __('DBasic::common.roster'))

@section('content')
  <div class="row">
    <div class="col-md-12">
      <h2>{{ trans_choice('common.pilot', 2) }}</h2>
      @include('users.table')
    </div>
  </div>
@endsection
