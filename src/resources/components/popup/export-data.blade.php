<form action="{{$action}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="modal modal-blur fade" id="modal-export-data" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{$title}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <x-portal::input type="text" label="File Name" placeholder="Export file name" name="file_name">
                        {{$title}} {{date('Y-m-d H:i:s')}}
                    </x-portal::input>
                    <x-portal::input.radio label="File Format" name="file_format">
                        <div class="d-flex">
                            <x-portal::input.radio.option class="me-3" label="XLSX" value="xlsx" checked name="file_format">
                            </x-portal::input.radio.option>
                            <x-portal::input.radio.option class="me-3" label="CSV" value="csv" name="file_format">
                            </x-portal::input.radio.option>
                            <x-portal::input.radio.option class="me-3" label="XLS" value="xls" name="file_format">
                            </x-portal::input.radio.option>
                            <x-portal::input.radio.option class="me-3" label="PDF" value="pdf" name="file_format">
                            </x-portal::input.radio.option>
                        </div>
                    </x-portal::input.radio>
                    <div class="row d-none" id="input_type_pdf">
                        <div class="col-sm-6">
                            <x-portal::input.select name="papersize" label="Papersize" required="false">
                                <option selected value="Letter">Letter</option>
                                <option value="Legal">Legal</option>
                                <option value="Ledger">Ledger</option>
                                @for ($i = 0; $i < 8; $i++) <option value='A{{$i}}'>A{{$i}}</option>
                                    @endfor
                                    @for ($i = 0; $i < 10; $i++) <option value='B{{$i}}'>B{{$i}}</option>
                                        @endfor
                            </x-portal::input.select>
                        </div>
                        <div class="col-sm-6">
                            <x-portal::input.select name="page_orientation" label="Orientation" required="false">
                                <option selected value="portrait">Portrait </option>
                                <option value="landscape">Landscape</option>
                            </x-portal::input.select>
                        </div>
                    </div>
                    {{@$html}}

                </div>
                <div class="modal-footer text-end">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">@lang('adminportal.cancel')</button>
                    <button type="submit" class="btn btn-dark" data-bs-dismiss="modal">@lang('adminportal.export')</button>
                </div>
            </div>
        </div>
    </div>
</form>
@push('js')
<script>
    const fileExportFormat = document.querySelectorAll('#modal-export-data input[name="file_format"]')
    fileExportFormat.forEach((item)=>{
        item.addEventListener('change',()=>{
            const value = item.value
            const inputPdf = document.getElementById('input_type_pdf')
            if(value=='pdf'){
                inputPdf.classList.remove('d-none')
            }else{
				inputPdf.classList.add('d-none')
            }
        })
    })
</script>
@endpush