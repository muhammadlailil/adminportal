const mainTable = document.querySelector("select#table");
const controller = document.getElementById("module_controller");
const modulePath = document.getElementById("module_path");
const moduleName = document.getElementById("module_name");
const bodyTableStep2 = document.querySelector("#step2 .table-table tbody");
const bodyTableStep3 = document.querySelector("#step3 .table-table tbody");
const moduleIcon = document.getElementById("module_icon");
const buttonNext = document.querySelector('.btn-next')

let lastSelectedTableValue = null;
let currentStep = 1;
let baseTableColumns = [];

mainTable.addEventListener("change", function () {
    const tableValue = mainTable.value.split("_").join(" ");
    const name = tableValue
        ?.toLowerCase()
        .replace(/\b[a-z]/g, function (letter) {
            return letter.toUpperCase();
        })
        .replace(/ /g, " ");
    controller.value = tableValue
        ? `Admin${name.replace(/ /g, "")}Controller`
        : "";
    modulePath.value = tableValue
        ? tableValue?.toLowerCase().replace(/ /g, "-")
        : "";
    moduleName.value = name;
});

function goToStepTwo() {
    if (
        mainTable.value &&
        controller.value &&
        modulePath.value &&
        moduleName.value &&
        moduleIcon.value
    ) {
        let tableValue = mainTable.value;
        if (tableValue !== lastSelectedTableValue) {
            loadTableColumns(tableValue).then(async (resp) => {
                const response = await resp.json();
                baseTableColumns = response.data;
                for (let [i, obj] of baseTableColumns.entries()) {
                    if (!["id", "created_at", "updated_at"].includes(obj)) {
                        bodyTableStep2.insertAdjacentHTML(
                            "beforeend",
                            `<tr>
                                <th>
                                    <input type="text" class="form-control input-table input_label_form_table" value="${ucworld(
                                        obj
                                    )}" name="table_label[]">
                                </th>
                                <th>
                                    <input type="text" class="form-control input-table input_name_form_table" value="${obj}" name="table_name[]">
                                </th>
                                <th>
                                    <input type="text" class="form-control input-table input_join_form_table" name="table_join[]">
                                </th>
                                <th>
                                    <input type="text" class="form-control input-table input_join_name_form_table" name="table_join_relation[]">
                                </th>
                                <th>
                                    <button class="btn btn-danger btn-sm btn-delete-table-form w-100 justify-content-center"  type="button">Hapus</button>
                                </th>
                            </tr>`
                        );
                    }
                }
                appendRowStep3()

                listener();
            });
        }
        lastSelectedTableValue = mainTable.value;
        if (baseTableColumns) {
            goToTab("#step2");
            currentStep = 2;
        }
    } else {
        goToTab("#step1");
        currentStep = 1;
    }
}

function goToStepThree(){
    if (
        mainTable.value &&
        controller.value &&
        modulePath.value &&
        moduleName.value &&
        moduleIcon.value
    ) {
        let tableValue = mainTable.value;
        if (tableValue !== lastSelectedTableValue) {
            document.getElementById("step2-tab").click();
        }else{
            goToTab("#step3");
            currentStep = 3;
            setTimeout(()=>{
                buttonNext.innerHTML = 'SUBMIT'
                buttonNext.setAttribute('type',"submit")
                buttonNext.removeAttribute('onclick')
            },50)
        }
    }else {
        goToTab("#step1");
        currentStep = 1;
    }
}

