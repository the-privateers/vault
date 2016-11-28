@extends('layouts.app')

@section('content')
    @include('lockbox.partials.toolbar')

<div class="panel panel-default">
    <div class="panel-heading clearfix">
        <h3 class="panel-title pull-left">Edit Lockbox</h3>

        <a href="{{ route('lockbox.show', $lockbox->uuid) }}" class="btn btn-default btn-sm pull-right">Preview</a>
    </div>

    <div class="panel-body">
        {!! Form::model($lockbox) !!}

            {!! Form::hidden('uuid',null) !!}

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

            <!-- Submit field -->
            <div class="form-group">
                {!! Form::submit('Save Changes', ['class' => 'btn btn-primary']) !!}
            </div>
        {!! Form::close() !!}
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Edit Secrets</h3>
    </div>

    <div class="panel-body">
        {!! Form::open(['route' => 'secret.update', 'id' => 'secrets-form']) !!}

        {!! Form::hidden('lockbox', $lockbox->uuid) !!}

        <table class="table table-striped" id="secrets-table">
            <thead>
                <tr>
                    <th style="width: 30%;">Key</th>
                    <th>Value</th>
                    <th style="width: 1px;"><i class="fa fa-user-secret" data-toggle="tooltip" title="Obscure value when viewing"></i></th>
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
                    <td>
                        <button class="btn btn-default btn-block" role="remove-secret" data-uuid="{{ $secret->uuid }}">Delete</button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="form-group">
            <button class="btn btn-default" role="add-secret">Add Another Secret</button>
        </div>

        <!-- Submit field -->
        <div class="form-group">
            {!! Form::submit('Save Changes', ['class' => 'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Update Notes</h3>
    </div>

    <div class="panel-body">
        {!! Form::model($lockbox, ['route' => ['lockbox.notes', $lockbox->uuid]]) !!}

        {!! Form::hidden('uuid',null) !!}

        <div class="form-group{{ $errors->has('notes') ? ' has-error' : '' }}">
            {!! Form::label('notes', 'notes:', ['class' => 'sr-only']) !!}

            {!! Form::textarea('notes', null, ['class' => 'form-control', 'placeholder' => 'Instructions, notes, extra information...', 'role' => 'editor']) !!}

            @if ($errors->has('notes'))
                <span class="help-block">
                <strong>{{ $errors->first('notes') }}</strong>
            </span>
            @endif
        </div>

        <!-- Submit field -->
        <div class="form-group">
            {!! Form::submit('Save Changes', ['class' => 'btn btn-primary']) !!}
        </div>

        {!! Form::close() !!}
    </div>
</div>

<div class="panel panel-danger">
    <div class="panel-heading">
        <h3 class="panel-title">Danger Zone</h3>
    </div>

    <div class="panel-body">
        <p>Permanently delete this lockbox from the vault.  This action is instaneous and cannot be undone.</p>

        <!-- Submit field -->
        <div class="form-group">
            {!! Form::model($lockbox, ['route' => 'lockbox.destroy', 'method' => 'DELETE', 'role' => 'destroy-lockbox']) !!}
                {!! Form::hidden('uuid') !!}
                {!! Form::submit('Delete Lockbox Now', ['class' => 'btn btn-danger']) !!}
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection

@section('scripts')
    @parent
    <script src="/js/vendor/handlebars.js"></script>
    <script src="/js/vendor/bootbox.js"></script>
    <script src="/js/vendor/tinymce/tinymce.min.js"></script>

    <script>
        function tinymceInit()
        {
            tinymce.init({
                selector: 'textarea[role="editor"]',
                menubar : false,
                content_css : '/js/vendor/tinymce/editor.css',
                statusbar : false,
                plugins: "link code paste",
                toolbar: "bold italic styleselect | bullist numlist | link code",
                valid_elements : '+*[*]',
                convert_urls: false,
                style_formats: [
                    {title: "Header 1", format: "h1"},
                    {title: "Header 2", format: "h2"},
                    {title: "Header 3", format: "h3"},
                    {title: "Header 4", format: "h4"},
                    {title: "Header 5", format: "h5"},
                    {title: "Header 6", format: "h6"},
                    {title: "Blockquote", format: "blockquote"}
                ]
            });
        }

        tinymceInit();

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
                    .attr("name", 'secrets[' + uuid + '][destroy]')
                    .appendTo( $('#secrets-form') );

        });

        $(document).on('submit', '[role="destroy-lockbox"]', function (e) {
            e.preventDefault();

            var theForm = this;

            bootbox.confirm('Are you sure you want to permanently delete this lockbox?', function(result) {
                if(result)
                {
                    theForm.submit();
                }
            });
        });

        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });
    </script>

    @include('lockbox.partials.handlebars.secret-row')
@endsection