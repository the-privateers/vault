@extends('layouts.app')

@section('content')
    @include('lockbox.partials.toolbar')

    {!! Form::open() !!}
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Create Lockbox</h3>
    </div>

    <div class="panel-body">
        {!! Form::hidden('vault', Auth::user()->currentVault->uuid) !!}

        <!-- Name Form Input -->
        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            {!! Form::label('name', 'Name:', ['class' => 'control-label']) !!}

            {!! Form::text('name', null, ['class' => 'form-control']) !!}

            @if ($errors->has('name'))
                <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
            {!! Form::label('description', 'Description:', ['class' => 'control-label']) !!}

            {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => 3]) !!}

            @if ($errors->has('description'))
                <span class="help-block">
                    <strong>{{ $errors->first('description') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>


<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Add Secrets</h3>
    </div>

    <div class="panel-body">
        <table class="table table-striped" id="secrets-table">
            <thead>
            <tr>
                <th>Key</th>
                <th>Value</th>
                <th style="width: 1px;"><i class="fa fa-user-secret" data-toggle="tooltip" title="Obscure value when viewing"></i></th>
                <th style="width: 1px;"></th>
            </tr>
            </thead>

            <tbody>
                <tr id="_0">
                    <td>
                        <div class="form-group{{ $errors->has('secrets.0.key') ? ' has-error' : '' }}">
                            {!! Form::label('secrets[0][key]', 'Key:', ['class' => 'sr-only']) !!}

                            {!! Form::text('secrets[0][key]', null, ['class' => 'form-control', 'placeholder' => 'Key']) !!}

                            @if ($errors->has('secrets.0.key'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('secrets.0.key') }}</strong>
                                </span>
                            @endif
                        </div>
                    </td>

                    <td>
                        <div class="form-group{{ $errors->has('secrets.0.value') ? ' has-error' : '' }}">
                            {!! Form::label('secrets[0][value]', 'Description:', ['class' => 'sr-only']) !!}

                            {!! Form::text('secrets[0][value]', null, ['class' => 'form-control', 'placeholder' => 'Value']) !!}

                            @if ($errors->has('secrets.0.value'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('secrets.0.value') }}</strong>
                                </span>
                            @endif
                        </div>
                    </td>

                    <td>
                        {!! Form::checkbox('secrets[0][paranoid]', 1) !!}
                    </td>

                    <td>
                        <button class="btn btn-default btn-block" role="remove-secret" data-uuid="_0">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <button class="btn btn-default" role="add-secret">Add Another Secret</button>

    </div>
</div>

<div class="panel panel-default">
    <div class="panel-body">
        <!-- Submit field -->
        <div class="form-group">
            {!! Form::submit('Create Lockbox', ['class' => 'btn btn-primary']) !!}
        </div>
    </div>
</div>

{!! Form::close() !!}
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

        $(document).on('click', '[role="remove-secret"]', function(e)
        {
            e.preventDefault();

            var uuid = $(this).data('uuid');

            $('#' + uuid).remove();

            // Append something to the form
            $('<input type="hidden" value="1" />')
                    .attr("name", 'field[' + uuid + '][destroy]')
                    .appendTo( $('#fields-form') );

        });

        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });
    </script>

    @include('lockbox.partials.handlebars.secret-row')
@endsection