function appendRowStep3(){
    for (let [i, obj] of baseTableColumns.entries()) {
        if (!["id", "created_at", "updated_at"].includes(obj)) {
            bodyTableStep3.insertAdjacentHTML(
                "beforeend",
                ` <tr>
                    <th>
                        <input type="text" class="form-control input-table input_label_form_table" value="${ucworld(obj)}" name="form_label[]">
                    </th>
                    <th>
                        <input type="text" class="form-control input-table input_name_form_table" value="${obj}" name="form_name[]">
                    </th>
                    <th>
                        <select id="" class="form-control input-table form-select" name="form_type[]">
                            <option>text</option>
                            <option>file</option>
                            <option>foto</option>
                            <option>email</option>
                            <option>number</option>
                            <option>password</option>
                            <option>checkbox</option>
                            <option>time</option>
                            <option>date</option>
                            <option>datetime</option>
                            <option>googlemaps</option>
                            <option>hidden</option>
                            <option>money</option>
                            <option>radio</option>
                            <option>select</option>
                            <option>selectsearch</option>
                            <option>textarea</option>
                            <option>wysiwyg</option>
                        </select>
                    </th>
                    <th>
                        <input type="text" class="form-control input-table" value="required|min:3|max:150" name="rules[]">
                    </th>
                    <th>
                        <input type="text" class="form-control input-table" value="" name="rules_create[]">
                    </th>
                    <th>
                        <input type="text" class="form-control input-table" value="" name="rules_update[]">
                    </th>
                    <th>
                        <button class="btn btn-danger btn-sm w-100 btn-delete-table-form justify-content-center" type="button">Hapus</button>
                    </th>
                </tr>`
            );
        }
    }
    listenRulesValidation()
}
function goToTab(tab) {
    const element = document.querySelector(
        `#moduleGeneratorTabs a[href="${tab}"]`
    );
    bootstrap.Tab.getInstance(element).show();
}

function addMoreForm(){
    bodyTableStep3.insertAdjacentHTML(
        "beforeend",
        `<tr>
        <th>
            <input type="text" class="form-control input-table input_label_form_table" value="" name="form_label[]">
        </th>
        <th>
            <input type="text" class="form-control input-table input_name_form_table" value="" name="form_name[]">
        </th>
        <th>
            <select id="" class="form-control input-table form-select" name="form_type[]">
                <option>text</option>
                <option>file</option>
                <option>foto</option>
                <option>email</option>
                <option>number</option>
                <option>password</option>
                <option>checkbox</option>
                <option>time</option>
                <option>date</option>
                <option>datetime</option>
                <option>googlemaps</option>
                <option>hidden</option>
                <option>money</option>
                <option>radio</option>
                <option>select</option>
                <option>selectsearch</option>
                <option>textarea</option>
                <option>wysiwyg</option>
            </select>
        </th>
        <th>
            <input type="text" class="form-control input-table" value="required|min:3|max:150" name="rules[]">
        </th>
        <th>
            <input type="text" class="form-control input-table" value="" name="rules_create[]">
        </th>
        <th>
            <input type="text" class="form-control input-table" value="" name="rules_update[]">
        </th>
        <th>
            <button class="btn btn-danger btn-sm w-100 btn-delete-table-form justify-content-center" type="button">Hapus</button>
        </th>
    </tr>`
    );
    setTimeout(() => {
        listener()
        listenRulesValidation();
    }, 50);
}
function addMoreTable() {
    bodyTableStep2.insertAdjacentHTML(
        "beforeend",
        `<tr>
            <th>
                <input type="text" class="form-control input-table input_label_form_table" name="table_label[]">
            </th>
            <th>
                <input type="text" class="form-control input-table input_name_form_table" name="table_name[]">
            </th>
            <th>
                <input type="text" class="form-control input-table input_join_form_table" name="table_join[]">
            </th>
            <th>
                <input type="text" class="form-control input-table input_join_name_form_table" name="table_join_relation[]">
            </th>
            <th>
                <button class="btn btn-danger btn-sm btn-delete-table-form w-100 justify-content-center" type="button">Hapus</button>
            </th> 
        </tr>`
    );
    setTimeout(() => {
        listener();
    }, 50);
}

function ucworld(val) {
    return val.replace("_", " ").replace(/^([a-z])|\s+([a-z])/g, function ($1) {
        return $1.toUpperCase();
    });
}

function createSuggestion(el, label = false) {
    el.parentElement.querySelector("ul")?.remove();
    var suggestion = '<ul class="suggestion_module shadow-sm">';
    baseTableColumns.forEach((obj) => {
        let val = obj;
        if (label) {
            val = ucworld(val);
        }
        suggestion += "<li>" + val + "</li>";
    });
    suggestion += "</ul>";
    el.parentElement.insertAdjacentHTML("beforeend", suggestion);
    suggestSelectedListener();
}

