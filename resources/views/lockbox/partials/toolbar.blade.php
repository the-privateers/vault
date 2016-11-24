<h1 class="page-header text-center" style="margin-top: 0; margin-bottom: 12px;">Lockboxes</h1>

<div class="page-header clearfix" style="margin-top: 0;">
    <div class="row">
        <div class="col-sm-8">

            {!! Form::text('search', null, ['class' => 'form-control', 'placeholder' => 'Quick jump to lockbox...', 'role' => 'lockbox-autocomplete']) !!}
        </div>

        <div class="col-sm-4">

            <a href="{{ route('lockbox.create') }}" class="btn btn-default btn-block">Create Lockbox</a>
        </div>
    </div>
</div>

@section('head')
    @parent
    <link href="/js/vendor/easy-autocomplete/easy-autocomplete.min.css" rel="stylesheet">
@endsection

@section('scripts')
@parent
<script src="/js/vendor/easy-autocomplete/jquery.easy-autocomplete.min.js"></script>

<script>
    $('[role="lockbox-autocomplete"]').easyAutocomplete({
        url: '{{ route('user.lockboxes', Auth::user()->uuid) }}',

        getValue: function(element) {
            return '[' + element.vault.name + '] ' + element.name;
        },

        list: {
            match: {
                enabled: true
            },
            onChooseEvent: function() {
                var value = $('[role="lockbox-autocomplete"]').getSelectedItemData().uuid;

                window.location = '/lockbox/' + value;
            }
        }
    });
</script>
@endsection