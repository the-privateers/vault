@extends('layouts.app')

@section('content')
    @include('lockboxes.partials.toolbar')

    @include('lockboxes.partials.tabs', ['tab' => 'secrets'])

    <div class="panel panel-default has-tabs">
        <div class="panel-body">
            {!! Form::open(['id' => 'secrets-form']) !!}

            {!! Form::hidden('lockbox', $lockbox->uuid) !!}

            <table class="table table-striped" id="secrets-table">
                <thead>
                <tr>
                    <th style="width: 30%;">Key/Label</th>
                    <th>Value</th>
                    <th style="width: 1px;"><i class="icon-key" data-toggle="tooltip" title="Obscure value when viewing"></i></th>
                    <th style="width: 1px;"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($lockbox->secrets as $secret)
                    <tr id="{{ $secret->uuid }}">
                        <td>
                            <div class="form-group{{ $errors->has('secrets.' . $secret->uuid . 'key') ? ' has-error' : '' }}">
                                {!! Form::label('secrets[' . $secret->uuid . '][key]', 'Key:', ['class' => 'sr-only']) !!}

                                {!! Form::text('secrets[' . $secret->uuid . '][key]', $secret->key, ['class' => 'form-control']) !!}

                                @if ($errors->has('secrets.' . $secret->uuid . 'key'))
                                    <span class="help-block">
                                <strong>{{ $errors->first('secrets.' . $secret->uuid . 'key') }}</strong>
                            </span>
                                @endif
                            </div>
                        </td>

                        @if( empty($secret->linked_lockbox_id))
                            <td>
                                <div class="form-group{{ $errors->has('secrets.' . $secret->uuid . 'value') ? ' has-error' : '' }}">
                                    {!! Form::label('secrets[' . $secret->uuid . '][value]', 'Value:', ['class' => 'sr-only']) !!}

                                    {!! Form::text('secrets[' . $secret->uuid . '][value]', $secret->value, ['class' => 'form-control']) !!}

                                    @if ($errors->has('secrets.' . $secret->uuid . 'value'))
                                        <span class="help-block">
                                <strong>{{ $errors->first('secrets.' . $secret->uuid . 'value') }}</strong>
                            </span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                {!! Form::checkbox('secrets[' . $secret->uuid . '][paranoid]', 1, (boolean) $secret->paranoid) !!}
                            </td>
                        @else
                            <td>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="icon-key"></i></div>
                                        {!! Form::select('secrets[' . $secret->uuid . '][linked_lockbox_id]', $linkableLockboxes, $secret->linked_lockbox_id, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                            </td>
                            <td></td>
                        @endif
                        <td>
                            <button class="btn btn-default btn-block" role="remove-secret" data-uuid="{{ $secret->uuid }}">Delete</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class="form-group">
                <button class="btn btn-default" role="add-secret">Add A Secret</button>
            </div>

            <div class="form-group">
                <button class="btn btn-default" role="add-lockbox">Add A Link to Another Lockbox</button>
            </div>

            <!-- Submit field -->
            <div class="form-group">
                {!! Form::submit('Save Changes', ['class' => 'btn btn-primary']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section('scripts')
    @parent
    <script src="/js/vendor/handlebars.js"></script>

    <script>
        var counter = 1;

        $('[role="add-secret"]').on('click', function(e) {
            e.preventDefault();

            var uuid = counter;

            var source   = $("#secret-row").html();
            var template = Handlebars.compile(source);
            var html    = template({uuid: uuid });

            $('#secrets-table tbody').append(html);

            counter++;

        });

        $('[role="add-lockbox"]').on('click', function(e) {
            e.preventDefault();

            var uuid = counter;

            var source   = $("#lockbox-row").html();
            var template = Handlebars.compile(source);
            var html    = template({uuid: uuid });

            $('#secrets-table tbody').append(html);

            counter++;

        });

        $(document).on('click', '[role="remove-secret"]', function(e)
        {
            e.preventDefault();

            var uuid = $(this).data('uuid');

            $('#' + uuid).remove();

            // Append something to the form
            $('<input type="hidden" value="1" />')
                    .attr("name", 'secrets[' + uuid + '][destroy]')
                    .appendTo( $('#secrets-form') );

        });

        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });

    </script>

    @include('lockboxes.partials.handlebars.secret-row')
    @include('lockboxes.partials.handlebars.lockbox-row')
@endsection
