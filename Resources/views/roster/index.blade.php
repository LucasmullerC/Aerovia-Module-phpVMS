@extends('blank')
@section('title', __('DBasic::common.roster'))

@section('content')
<div class="row">
    <div class="col-md-12">
        @include('DBasic::roster.table')
    </div>
</div>
<div class="row">
    <div class="col-12 text-center">
        {{ $users->links('pagination.default') }}
    </div>
</div>
@endsection