function createSuggestionJoinColumTable(el) {
    var tableValue = el
        .closest("tr")
        .querySelector(".input_join_form_table").value;
    if (tableValue) {
        loadTableColumns(tableValue).then(async (resp) => {
            const response = await resp.json();
            el.parentElement.querySelector("ul")?.remove();
            var suggestion = '<ul class="suggestion_module shadow-sm">';
            response.data.forEach((obj) => {
                suggestion += "<li>" + obj + "</li>";
            });
            suggestion += "</ul>";
            el.parentElement.insertAdjacentHTML("beforeend", suggestion);
            suggestSelectedListener();
        });
    }
}
function createSuggestionListTable(el) {
    el.parentElement.querySelector("ul")?.remove();
    var suggestion = '<ul class="suggestion_module shadow-sm">';
    listTable.forEach((obj) => {
        suggestion += "<li>" + obj.name + "</li>";
    });
    suggestion += "</ul>";
    el.parentElement.insertAdjacentHTML("beforeend", suggestion);
    suggestSelectedListener();
}

function listener() {
    document.querySelectorAll(".btn-delete-table-form").forEach((item) => {
        item.addEventListener("click", function () {
            item.closest("tr")?.remove();
        });
    });

    document.querySelectorAll(".input_label_form_table").forEach((item) => {
        item.addEventListener("click", function () {
            createSuggestion(item, true);
        });
    });

    document.querySelectorAll(".input_name_form_table").forEach((item) => {
        item.addEventListener("click", function () {
            createSuggestion(item);
        });
    });

    document.querySelectorAll(".input_join_form_table").forEach((item) => {
        item.addEventListener("click", function () {
            createSuggestionListTable(item);
        });
    });

    document.querySelectorAll(".input_join_name_form_table").forEach((item) => {
        item.addEventListener("click", function () {
            createSuggestionJoinColumTable(item);
        });
    });
    document.querySelectorAll("#step2 input").forEach((item) => {
        item.addEventListener("blur", function () {
            setTimeout(() => {
                item.parentElement
                    .querySelector(".suggestion_module")
                    ?.remove();
            }, 100);
        });
    });
}

function suggestSelectedListener() {
    document.querySelectorAll(".suggestion_module li").forEach((item) => {
        item.addEventListener("click", function () {
            item
                .closest("ul")
                .parentElement.querySelector("input[type=text]").value =
                item.textContent;
            item.closest("ul")?.remove();
        });
    });
}

function next() {
    switch (currentStep) {
        case 1:
            document.getElementById("step2-tab").click();
            break;
        case 2:
            document.getElementById("step3-tab").click();
            break;
        default:
            break;
    }
}

function listenRulesValidation() {
    document
        .querySelectorAll('#step3 select[name="form_type[]"]')
        .forEach((item) => {
            item.addEventListener("change", function () {
                let validation = ['required']
                switch (item.value) {
                    case "text":
                        validation.push("min:3","max:150")
                        break;
                    case "file":
                        validation.push("mimes:pdf,doc,docx")
                        break;
                    case "foto":
                        validation.push("image","mimes:jpeg,png,jpg,gif")
                        break;
                    case "email":
                        validation.push("email")
                        break;
                    case "number":
                        validation.push("numeric")
                        break;
                    case "password":
                        validation.push("min:8","max:50","regex:/^.*(?=.{3,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/")
                        break;
                    case "checkbox":
                        break;
                    case "time":
                        break;
                    case "date":
                        validation.push("date")
                        break;
                    case "datetime":
                        validation.push("date")
                        break;
                    case "googlemaps":
                        break;
                    case "hidden":
                        break;
                    case "money":
                        break;
                    case "select":
                        break;
                    case "selectsearch":
                        break;
                    case "textarea":
                        break;
                    case "wysiwyg":
                        break;
                    default:
                        break;
                }
                item.closest('tr').querySelector('input[name="rules[]"]').value = validation.join("|")
            });
        });
}

document.querySelectorAll('#moduleGeneratorTabs a.nav-link').forEach((item)=>{
    item.addEventListener('click',function(){
        buttonNext.innerHTML = 'NEXT'
            buttonNext.setAttribute('type',"button")
            buttonNext.setAttribute('onclick','next()')
    })
})