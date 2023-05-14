<x-portal::layout.admin :page="$page_title" :type="$type">
    <section class="app-content shadow-sm">
        <form action="{{$action}}" method="post" enctype="multipart/form-data">
            @csrf
            @if($type=='update')
                @method('PATCH')
            @endif
            @if(request('return_url'))
            <input type="hidden" name="return_url" value="{{request('return_url')}}">
            @endif
            <div class="header-form d-flex justify-content-between">
                <div class="left-side d-flex align-items-center">
                    <h5 class="form-title">{{ucfirst($type)}} {{$page_title}}</h5>
                </div>
                <div class="right-side d-flex">
                    <a href="{{return_url() ?: route("{$route}.index")}}" class="btn btn-light text-upper">
                        @lang('adminportal.back')
                    </a>
                    <button type="submit" class="btn btn-dark text-upper ms-3">
                        @lang('adminportal.save')
                    </button>
                </div>
            </div>
            <div class="form-content">
               @include($form_views)
            </div>
        </form>
    </section>
    @stack('html')
</x-portal::layout.admin>