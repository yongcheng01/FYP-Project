function chkEcVldAdd() {
    var ecWhatsapp = $('#ecWhatsapp').val();
    var ecSecurity = $('#ecSecurity').val();
    var ecEmail = $('#ecEmail').val();
    var ecAddress = $('#ecAddress').val();


    const form1 = document.getElementById('ecAdd');
    const formData1 = new FormData(form1);
    const emailRegex = /\S+@\S+\.\S+/;
    const phoneRegex = /^[0-9]{10,11}$/;



    if (ecWhatsapp.length === 0 && ecEmail.length === 0 && ecAddress.length === 0 && ecSecurity.length === 0) {
        alert("All fields are required!");
        event.preventDefault();
        return false;
    }
    else if(ecWhatsapp.length === 0){
        alert("Please enter your whatsapp number!");
        event.preventDefault();
        return false;
    }
    else if(ecSecurity.length === 0){
        alert("Please enter your guard contact no!");
        event.preventDefault();
        return false;
    }
    else if(ecEmail.length === 0){
        alert("Please enter your email!");
        event.preventDefault();
        return false;
    }
    else if(ecAddress.length === 0){
        alert("Please enter your address!");
        event.preventDefault();
        return false;
    }
    else if(!phoneRegex.test(ecWhatsapp) && ecWhatsapp.length < 10){
        alert("Please enter a correct Whatsapp Number! eg: 0123344556");
        event.preventDefault();
        return false;
    }
    else if(!phoneRegex.test(ecSecurity) && ecSecurity.length < 10){
        alert("Please enter a correct Guard Contact Number! eg: 0123344556");
        event.preventDefault();
        return false;
    }
    else if(!emailRegex.test(ecEmail)){
        alert("Please enter a correct email format! eg: abc123@gmail.com");
        event.preventDefault();
        return false;
    }
    else{
        form1.submit();
        return true;
    }

}

function chkEcVldUpdate() {
    
    var ecWhatsapp = $('#ecWhatsapp').val();
    var ecSecurity = $('#ecSecurity').val();
    var ecEmail = $('#ecEmail').val();
    var ecAddress = $('#ecAddress').val();


    const form1 = document.getElementById('ecUpdateForm');
    const formData1 = new FormData(form1);
    const emailRegex = /\S+@\S+\.\S+/;
    const phoneRegex = /^[0-9]{10,11}$/;



    if (ecWhatsapp.length === 0 && ecEmail.length === 0 && ecAddress.length === 0 && ecSecurity.length === 0) {
        alert("All fields are required!");
        event.preventDefault();
        return false;
    }
    else if(ecWhatsapp.length === 0){
        alert("Please enter your whatsapp number!");
        event.preventDefault();
        return false;
    }
    else if(ecSecurity.length === 0){
        alert("Please enter your guard contact no!");
        event.preventDefault();
        return false;
    }
    else if(ecEmail.length === 0){
        alert("Please enter your email!");
        event.preventDefault();
        return false;
    }
    else if(ecAddress.length === 0){
        alert("Please enter your address!");
        event.preventDefault();
        return false;
    }
    else if(!phoneRegex.test(ecWhatsapp) && ecWhatsapp.length < 10){
        alert("Please enter a correct Whatsapp Number! eg: 0123344556");
        event.preventDefault();
        return false;
    }
    else if(!phoneRegex.test(ecSecurity) && ecSecurity.length < 10){
        alert("Please enter a correct Guard Contact Number! eg: 0123344556");
        event.preventDefault();
        return false;
    }
    else if(!emailRegex.test(ecEmail)){
        alert("Please enter a correct email format! eg: abc123@gmail.com");
        event.preventDefault();
        return false;
    }
    else{
        form1.submit();
        return true;
    }

}

function chkUpdateSelect() {

    var checkboxes = document.getElementsByName('ecID[]');
    var selectedID = [];

    const form1 = document.getElementById('ec');
    const formData1 = new FormData(form1);

    checkboxes.forEach(function (checkbox) {
        if (checkbox.checked) {
            selectedID.push(checkbox.value);
        }
    });

    if (selectedID.length === 0) {
        alert('Please select at least one emergency contact info to update.');
        event.preventDefault();
        return false;
    }
    
}


function confirmDelete() {


    var checkboxes = document.getElementsByName('ecID[]');
    var selectedID = [];

    const form1 = document.getElementById('ec');
    const formData1 = new FormData(form1);

    checkboxes.forEach(function (checkbox) {
        if (checkbox.checked) {
            selectedID.push(checkbox.value);
        }
    });

    if (selectedID.length === 0) {
        alert('Please select at least one emergency contact info to delete.');
        event.preventDefault();
        return false;
    }

    var userConfirmed = confirm('Are you sure you want to delete selected emergency contact?');

    if (userConfirmed) {
        form1.submit();
        return true;
    } else {
        alert('Delete canceled.');
        event.preventDefault();
        return false;
    }
}