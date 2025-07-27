<div class="modal fade modal-alert" id="modal-confirm" tabindex="-1" aria-labelledby="modal-confirmLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img src="{{asset('adminportal/icons/warning.svg')}}" alt="" class="mb-3">
                <p class="message m-0"></p>
                <div class="d-flex mt-4">
                    <button type="button" class="btn btn-light btn-cancel text-upper w-100 d-block me-2"
                        data-bs-dismiss="modal">@lang('adminportal.no')</button>
                    <button type="button"
                        class="btn btn-dark text-upper w-100 d-block btn-oke ms-2">@lang('adminportal.yes')</button>
                </div>
            </div>
        </div>
    </div>
</div>