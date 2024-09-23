function chkCondoVldAdd() {
    var cName = $('#condoName').val();
    var cBlock = $('#condoBlock').val();
    var cFloor = $('#condoFloor').val();
    var cRoom = $('#roomPerFloor').val();
    var cCarpark = $('#carparkFloor').val();
    


    const form1 = document.getElementById('condoAdd');
    const formData1 = new FormData(form1);


    if (cName.length === 0 && cFloor.length === 0 && cRoom.length === 0 && cBlock === "0" && cCarpark.length === 0) {
        alert("All fields are required!");
        event.preventDefault();
        return false;
    } else if (cName.length === 0) {
        alert("Please enter condominium name!");
        event.preventDefault();
        return false;
    } else if (cBlock === "0") {
        alert("Please select condominium block!");
        event.preventDefault();
        return false;
    } else if (cFloor.length === 0) {
        alert("Please enter condominium floor!");
        event.preventDefault();
        return false;
    } else if (isNaN(cFloor) || cFloor % 1 !== 0 || cFloor === 0) {
        alert("Please enter a valid numeric condominium floor greater than 0!");
        event.preventDefault();
        return false;
    } else if (cRoom.length === 0) {
        alert("Please enter condominium room!");
        event.preventDefault();
        return false;
    } else if (isNaN(cRoom) || cRoom % 1 !== 0 || cRoom === 0) {
        alert("Please enter a valid numeric condominium room greater than 0!");
        event.preventDefault();
        return false;
    } else if (cCarpark.length === 0) {
        alert("Please enter condominium carpark floor!");
        event.preventDefault();
        return false;
    } else if (isNaN(cCarpark) || cCarpark % 1 !== 0 || cCarpark === 0) {
        alert("Please enter a valid numeric condominium carpark floor greater than 0!");
        event.preventDefault();
        return false;
    } else {
        form1.submit();
        return true;
    }

}


function chkCondoVldUpdate() {
    var cName = $('#condoName').val();
    var cBlock = $('#condoBlock').val();
    var cFloor = $('#condoFloor').val();
    var cRoom = $('#roomPerFloor').val();
    var cCarpark = $('#carparkFloor').val();

    const form1 = document.getElementById('condoUpdate');
    const formData1 = new FormData(form1);


    if (cName.length === 0 && cFloor.length === 0 && cRoom.length === 0 && cBlock === "0") {
        alert("All fields are required!");
        event.preventDefault();
        return false;
    } else if (cName.length === 0) {
        alert("Please enter condominium name!");
        event.preventDefault();
        return false;
    } else if (cBlock === "0") {
        alert("Please select condominium block!");
        event.preventDefault();
        return false;
    } else if (cFloor.length === 0) {
        alert("Please enter condominium floor!");
        event.preventDefault();
        return false;
    } else if (isNaN(cFloor) || cFloor % 1 !== 0 || cFloor === 0) {
        alert("Please enter a valid numeric condominium floor greater than 0!");
        event.preventDefault();
        return false;
    } else if (cRoom.length === 0) {
        alert("Please enter condominium room!");
        event.preventDefault();
        return false;
    } else if (isNaN(cRoom) || cRoom % 1 !== 0 || cRoom === 0) {
        alert("Please enter a valid numeric condominium room greater than 0!");
        event.preventDefault();
        return false;
    } else if (cCarpark.length === 0) {
        alert("Please enter condominium carpark floor!");
        event.preventDefault();
        return false;
    } else if (isNaN(cCarpark) || cCarpark % 1 !== 0 || cCarpark === 0) {
        alert("Please enter a valid numeric condominium carpark floor greater than 0!");
        event.preventDefault();
        return false;
    } else {
        form1.submit();
        return true;
    }

}


function chkUpdateSelect() {

    var checkboxes = document.getElementsByName('condoID[]');
    var selectedID = [];

    const form1 = document.getElementById('condo');
    const formData1 = new FormData(form1);

    // Iterate through checkboxes to find selected ones
    checkboxes.forEach(function (checkbox) {
        if (checkbox.checked) {
            selectedID.push(checkbox.value);
        }
    });

    // Check if any reservation is selected
    if (selectedID.length === 0) {
        alert('Please select at least one condo to update.');
        event.preventDefault();
        return false;
    }
    
}



function confirmDelete() {

    var checkboxes = document.getElementsByName('condoID[]');
    var selectedID = [];

    const form1 = document.getElementById('condo');
    const formData1 = new FormData(form1);

    // Iterate through checkboxes to find selected ones
    checkboxes.forEach(function (checkbox) {
        if (checkbox.checked) {
            selectedID.push(checkbox.value);
        }
    });

    // Check if any reservation is selected
    if (selectedID.length === 0) {
        alert('Please select at least one condo to delete.');
        event.preventDefault();
        return false;
    }

    var userConfirmed = confirm('Are you sure you want to delete selected condo?');

    if (userConfirmed) {
        form1.submit();
        return true;
    } else {
        alert('Delete canceled.');
        event.preventDefault();
        return false;
    }
}