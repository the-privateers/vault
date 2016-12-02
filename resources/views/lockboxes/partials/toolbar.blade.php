<h1 class="page-header text-center" style="margin-top: 0; margin-bottom: 12px;">
    <a href="{{ route('lockbox.index') }}">
        <i class="icon-key"></i><br />
        Lockboxes
        @if(Auth::user()->canAddToCurrentVault())
        <br /><a href="{{ route('lockbox.create') }}" class="btn btn-default btn-sm">Create Lockbox</a>
        @endif
    </a>
</h1>