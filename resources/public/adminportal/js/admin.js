document.addEventListener('alpine:init', () => {
     Alpine.data('admin', () => ({
          dialog: '',
          alertDialog: '',
          submited: false,
          crudForm: {
               title: 'Add New User',
               description: "Create new user here. Click save when you're done."
          },
          init() {
               this.watchInitialDialog()
               this.watchButtonDeleteConfirmation()
               this.watchButtonBulkActions()
          },
          watchInitialDialog() {
               switch (this.openDialog) {
                    case 'create-crud-form':
                         this.openCreateCrudForm(false)
                         break;
                    case 'update-crud-form':
                         this.toggleEditForm(false)
                         break;
                    default:
                         if(this.openDialog){
                              this.dialog = this.openDialog
                         }
                         break;
               }
          },
          openCreateCrudForm(reset = true) {
               const crudFormElement = document.querySelector('form#crudFormElement')
               this.toggleDialog('crud-form')
               this.crudForm = {
                    title: LANG.create_data_module.replace(':module', this.pageTitle),
                    description: LANG.create_data_module_description.replace(':module', this.pageTitle)
               }
               crudFormElement.setAttribute('action', this.createRoute)
               crudFormElement.querySelectorAll('[type="password"]').forEach((input) => {
                    input.setAttribute('required', true)
               })
               crudFormElement.querySelector('[name="_method"]')?.remove()
               if (reset) {
                    crudFormElement.reset()
                    crudFormElement.querySelectorAll('select[name]').forEach((select) => {
                         select.value = ""
                         select.dispatchEvent(new Event('change'));
                    })
               }
               window.dispatchEvent(new CustomEvent('openCreateCrudForm', {
                    alpine: this
               }));
          },
          toggleEditForm(row = null) {
               if (row && !row.uuid) {
                    window.dispatchEvent(new CustomEvent('toast', {
                         detail: {
                              message: 'The json is required uuid field',
                              variant: 'danger'
                         }
                    }))
                    return
               }
               this.menuOpen = false
               const crudFormElement = document.querySelector('form#crudFormElement')
               crudFormElement.insertAdjacentHTML('beforeend', '<input type="hidden" name="_method" value="PATCH">')
               this.toggleDialog('crud-form')
               this.crudForm = {
                    title: LANG.edit_module.replace(':module', this.pageTitle),
                    description: LANG.edit_data_module_description.replace(':module', this.pageTitle)
               }
               crudFormElement.setAttribute('action', this.updateRoute.replace(':uuid', row.uuid))
               crudFormElement.querySelectorAll('[name]').forEach((input) => {
                    const name = input.getAttribute('name')
                    const type = input.getAttribute('type')
                    if (type == 'password') {
                         input.removeAttribute('required')
                    }
                    if (row && row[name] != undefined) {
                         if (['radio', 'checkbox'].includes(type)) {
                              input.checked = false
                              if (input.value == row[name].toString()) {
                                   input.checked = true
                              }
                         } else {
                              input.value = row[name].toString()
                              input.dispatchEvent(new Event('change'));
                         }
                    }
               })
               window.dispatchEvent(new CustomEvent('toggleEditForm', {
                    detail: {
                         alpine: this,
                         ...row,
                    }
               }));
          },
          watchButtonDeleteConfirmation() {
               var _self = this
               document.querySelectorAll('[x-data-delete-confirmation]').forEach((button) => {
                    button.addEventListener('click', () => {
                         const uuid = button.getAttribute('x-data-delete-confirmation')
                         _self.toggleConfirmation('delete-confirmation')
                         document.getElementById('delete-confirmation-form').setAttribute('action', this.deleteRoute.replace(':uuid', uuid))
                    })
               })
          },
          watchButtonBulkActions() {
               var _self = this
               document.querySelectorAll('[x-data-bulk-action-confirmation]').forEach((button) => {
                    button.addEventListener('click', () => {
                         const selectedID = button.getAttribute('data-selected').split(',')
                         const action = button.getAttribute('data-action')
                         const label = button.getAttribute('data-label').toLowerCase().replace('selected', '').toUpperCase()
                         const dialog = button.getAttribute('data-dialog')
                         const variant = button.getAttribute('data-variant')
                         const dialogContent = dialog == 'default' ? document.getElementById('alert-dialog-bulk-action-confirmation') : document.getElementById(`alert-dialog-${dialog}`)
                         const submitButton = dialogContent.querySelector('button[type="submit"]')
                         const dialogForm = dialogContent.querySelector('form')
                         const title =  dialogForm.querySelector('h3.text-lg')
                         const description = dialogForm.querySelector('p.text-sm');
                         if(title){
                              title.innerHTML = `<strong>"${label}"</strong> ${selectedID.length} selected data ?`
                         }
                         if(description){
                              description.innerHTML = `The selected items will be <strong>"${label}"</strong>. Some actions maybe cannot be undone.`
                         }
                         if (variant == 'danger') {
                              submitButton.style.backgroundColor = 'hsl(var(--destructive))'
                         } else {
                              submitButton.style.backgroundColor = 'hsl(var(--primary))'
                         }
                         dialogForm.querySelector('.input')?.remove()
                         var append = `<div class="input"><input type="hidden" name="action" value="${action}">`
                         for(var id of selectedID){
                              append += `<input type="hidden" name="id[]" value="${id}">`
                         }
                         dialogForm.insertAdjacentHTML('beforeend',`${append}</div>`)
                         
                         _self.toggleConfirmation(dialog == 'default' ? 'bulk-action-confirmation' : dialog)
                    })
               })
          },
          toggleDialog(name) {
               if (this.dialog) {
                    this.dialog = ''
               } else {
                    this.dialog = name
               }
          },
          toggleConfirmation(name) {
               if (this.alertDialog) {
                    this.alertDialog = ''
               } else {
                    this.alertDialog = name
               }
          }

     }))
})