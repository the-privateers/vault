@extends('layouts.app')

@section('content')
@include('lockbox.partials.toolbar')

@forelse($lockboxes as $lockbox)
<div class="panel panel-default">
    <div class="panel-heading clearfix">
        <h3 class="panel-title pull-left">
            {!! link_to_route('lockbox.show', $lockbox->name, $lockbox->uuid) !!}
        </h3>

        <a href="{{ route('lockbox.edit', $lockbox->uuid) }}" class="btn btn-default btn-sm pull-right">Edit</a>
    </div>

    @if( ! empty($lockbox->description))
    <div class="panel-body">
        {!! parse_markdown($lockbox->description) !!}
    </div>
    @endif
</div>
@empty
<div class="well text-center">
    <p class="lead">You have no lockboxes</p>

    <a href="{{ route('lockbox.create') }}" class="btn btn-default btn-lg">Create Your First One</a>
</div>
@endforelse

<div class="text-center">
{!! $lockboxes->links() !!}
</div>

@endsection
