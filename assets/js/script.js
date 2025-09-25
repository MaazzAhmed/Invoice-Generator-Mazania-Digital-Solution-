// Select Js Code

function initializeSelect2(selectId) {
    $(document).ready(function () {
        $('#' + selectId).select2({
            placeholder: 'Select an option',
            allowClear: true,
            // Add more options here as needed
        });
    });
}

initializeSelect2('mySelect1');
initializeSelect2('mySelect2');
initializeSelect2('mySelect3');
initializeSelect2('mySelect4');








