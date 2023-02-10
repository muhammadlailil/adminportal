document.addEventListener("DOMContentLoaded", function () {
    /**
     * sidebar collapse function
     */
    document.querySelectorAll(".sidebar .nav-link").forEach(function (element) {
        element.addEventListener("click", function (e) {
            let nextEl = element.nextElementSibling;
            let parentEl = element.parentElement;

            if (nextEl) {
                e.preventDefault();
                let mycollapse = new bootstrap.Collapse(nextEl);

                if (nextEl.classList.contains("show")) {
                    mycollapse.hide();
                } else {
                    if (parentEl.classList.contains("show")) {
                        parentEl.classList.remove("show");
                    } else {
                        parentEl.classList.add("show");
                    }
                    mycollapse.show();
                    var opened_submenu =
                        parentEl.parentElement.querySelector(".submenu.show");
                    if (opened_submenu) {
                        new bootstrap.Collapse(opened_submenu);
                        opened_submenu.parentElement.classList.remove("show");
                    }
                }
            }
        });
    });
});

/**
 * tooltip init
 */
var tooltipTriggerList = [].slice.call(
    document.querySelectorAll('[data-bs-toggle="tooltip"]')
);
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
});

/**
 * password eye
 */
document.querySelectorAll(".input-password .icon").forEach((item) => {
    item.addEventListener("click", function () {
        let input = item.parentElement.querySelector("input");
        if (input.getAttribute("type") == "password") {
            input.setAttribute("type", "text");
            item.classList.remove("icon-eye");
            item.classList.add("icon-eye-slash");
        } else {
            input.setAttribute("type", "password");
            item.classList.add("icon-eye");
            item.classList.remove("icon-eye-slash");
        }
    });
});

/**
 * nice-select2
 */
document.querySelectorAll(".nice-select2").forEach((item) => {
    const searchable = item.classList.contains("searchable");
    window[`select_${item.getAttribute('name')}`] = NiceSelect.bind(item, { searchable: searchable });
});

/**
 * form-image-upload
 */
document.querySelectorAll(".form-image-upload input").forEach((item) => {
    item.addEventListener("change", function () {
        const url = URL.createObjectURL(this.files[0]);
        item.parentElement.style.backgroundImage = `url(${url})`;
    });
});

setTimeout(() => {
    /**
     * cekall datatable
     * add timeout for rendering jstable
     */
    document
        .getElementById("input_checkall_datatable")
        ?.addEventListener("change", function () {
            document
                .querySelectorAll(".datatable .table-checkbox")
                .forEach((item) => {
                    item.checked = this.checked
                });
            tableCeklistHandling();
        });

     document
        .querySelectorAll(".datatable .table-checkbox")
        .forEach((item) => {
            item.addEventListener('click',function(){
                tableCeklistHandling();
            })
        });
});

/**
 * Sidebar collapse
 */
document
    .getElementById("btn-sidebar-toggle")
    ?.addEventListener("click", function () {
        const body = document.querySelector("body");
        if (body.classList.contains("sidebar-collapse")) {
            body.classList.toggle("sidebar-collapse");
            body.classList.add("sidebar-hide");
        } else {
            body.classList.toggle("sidebar-collapse");
            body.classList.remove("sidebar-hide");
        }
    });

document.querySelectorAll('[data-toggle="confirmation"]').forEach((item) => {
    item.addEventListener("click", function () {
        Confirmation(
            item.getAttribute("data-message"),
            item.getAttribute("data-action"),
            item.getAttribute("data-method") || 'POST',
        );
    });
});

function Confirmation(message, action, method = "POST") {
    const modal = document.getElementById("confirmation");
    modal.querySelector(".message").innerHTML = message;
    modal.querySelector("form").setAttribute("action", action);
    modal.querySelector("form").querySelector('input[name="_method"]').value = method
    new bootstrap.Modal(modal).toggle();
}

function Confirm(message) {
    const modal = document.getElementById("modal-confirm");
    modal.querySelector(".message").innerHTML = message;
    new bootstrap.Modal(modal).toggle();
    return modal;
}

// alert-information
function Information(message,type='success'){
    const modal = document.getElementById("alert-information");
    const image = modal.querySelector('img')
    const baseAsset = image.getAttribute('src')
    modal.querySelector(".message").innerHTML = message;
    image.setAttribute('src',`${baseAsset}adminportal/icons/${type}.svg`)
    new bootstrap.Modal(modal).toggle();
}

document.querySelectorAll('div.select-icons').forEach((item)=>{
    item.querySelectorAll('.list li').forEach((row)=>{
        const icon = row.innerHTML
        row.innerHTML = ''
        row.insertAdjacentHTML("beforeend",`<i class="isax ${icon} select-icon-item"></i>${icon}`)
    })
})

document.querySelectorAll('select.select-icons').forEach((item)=>{
    item.addEventListener('change',function(){
        let currentSelected = item.parentElement.querySelector('div.select-icons .current')
        let icon = currentSelected.innerHTML
        currentSelected.innerHTML = '';
        currentSelected.insertAdjacentHTML("beforeend",`<i class="isax ${icon} select-icon-item"></i>${icon}`)
    })
})

const dataTableForm = document.getElementById('form-data-table')
document.querySelectorAll('#btn-bulk-action .action').forEach((item)=>{
    item.addEventListener('click',function(){
        if(document.querySelectorAll(".datatable .table-checkbox:checked").length){
            const action = item.getAttribute('data-action') ?? 'delete'
            dataTableForm.querySelector('input[name="bulk_action"]')?.remove()
            dataTableForm.insertAdjacentHTML("beforeend",`<input type="hidden" name="bulk_action" value="${action}"/>`)
            Confirm(`Are you sure you want to ${action} the selected data?`).querySelector('button.btn-oke').addEventListener('click',function(){
                dataTableForm.submit()
            })
        }else{
            Information("Please select at least one data !","warning")
        }
    })
})


function tableCeklistHandling(){
   if(document.querySelectorAll(".datatable .table-checkbox:checked").length){
        document.getElementById('btn-bulk-action').classList.remove('d-none')
        document.getElementById('btn-add-table').classList.add('d-none')
   }else{
    document.getElementById('btn-bulk-action').classList.add('d-none')
    document.getElementById('btn-add-table').classList.remove('d-none')
   }
}