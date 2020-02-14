$(document).ready(function () {
    var editSection = $('#edit-section');
    var showSection = $('#show-section');

    if (editSection.length && showSection.length) {
        $('.show-edit-toggler').click(function (e) {
            e.preventDefault();
            editSection.toggleClass('show-edit-visible');
            showSection.toggleClass('show-edit-visible');
        });
    } else {
        console.error('edit and show sections are not detected');
    }
});