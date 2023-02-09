<div class="table-responsive">
    <table class="table table-table">
        <thead>
            <tr>
                <td>Label</td>
                <td>Name</td>
                <td>Type</td>
                <td>Rules ( create & update)</td>
                <td>Create Rules</td>
                <td>Update Rules</td>
                <td>
                    <button type="button" onclick="addMoreForm()" class="btn btn-dark btn-sm text-upper w-100 justify-content-center">
                        @lang('adminportal.add_more')
                    </button>
                </td>
            </tr>
        </thead>
        <tbody>
           
        </tbody>
    </table>
</div>

@push('js')
<style>
    table tr td{
        font-size: 14px
    }
</style>
@endpush
