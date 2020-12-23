@if(session()->has('alert.success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session()->get('alert.success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
@if(session()->has('alert.info'))
<div class="alert alert-info alert-dismissible fade show" role="alert">
    {{ session()->get('alert.info') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
@if(session()->has('alert.warning'))
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    {{ session()->get('alert.warning') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
@if(session()->has('alert.error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session()->get('alert.error') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif