function validateReservation() {
    var rDate = $('#reservationDate').val();
    var facilities = $('#facilities').val();
    var startTime = $('#reservationStartTime').val();
    var endTime = $('#reservationEndTime').val();
    
    const form1 = document.getElementById('reservationAdd');
    const formData1 = new FormData(form1);

    if(startTime === "0" && endTime === "0" && facilities.length === 0 && rDate.length === 0){
        alert("Please fill in require information!");
        event.preventDefault();
        return false;
    }else if(facilities.length === 0){
        alert("Please select facilities!");
        event.preventDefault();
        return false;
    }else if(rDate.length === 0){
        alert("Please choose the date!");
        event.preventDefault();
        return false;
    }else if(startTime === "0"){
        alert("Please select reservation start time!");
        event.preventDefault();
        return false;
    }else if(endTime === "0"){
        alert("Please select reservation end time!");
        event.preventDefault();
        return false;
    }else{
        form1.submit();
        return true;
    }
}


function confirmCancellation() {

    var checkboxes = document.getElementsByName('reservationID[]');
    var selectedReservations = [];

    const form1 = document.getElementById('reservation');
    const formData1 = new FormData(form1);

    // Iterate through checkboxes to find selected ones
    checkboxes.forEach(function (checkbox) {
        if (checkbox.checked) {
            selectedReservations.push(checkbox.value);
        }
    });

    // Check if any reservation is selected
    if (selectedReservations.length === 0) {
        alert('Please select at least one reservation to cancel.');
        event.preventDefault();    
        return false;
    }

    var userConfirmed = confirm('Are you sure you want to cancel selected reservations?');

    if (userConfirmed) {
        form1.submit();
        return true;
    } else {
        alert('Cancellation canceled.');
        event.preventDefault();    
        return false;
    }
}

