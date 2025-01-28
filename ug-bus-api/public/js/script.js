$('#deleteModal').on('show.bs.modal', function (event) {
    let button = $(event.relatedTarget)
    let id = button.data('id')
    let action = button.data('action')

    let modal = $(this)
    modal.find('.modal-body #deleteid').val(id)
    modal.find('.modal-body #deleteform').attr('action', action);
});
$('#confirmModal').on('show.bs.modal', function (event) {
    let button = $(event.relatedTarget)
    let id = button.data('id')
    let text = button.data('text')
    let action = button.data('action')
    console.log(text)
    if(!text) {
        text = "Do you confirm this action?"
    }

    let modal = $(this)
    modal.find('.modal-body #confirmid').val(id)
    modal.find('.modal-body #text').text(text);
    modal.find('.modal-body #confirmform').attr('action', action);
})

// let select_box_element = document.querySelector('#select_box');
// dselect(select_box_element, {
//     search: true
// });