@extends('layouts.app')

@section('content')
    @include('vaults.vault.partials.toolbar')

<div class="panel panel-default">
    <div class="panel-heading clearfix">
        <h3 class="panel-title pull-left">Edit Vault</h3>

        @if(Auth::user()->current_vault_id != $vault->id)
        <a href="{{ route('vault.show', $vault->uuid) }}" class="btn btn-default btn-sm pull-right">Switch to Vault</a>
        @endif
    </div>

    <div class="panel-body">
        {!! Form::model($vault) !!}

        {!! Form::hidden('uuid') !!}

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
        <h3 class="panel-title">Collaborators</h3>
    </div>

    <div class="panel-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Email</th>
                    <th style="width: 1px;"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($vault->users->except(Auth::user()->id) as $user)
                <tr>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if( ! $user->owns($vault))
                        {!! Form::open(['route' => ['vault.user.destroy', $vault->uuid], 'method' => 'DELETE', 'role' => 'remove-collaborator']) !!}
                            {!! Form::hidden('vault', $vault->uuid) !!}
                            {!! Form::hidden('user', $user->uuid) !!}
                            <button type="submit" class="btn btn-default btn-sm">Remove</button>
                        {!! Form::close() !!}
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>


        <p>Collaborators are not permitted to add additional collaborators or edit/delete the vault.</p>

        {!! Form::open(['route' => ['vault.user.add', $vault->uuid]]) !!}
        <!-- Email Form Input -->
        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            {!! Form::label('email', 'Email Address:') !!}
            {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'john@example.com']) !!}

            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>

        <!-- Submit field -->
        <div class="form-group">
            {!! Form::submit('Add Collaborator', ['class' => 'btn btn-primary']) !!}
        </div>

        {!! Form::close() !!}
    </div>
</div>

<div class="panel panel-danger">
    <div class="panel-heading">
        <h3 class="panel-title">Danger Zone</h3>
    </div>

    <div class="panel-body">
        <p>Permanently delete this vault and all lockboxes/secrets within.  This action is instaneous and cannot be undone.</p>

        <!-- Submit field -->
        <div class="form-group">
            {!! Form::model($vault, ['route' => 'vault.destroy', 'method' => 'DELETE', 'role' => 'destroy-vault']) !!}
            {!! Form::hidden('uuid') !!}
            {!! Form::submit('Delete Vault Now', ['class' => 'btn btn-danger']) !!}
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection

@section('scripts')
    @parent
    <script src="/js/vendor/bootbox.js"></script>

    <script>
        $(document).on('submit', '[role="destroy-vault"]', function (e) {
            e.preventDefault();

            var theForm = this;

            bootbox.confirm('Are you sure you want to permanently delete this vault?', function(result) {
                if(result)
                {
                    theForm.submit();
                }
            });
        });

        $(document).on('submit', '[role="remove-collaborator"]', function (e) {
            e.preventDefault();

            var theForm = this;

            bootbox.confirm('Are you sure you want to remove this collaborator?', function(result) {
                if(result)
                {
                    theForm.submit();
                }
            });
        });
    </script>
@endsection
