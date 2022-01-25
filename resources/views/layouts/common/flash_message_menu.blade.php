
    @if (session()->has('succes_menu'))

    <div class="alert alert-card alert-success" role="alert">
        <strong class="text-capitalize">Success!</strong>   {{ session()->get('succes_menu')  }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>

    @endif


    