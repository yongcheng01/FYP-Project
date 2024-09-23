function chkAnnouncementVldAdd() {
    var aType = $('#announcementType').val();
    var aTitle = $('#announcementTitle').val();
    var aMSG = $('#announcementMSG').val();
    var condo = $('#condoID').val();


    const form1 = document.getElementById('announcementAdd');
    const formData1 = new FormData(form1);



    if (aType === "0" && aTitle.length === 0 && aMSG.length === 0 && condo.length === 0) {
        alert("All fields are required!");
        event.preventDefault();
        return false;
    }
    else if(aType === "0"){
        alert("Please select your announcement type!");
        event.preventDefault();
        return false;
    }
    else if(aTitle.length === 0){
        alert("Please enter your announcement title!");
        event.preventDefault();
        return false;
    }
    else if(aMSG.length === 0){
        alert("Please enter your announcment title!");
        event.preventDefault();
        return false;
    }
    else if(condo.length === 0){
        alert("Please select condominium!");
        event.preventDefault();
        return false;
    }
    else{
        form1.submit();
        return true;
    }

}

function chkAnnouncementVldUpdate() {
    var aType = $('#announcementType').val();
    var aTitle = $('#announcementTitle').val();
    var aMSG = $('#announcementMSG').val();
    var condo = $('#condoID').val();

    const form1 = document.getElementById('announceUpdateForm');
    const formData1 = new FormData(form1);


    if (aType === "0" && aTitle.length === 0 && aMSG.length === 0 && condo.length === 0) {
        alert("All fields are required!");
        event.preventDefault();
        return false;
    }
    else if(aType === "0"){
        alert("Please select your announcement type!");
        event.preventDefault();
        return false;
    }
    else if(aTitle.length === 0){
        alert("Please enter your announcement title!");
        event.preventDefault();
        return false;
    }
    else if(aMSG.length === 0){
        alert("Please enter your announcment title!");
        event.preventDefault();
        return false;
    }
    else if(condo.length === 0){
        alert("Please select condominium!");
        event.preventDefault();
        return false;
    }
    else{
        form1.submit();
        return true;
    }

}


function chkUpdateSelect() {

    var checkboxes = document.getElementsByName('announcementID[]');
    var selectedID = [];

    const form1 = document.getElementById('announcement');
    const formData1 = new FormData(form1);

    // Iterate through checkboxes to find selected ones
    checkboxes.forEach(function (checkbox) {
        if (checkbox.checked) {
            selectedID.push(checkbox.value);
        }
    });

    // Check if any reservation is selected
    if (selectedID.length === 0) {
        alert('Please select at least one announcement to update.');
        event.preventDefault();
        return false;
    }
    
}


function confirmDelete() {


    var checkboxes = document.getElementsByName('announcementID[]');
    var selectedID = [];

    const form1 = document.getElementById('announcement');
    const formData1 = new FormData(form1);

    // Iterate through checkboxes to find selected ones
    checkboxes.forEach(function (checkbox) {
        if (checkbox.checked) {
            selectedID.push(checkbox.value);
        }
    });

    // Check if any reservation is selected
    if (selectedID.length === 0) {
        alert('Please select at least one announcement to delete.');
        event.preventDefault();
        return false;
    }

    var userConfirmed = confirm('Are you sure you want to delete selected announcement?');

    if (userConfirmed) {
        form1.submit();
        return true;
    } else {
        alert('Delete canceled.');
        event.preventDefault();
        return false;
    }
}