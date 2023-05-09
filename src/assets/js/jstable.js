// https://jstable.github.io/options.html
const jsTableElement = document.getElementById('js-datatable')
let jstable = new JSTable(jsTableElement, {
     sortable: false,
     searchable: false,
     perPageSelect: false,
     perPage: jsTableElement.getAttribute("data-limit") ?? 10,
     labels: {
          noRows: jsTableElement.getAttribute('data-empty'),
          info: "{start} - {end} From {rows}",
          loading: "Loading...",
          infoFiltered: "{start} - {end} From {rows}",
     },
     serverSide: true,
     ajax: jsTableElement.getAttribute("data-url"),
     ajaxParams: Object.fromEntries(queryParams().entries()),
});

/**
 * jstable search from another element
 */
const page = queryParams().get("page");
if (page && jstable) {
     setTimeout(() => {
          jstable.paginate(Number(page));
     }, 550);
}
document
     .querySelectorAll(".header-datatable .input-search input")
     .forEach((search) => {
          search.addEventListener("keypress", function (e) {
               if (e.key === "Enter") {
                    if ("URLSearchParams" in window) {
                         var param = queryParams();
                         param.set("search", search.value);
                         param.set("page", 1);
                         window.history.replaceState(
                              null,
                              null,
                              `?${param.toString()}`
                         );
                         setParamExport()
                    }
                    jstable.config.ajaxParams = {
                         search : search.value,
                    }
                    jstable.search(search.value);
                    jstable.paginate(1);
               }
          });
     });
jstable.on("update", function () {
     setTimeout(() => {
          document.querySelectorAll('[data-toggle="confirmation"]').forEach((item) => {
               item.addEventListener("click", function () {
                    Confirmation(
                         item.getAttribute("data-message"),
                         item.getAttribute("data-action"),
                         item.getAttribute("data-method") || 'POST',
                    );
               });
          });
     }, 1000);
     if (document.querySelector('#js-table tbody tr .dt-message')) {
          jsTableElement.classList.remove('table-has-data')
     } else {
          jsTableElement.classList.add('table-has-data')
     }
});


function queryParams() {
     return new URLSearchParams(window.location.search);
 }