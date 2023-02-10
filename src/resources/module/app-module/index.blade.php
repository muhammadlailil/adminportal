@push('js')
<style>
    .nested-sort {
        padding: 0;
    }

    .nested-sort li {
        list-style: none;
        margin: 0 0 5px;
        padding: 15px;
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 15px;
        font-size: 16px;
        font-weight: bold;
        cursor: grab
    }

    .nested-sort li ul {
        padding: 0;
        margin-top: 10px;
        margin-bottom: -5px;
    }

    .nested-sort .ns-dragged {
        outline: 1px solid red;
    }

    .nested-sort .ns-targeted {
        outline: 1px solid green;
        border-radius: 15px
    }

    .container {
        margin: 150px auto;
        max-width: 960px;
    }

    .nested-sort .modul-icon {
        font-size: 20px;
        margin-right: 15px;
    }

    .nested-sort a {
        text-decoration: none;
        font-size: 14px;
        color: #000;
        margin-left: 15px;
    }
</style>
{{-- https://www.hesamurai.com/nested-sort/latest/ --}}
<script src="{{asset('adminportal/js/Sortable.js?')}}"></script>
<script>
    new NestedSort({
      actions: {
        onDrop: function (data) {
            let formData = new FormData();
            formData.set('_token',"{{csrf_token()}}")
            formData.set('data',JSON.stringify(data))
            fetch("{{route('admin.cms-moduls.sort-menu')}}", {
                method: "POST",
                body: formData,
            }).then(async (res) => {
                if (res.status == 200) {
                } else {
                }
            });
        }
      },
      el: '#application-module',
      listClassNames: ['nested-sort'],
      nestingLevels: 1
    });

    const btnCancel = document.querySelector('.btn-cancel')
    const titleForm = document.getElementById('title-form')
    const formMenu = document.getElementById('form-menu');
    const menuName = document.getElementById('menu_name')
    const menuPath = document.getElementById('menu_path')
    const menuIcon = document.getElementById('menu_icon')
    const niceIcon = menuIcon.parentElement.querySelector('.nice-select .current')
    document.querySelectorAll('.btn-edit').forEach((item)=>{
        item.addEventListener('click',function(){
            const id = item.getAttribute('data-id');
            const name = item.getAttribute('data-name');
            const path = item.getAttribute('data-path');
            const icon = item.getAttribute('data-icon').replace('isax','');
            menuName.value = name;
            menuPath.value = path
            menuIcon.value = icon
            niceIcon.innerHTML = ''
            niceIcon.insertAdjacentHTML("beforeend",`<i class="isax ${icon} select-icon-item"></i>${icon}`)
            btnCancel.classList.remove('d-none')
            titleForm.innerHTML = 'Update Static Menu';
            formMenu.insertAdjacentHTML("beforeend",`<input type="hidden" name="id" value="${id}"/>`)
        })
    })

    btnCancel.addEventListener('click',function(){
        menuName.value = ''
        menuPath.value = ''
        menuIcon.value = ''
        niceIcon.innerHTML = 'Select an option'
        btnCancel.classList.add('d-none')
        titleForm.innerHTML = 'Create Static Menu';
        formMenu.querySelector('input[name="id"]')?.remove()
    })
</script>
@endpush
<x-portal::layout.admin page="Application Module" type="List">
    <div class="row">
        <div class="col-sm-7">
            <section class="app-content shadow-sm pb-2">
                <div class="header-form d-flex justify-content-between">
                    <div class="left-side d-flex align-items-center">
                        <h5 class="form-title">@lang('adminportal.order_application_module')</h5>
                    </div>
                    <div class="right-side d-flex">
                        <a href="{{route('admin.cms-moduls.create-mm')}}" class="btn btn-dark text-upper ms-3" title="Create Migration And Model">
                            CREATE MM
                        </a>
                        <a href="{{route('admin.cms-moduls.builder')}}" class="btn btn-dark text-upper ms-3">
                            @lang('adminportal.generate_new_module')
                        </a>
                    </div>
                </div>
                <ul id="application-module">
                    @foreach($moduls as $modul)
                    <li data-id="{{$modul->id}}">
                        <div class="d-flex justify-content-between">
                            <div class="d-flex align-items-center">
                                <i class="modul-icon {{$modul->icon}}"></i>
                                {{$modul->name}}
                            </div>
                            <div class="d-flex">
                                <a href="javascript:;" class="btn-edit"
                                    data-id="{{$modul->id}}"
                                    data-name="{{$modul->name}}"
                                    data-path="{{$modul->path}}"
                                    data-icon="{{$modul->icon}}"
                                    >Edit</a>
                                <a href="javascript:;" data-toggle="confirmation"
                                    data-message="{{__('adminportal.delete_confirmation')}}"
                                    data-action="{{adminroute('admin.cms-moduls.delete',$modul->id)}}"
                                    data-method="DELETE">Delete</a>
                            </div>
                        </div>
                        @if(count($modul->sub))
                        <ul data-id="{{$modul->id}}">
                            @foreach ($modul->sub as $sub)
                            <li data-id="{{$sub->id}}">
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <i class="modul-icon {{$sub->icon}}"></i>
                                        {{$sub->name}}
                                    </div>
                                    <div class="d-flex">
                                        <a href="javascript:;" class="btn-edit"
                                            data-id="{{$sub->id}}"
                                            data-name="{{$sub->name}}"
                                            data-path="{{$sub->path}}"
                                            data-icon="{{$sub->icon}}"
                                            >Edit</a>
                                        <a href="javascript:;" data-toggle="confirmation"
                                            data-message="{{__('adminportal.delete_confirmation')}}"
                                            data-action="{{adminroute('admin.cms-moduls.delete',$sub->id)}}"
                                            data-method="DELETE">Delete</a>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                        @endif
                    </li>
                    @endforeach
                </ul>
            </section>
        </div>
        <div class="col-sm-5">
            <section class="app-content shadow-sm">
                <form action="{{route('admin.cms-moduls.create')}}" method="post" id="form-menu">
                    @csrf
                    <div class="header-form d-flex justify-content-between">
                        <div class="left-side d-flex align-items-center">
                            <h5 class="form-title" id="title-form">@lang('adminportal.create_static_menu')</h5>
                        </div>
                        <div class="right-side d-flex">
                            <a href="javascript:;" class="btn btn-light btn-cancel d-none text-upper">
                                @lang('adminportal.cancel')
                            </a>
                            <button type="submit" class="btn btn-dark text-upper ms-3">
                                @lang('adminportal.save')
                            </button>
                        </div>
                    </div>
                    <x-portal::input type="text" name="menu_name" label="Menu Name" placeholder="Menu name ...">
                    </x-portal::input>
                    <x-portal::input type="text" name="menu_path" label="Menu Path" placeholder="Menu path ...">
                    </x-portal::input>
                    <x-portal::input.select name="menu_icon" label="Menu Icon" class="searchable select-icons">
                        @foreach ($icons as $icon)
                        <option value="{{$icon}}">{{$icon}}</option>
                        @endforeach
                    </x-portal::input.select>
                </form>
            </section>
        </div>
    </div>

    <x-portal::input.select.asset />
</x-portal::layout.admin>