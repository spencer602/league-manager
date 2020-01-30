var sortForm;
var selectInput;

function bodyLoaded(testvariable) {
    sortForm = document.getElementById("sortForm");
    selectInput = document.getElementById("sortBy");
    if (testvariable == "") { selectInput.value = 'name'; }
    else { selectInput.value = testvariable; }
}

function sortFormChanged() {
    sortForm.submit()
}