document.addEventListener("DOMContentLoaded", function () {
     document.querySelectorAll(".sidebar .nav-link").forEach(function (e) {
          e.addEventListener("click", function (t) {
               let n = e.nextElementSibling,
                    o = e.parentElement;
               if (n) {
                    t.preventDefault();
                    let e = new bootstrap.Collapse(n);
                    if (n.classList.contains("show")) e.hide();
                    else {
                         o.classList.contains("show")
                              ? o.classList.remove("show")
                              : o.classList.add("show"),
                              e.show();
                         var a = o.parentElement.querySelector(".submenu.show");
                         a &&
                              (new bootstrap.Collapse(a),
                                   a.parentElement.classList.remove("show"));
                    }
               }
          });
     });
});
var tooltipTriggerList = [].slice.call(
     document.querySelectorAll('[data-bs-toggle="tooltip"]')
),
     tooltipList = tooltipTriggerList.map(function (e) {
          return new bootstrap.Tooltip(e);
     });
function Confirmation(e, t, n = "POST") {
     const o = document.getElementById("confirmation");
     (o.querySelector(".message").innerHTML = e),
          o.querySelector("form").setAttribute("action", t),
          (o
               .querySelector("form")
               .querySelector('input[name="_method"]').value = n),
          new bootstrap.Modal(o).toggle();
}
function Confirm(e) {
     const t = document.getElementById("modal-confirm");
     return (
          (t.querySelector(".message").innerHTML = e),
          new bootstrap.Modal(t).toggle(),
          t
     );
}
function Information(e, t = "success") {
     const n = document.getElementById("alert-information"),
          o = n.querySelector("img"),
          a = o.getAttribute("src");
     (n.querySelector(".message").innerHTML = e),
          o.setAttribute("src", `${a}adminportal/icons/${t}.svg`),
          new bootstrap.Modal(n).toggle();
}
document.querySelectorAll(".input-password .icon").forEach((e) => {
     e.addEventListener("click", function () {
          let t = e.parentElement.querySelector("input");
          "password" == t.getAttribute("type")
               ? (t.setAttribute("type", "text"),
                    e.classList.remove("icon-eye"),
                    e.classList.add("icon-eye-slash"))
               : (t.setAttribute("type", "password"),
                    e.classList.add("icon-eye"),
                    e.classList.remove("icon-eye-slash"));
     });
}),
     setTimeout(() => {
          document.querySelectorAll(".nice-select2").forEach((e) => {
               const t = e.classList.contains("searchable");
               window[`select_${e.getAttribute("name")}`] = NiceSelect.bind(e, {
                    searchable: t,
               });
          });
     }, 100),
     document.querySelectorAll(".form-image-upload input").forEach((e) => {
          e.addEventListener("change", function () {
               const t = URL.createObjectURL(this.files[0]);
               e.parentElement.style.backgroundImage = `url(${t})`;
          });
     }),
     setTimeout(() => {
          document
               .getElementById("input_checkall_datatable")
               ?.addEventListener("change", function () {
                    document
                         .querySelectorAll(".datatable .table-checkbox")
                         .forEach((e) => {
                              e.checked = this.checked;
                         }),
                         tableCeklistHandling();
               }),
               document
                    .querySelectorAll(".datatable .table-checkbox")
                    .forEach((e) => {
                         e.addEventListener("click", function () {
                              tableCeklistHandling();
                         });
                    });
     }),
     document
          .getElementById("btn-sidebar-toggle")
          ?.addEventListener("click", function () {
               const e = document.querySelector("body");
               e.classList.contains("sidebar-collapse")
                    ? (e.classList.toggle("sidebar-collapse"),
                         e.classList.add("sidebar-hide"))
                    : (e.classList.toggle("sidebar-collapse"),
                         e.classList.remove("sidebar-hide"));
          }),
     document.querySelectorAll('[data-toggle="confirmation"]').forEach((e) => {
          e.addEventListener("click", function () {
               Confirmation(
                    e.getAttribute("data-message"),
                    e.getAttribute("data-action"),
                    e.getAttribute("data-method") || "POST"
               );
          });
     }),
     document.querySelectorAll("div.select-icons").forEach((e) => {
          e.querySelectorAll(".list li").forEach((e) => {
               const t = e.innerHTML;
               (e.innerHTML = ""),
                    e.insertAdjacentHTML(
                         "beforeend",
                         `<i class="isax ${t} select-icon-item"></i>${t}`
                    );
          });
     }),
     document.querySelectorAll("select.select-icons").forEach((e) => {
          e.addEventListener("change", function () {
               let t = e.parentElement.querySelector(
                    "div.select-icons .current"
               ),
                    n = t.innerHTML;
               (t.innerHTML = ""),
                    t.insertAdjacentHTML(
                         "beforeend",
                         `<i class="isax ${n} select-icon-item"></i>${n}`
                    );
          });
     });
const dataTableForm = document.getElementById("form-data-table");
function tableCeklistHandling() {
     document.querySelectorAll(".datatable .table-checkbox:checked").length
          ? (document
               .getElementById("btn-bulk-action")
               .classList.remove("d-none"),
               document.getElementById("btn-bulk-action").classList.add("d-flex"),
               document.getElementById("btn-add-table").classList.add("d-none"))
          : (document.getElementById("btn-bulk-action").classList.add("d-none"),
               document
                    .getElementById("btn-add-table")
                    .classList.remove("d-none"));
}
document.querySelectorAll("#btn-bulk-action .action").forEach((e) => {
     e.addEventListener("click", function () {
          if (
               document.querySelectorAll(".datatable .table-checkbox:checked")
                    .length
          ) {
               const t = e.getAttribute("data-action") ?? "delete";
               dataTableForm
                    .querySelector('input[name="bulk_action"]')
                    ?.remove(),
                    dataTableForm.insertAdjacentHTML(
                         "beforeend",
                         `<input type="hidden" name="bulk_action" value="${t}"/>`
                    ),
                    Confirm(`Are you sure you want to ${t} the selected data?`)
                         .querySelector("button.btn-oke")
                         .addEventListener("click", function () {
                              dataTableForm.submit();
                         });
          } else Information("Please select at least one data !", "warning");
     });
});