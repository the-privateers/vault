@extends('layouts.app')

@section('content')
    @include('lockbox.partials.toolbar')

<div class="panel panel-default">
    <div class="panel-heading clearfix">
        <h3 class="panel-title pull-left">
            {{ $lockbox->name }}

            <button class="btn btn-sm btn-empty" role="clipboard-copy" data-clipboard-text="{{ route('lockbox.show', $lockbox->uuid) }}" data-toggle="tooltip" title="Copy lockbox URL to clipboard"><i class="icon-share"></i></button>
        </h3>

        @if($lockbox->canBeEditedBy(Auth::user()))
        <a href="{{ route('lockbox.edit', $lockbox->uuid) }}" class="btn btn-default btn-sm pull-right">Edit</a>
        @endif
    </div>

    @if( ! empty($lockbox->description))
        <div class="panel-body">
            {!! parse_markdown($lockbox->description) !!}
        </div>
    @endif
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        Secrets
    </div>

    <div class="panel-body">

        <table class="table table-striped">
            <tbody>
            @foreach($lockbox->secrets as $secret)
                <tr>
                    <td>{{ $secret->key }}</td>
                    <td>
                        {!! $secret->present()->value() !!}
                        <button class="btn btn-empty" role="clipboard-copy" data-clipboard-text="{{  $secret->value }}" data-toggle="tooltip" title="Copy to clipboard"><i class="icon-clipboard"></i></button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

@if( ! empty($lockbox->notes))
<div class="panel panel-default">
    <div class="panel-body">
        {!! parse_markdown($lockbox->notes) !!}
    </div>
</div>
@endif

@endsection

@section('scripts')
    @parent
    <script src="/js/vendor/zero-clipboard/ZeroClipboard.min.js"></script>

    <script>
        $(function () {
            var clipboard = new ZeroClipboard($('[role="clipboard-copy"]'));
            $('[data-toggle="tooltip"]').tooltip()
        });
    </script>
@endsection
