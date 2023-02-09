<form action="{{$action}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="modal modal-blur fade" id="modal-import-data" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{$title}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <x-portal::input type="file" label="Import File" name="import_file">
                        </x-portal::input.file>
                        <blockquote class="mt-1" style="margin-top: -19px !important;font-size: 13px;">
                            <b>Before doing upload a file, its better to read this bellow instructions :</b>
                            <ul  style="padding-left: 16px;font-size: 13px">
                                <li>File format should be : xls or xlsx or csv</li>
                                <li>If you have a big file data, we can't guarantee. So, please split those files into
                                    some parts of
                                    file (at least max 5 MB).</li>
                                <li>This tool is generate data automatically so, be carefull about your table xls
                                    structure. Please
                                    make sure correctly the table
                                    structure.</li>
                                <li>Table structure : Line 1 is heading column , and next is the data. (For example, you
                                    can export
                                    any module you wish to XLS format)</li>
                            </ul>
                        </blockquote>
                        @if(isset($sample_file))
                        <span class="help-text">You can download sample import file <a href="{{$sample_file}}" target="_blank">here</a></span>
                        @endif
                </div>
                <div class="modal-footer text-end">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">@lang('adminportal.cancel')</button>
                    <button type="submit" class="btn btn-dark">@lang('adminportal.import')</button>
                </div>
            </div>
        </div>
    </div>
</form>