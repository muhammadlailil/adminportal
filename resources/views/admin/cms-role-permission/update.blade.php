<div class="flex gap-10 md:flex-row flex-col" x-data="{
     name: '{{ $row->name }}',
     alias: '{{ $row->alias }}',
     is_superadmin: '{{$row->is_superadmin ? 1 : 0}}',
     changeName() {
     this.alias = this.name
          .toLowerCase()
          .replace(/[^a-z0-9\s-]/g, '')
          .trim()
          .replace(/\s+/g, '-')
          .replace(/-+/g, '-');
     },
     selectAll() {
          document.querySelectorAll('.module-permission').forEach((item) => {
               item.checked = true
          })
     },
     unselectAll() {
          document.querySelectorAll('.module-permission').forEach((item) => {
               item.checked = false
          })
     }
}">
     <div class="lg:max-w-xl flex-1">
          <div class="space-y-5">
               <x-portal::form.input name="name" label="Name" placeholder="John Doe" type="text" required
               x-model="name" x-on:keyup="changeName" />
               <x-portal::form.input name="alias" label="Alias" placeholder="joh-doe" type="text" required
               x-model="alias"
               x-mask:dynamic="value => value
               .toLowerCase()
               .replace(/[^a-z0-9\s-]/g, '') 
               .trim()
               .replace(/\s+/g, '-') 
               .replace(/-+/g, '-') 
               " />
               <x-portal::form.group label="Superadmin" name="is_superadmin">
               <div class="flex gap-1 flex-col">
                    <x-portal::radio id="is_superadmin_yes" value="1" name="is_superadmin" x-model="is_superadmin" label="Yes"
                         required :checked="$row->is_superadmin" />
                    <x-portal::radio id="is_superadmin_no" value="0" name="is_superadmin" x-model="is_superadmin" label="No"
                         required :checked="!$row->is_superadmin" />
               </div>
               </x-portal::form.group>

               <div class="flex md:flex-row flex-col-reverse gap-3">
               <x-portal::button variant="outline"
                    href="{{ route_from_current('index') }}">Cancel</x-portal::button>
               <x-portal::button x-bind:loading="submitted" type="submit">Submit</x-portal::button>
               </div>
          </div>
     </div>

     <div class="flex-1" x-show="Number(is_superadmin)==0" x-cloak>
          <h4 class="text-lg font-medium mb-4">Permission</h4>
          <x-portal::button variant="outline" size="sm" type="button" x-on:click="selectAll">
               Select All
          </x-portal::button>
          <x-portal::button variant="outline" size="sm" type="button" x-on:click="unselectAll">
               Unselect All
          </x-portal::button>

          <div class="flex gap-4 flex-wrap mt-6">
               @foreach ($modules as $module)
               <div class="w-[45%] md:w-[30%] mb-5" x-data="{
                    select($el) {
                         const value = $el.target.value
                         document.querySelectorAll(`.module-permission.permission-${value}`).forEach((item) => {
                              item.checked = $el.target.checked
                         })
                    }
               }">
                    <x-portal::form.item name="permission">
                         <x-portal::form.label class="flex gap-2">
                              {{ @$module['title_page'] ?: @$module['title'] }}
                              <x-portal::checkbox id="{{ $module['policy'] }}" value="{{ $module['policy'] }}"
                                   name="module[]" x-on:change="select" />
                         </x-portal::form.label>
                         <div class="flex flex-col gap-1">
                              @foreach ($module['permissions'] as $permission)
                                   <x-portal::checkbox id="{{ $permission }}" value="{{ $permission }}"
                                   name="permissions[]" label="{{ $permission }}"
                                   class="!font-normal module-permission permission-{{ $module['policy'] }}"
                                   :checked="in_array($permission, $row->permissions ?: [])" />
                              @endforeach
                         </div>
                    </x-portal::form.item>
               </div>
               @endforeach
          </div>
     </div>
</div>

@include('portal::script.mask')
