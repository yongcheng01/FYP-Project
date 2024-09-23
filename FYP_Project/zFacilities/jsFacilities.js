function chkFacilitiesVldAdd() {
    var fStatus = $('#facilitiesStatus').val();
    var fType = $('#facilitiesType').val();
    var fImage = $('#facilitiesImage').val();
    var cID = $('#condo').val();


    const form1 = document.getElementById('addFacilitiesForm');
    const formData1 = new FormData(form1);



    if (fStatus === "0" && fType === "0" && fImage.length === 0 && cID === "0") {
        alert("All fields are required!");
        event.preventDefault();
        return false;
    }
    else if(fStatus === "0"){
        alert("Please select your facilities status!");
        event.preventDefault();
        return false;
    }
    else if(fType === "0"){
        alert("Please select faciities type!");
        event.preventDefault();
        return false;
    }
    else if(fImage.length === 0){
        alert("Please upload faciities image!");
        event.preventDefault();
        return false;
    }
    else if(cID === "0"){
        alert("Please select an condominium!");
        event.preventDefault();
        return false;
    }
    else{
        form1.submit();
        return true;
    }

}



function chkUpdateSelect() {

    var checkboxes = document.getElementsByName('facilitiesID[]');
    var selectedID = [];

    const form1 = document.getElementById('facilities');
    const formData1 = new FormData(form1);

    // Iterate through checkboxes to find selected ones
    checkboxes.forEach(function (checkbox) {
        if (checkbox.checked) {
            selectedID.push(checkbox.value);
        }
    });

    // Check if any reservation is selected
    if (selectedID.length === 0) {
        alert('Please select at least one facilities to update.');
        event.preventDefault();
        return false;
    }
    
}


function confirmDelete() {


    var checkboxes = document.getElementsByName('facilitiesID[]');
    var selectedID = [];

    const form1 = document.getElementById('facilities');
    const formData1 = new FormData(form1);

    // Iterate through checkboxes to find selected ones
    checkboxes.forEach(function (checkbox) {
        if (checkbox.checked) {
            selectedID.push(checkbox.value);
        }
    });

    // Check if any reservation is selected
    if (selectedID.length === 0) {
        alert('Please select at least one facilities to delete.');
        event.preventDefault();
        return false;
    }

    var userConfirmed = confirm('Are you sure you want to delete selected facilities?');

    if (userConfirmed) {
        form1.submit();
        return true;
    } else {
        alert('Delete canceled.');
        event.preventDefault();
        return false;
    }
}


