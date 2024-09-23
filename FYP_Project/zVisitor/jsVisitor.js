function chkVisitorVldAdd() {
    var vName = $('#visitorName').val();
    var vContact = $('#visitorContact').val();
    var vIC = $('#visitorIC').val();
    var vDate = $('#visitDate').val();
    var vTime = $('#visitTime').val();
    var vCP = $('#visitorCarpark').val();


    const form1 = document.getElementById('regVisitorForm');
    const formData1 = new FormData(form1);
    const phoneRegex = /^[0-9]{10,11}$/;


    if (vCP === "0" && vIC.length === 0 && vContact.length === 0 && vName.length === 0 && vDate.length === 0 && vTime === "0") {
        alert("All fields are required!");
        event.preventDefault();
        return false;
    } else if (vName.length === 0) {
        alert("Please enter visitor name!");
        event.preventDefault();
        return false;
    } else if (vContact.length === 0) {
        alert("Please enter visitor contact!");
        event.preventDefault();
        return false;
    } else if (vIC.length === 0) {
        alert("Please enter visitor IC!");
        event.preventDefault();
        return false;
    }else if (!/^\d{12}$/.test(vIC)) {
        alert("Please enter a valid 12-digit numeric visitor IC!");
        event.preventDefault();
        return false;
    } else if (vDate.length === 0) {
        alert("Please select visit date!");
        event.preventDefault();
        return false;
    } else if (vTime === "0") {
        alert("Please select visit time!");
        event.preventDefault();
        return false;
    } else if (vCP === "0") {
        alert("Please select your option!");
        event.preventDefault();
        return false;
    } else if (!phoneRegex.test(vContact) && vContact.length < 10) {
        alert("Please enter a correct Whatsapp Number! eg: 0123344556");
        event.preventDefault();
        return false;
    } else {
        form1.submit();
        return true;
    }

}


function chkUpdateSelect() {

    var checkboxes = document.getElementsByName('visitorID[]');
    var selectedID = [];

    const form1 = document.getElementById('visitor');
    const formData1 = new FormData(form1);

    // Iterate through checkboxes to find selected ones
    checkboxes.forEach(function (checkbox) {
        if (checkbox.checked) {
            selectedID.push(checkbox.value);
        }
    });

    // Check if any reservation is selected
    if (selectedID.length === 0) {
        alert('Please select at least one visitor to update status.');
        event.preventDefault();
        return false;
    }
    
}

function confirmDelete() {

    var checkboxes = document.getElementsByName('visitorID[]');
    var selectedID = [];

    const form1 = document.getElementById('visitor');
    const formData1 = new FormData(form1);

    // Iterate through checkboxes to find selected ones
    checkboxes.forEach(function (checkbox) {
        if (checkbox.checked) {
            selectedID.push(checkbox.value);
        }
    });

    // Check if any reservation is selected
    if (selectedID.length === 0) {
        alert('Please select at least one visitor to delete.');
        event.preventDefault();
        return false;
    }

    var userConfirmed = confirm('Are you sure you want to delete selected visitor?');

    if (userConfirmed) {
        form1.submit();
        return true;
    } else {
        alert('Delete canceled.');
        event.preventDefault();
        return false;
    }
}
