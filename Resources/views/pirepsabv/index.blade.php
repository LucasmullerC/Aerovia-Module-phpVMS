@extends('blank')
@section('title', trans_choice('common.pirep', 2))

@section('content')
  @if(!$pireps->count())
    <div class="alert alert-info mb-1 p-1 px-2 fw-bold">No Pilot Reports!</div>
  @else
    <div class="row">
      <div class="col">
        <div class="card mb-2">
          <div class="card-header p-1">
            <h5 class="m-1">
              @lang('DBasic::common.reports')
              <i class="fas fa-upload float-end"></i>
            </h5>
          </div>
          <div class="card-body p-0 overflow-auto table-responsive" style="max-height: 78vh;">
            @include('DBasic::pirepsabv.table', ['compact_view' => false])
          </div>
        </div>
      </div>
    </div>
  @endif
@endsection
