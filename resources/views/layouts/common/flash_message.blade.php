
    @if (session()->has('succes'))

    <div class="alert alert-card alert-success" role="alert">
        <strong class="text-capitalize">Success!</strong>   {{ session()->get('succes')  }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>

    @endif


    