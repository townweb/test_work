
function submitForm(){
    // Call submit() method on <form id='myform'>
    document.getElementById('sort').submit();
}

document.addEventListener("DOMContentLoaded", () => {

    document.getElementById('selectSort').addEventListener("change", (event) => {
        submitForm();
    });

    var editTaskModal = document.getElementById('editTaskModal')
    editTaskModal.addEventListener('show.bs.modal', function (event) {

        var button = event.relatedTarget
        var taskId = button.getAttribute('data-id-task')

        editTaskModal.querySelector('.modal-title').textContent = 'Редактируем задачу ' + taskId;
        editTaskModal.querySelector('#editID').value=taskId;
        editTaskModal.querySelector('#editTaskName').value=document.querySelector('.tname-'+taskId).innerHTML;
        editTaskModal.querySelector('#editTaskEmail').value=document.querySelector('.temail-'+taskId).innerHTML;
        editTaskModal.querySelector('#editTaskText').innerHTML=document.querySelector('.ttext-'+taskId).innerHTML;
        if(document.querySelector('.tstatus-'+taskId).innerHTML != 'Активная'){
            editTaskModal.querySelector('#editStatusTask').checked = true;
        }


    })
});


