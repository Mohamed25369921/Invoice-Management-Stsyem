

@if (Session::has('error'))
    <div class="alert alert-danger alert-dismissible fade show text-center">
        <strong>{{ Session::get('error') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif


@if (Session::has('success'))
    <div class="alert alert-success alert-dismissible fade show text-center">
        <strong>{{ Session::get('success') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif