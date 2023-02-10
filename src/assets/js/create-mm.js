const btnNewField = document.getElementById('add-new-field')
const listFieldBody = document.getElementById('list-field')
const defaultFieldNew = listFieldBody.innerHTML
deleteFieldListener()

btnNewField.addEventListener('click',function(){
    listFieldBody.insertAdjacentHTML("beforeend",defaultFieldNew)
    deleteFieldListener()
})

function deleteFieldListener(){
    listFieldBody.querySelectorAll('.btn-del-field').forEach((item)=>{
        item.addEventListener('click',function(){
            item.closest('tr').remove()
        })
    })
}