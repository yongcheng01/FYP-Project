function chkCompanyVldAdd() {
    var comName = $('#comName').val();
    var comContact = $('#comContact').val();
    var comEmail = $('#comEmail').val();
    var comAddress = $('#comAddress').val();
    var comFoundedDate = $('#comFoundedDate').val();
    var comCEO = $('#comCEO').val();


    const form1 = document.getElementById('companyAdd');
    const formData1 = new FormData(form1);
    const emailRegex = /\S+@\S+\.\S+/;
    const phoneRegex = /^[0-9]{10,11}$/;



    if (comName.length === 0 && comContact.length === 0 && comEmail.length === 0 && comAddress.length === 0 && comFoundedDate.length === 0 && comCEO.length === 0) {
        alert("All fields are required!");
        event.preventDefault();
        return false;
    }
    else if(comName.length === 0){
        alert("Please enter your company name!");
        event.preventDefault();
        return false;
    }
    else if(comContact.length === 0){
        alert("Please enter your contact no!");
        event.preventDefault();
        return false;
    }
    else if(comEmail.length === 0){
        alert("Please enter your email!");
        event.preventDefault();
        return false;
    }
    else if(comAddress.length === 0){
        alert("Please enter your company address!");
        event.preventDefault();
        return false;
    }
    else if(comFoundedDate.length === 0){
        alert("Please select your founded date!");
        event.preventDefault();
        return false;
    }
    else if(comCEO.length === 0){
        alert("Please enter your CEO name!");
        event.preventDefault();
        return false;
    }
    else if(!phoneRegex.test(comContact) && comContact.length < 10){
        alert("Please enter a correct contact number! eg: 0123344556");
        event.preventDefault();
        return false;
    }
    else if(!emailRegex.test(comEmail)){
        alert("Please enter a correct email format! eg: abc123@gmail.com");
        event.preventDefault();
        return false;
    }
    else{
        form1.submit();
        return true;
    }

}

function chkCompanyVldUpdate() {
    var comName = $('#comName').val();
    var comContact = $('#comContact').val();
    var comEmail = $('#comEmail').val();
    var comAddress = $('#comAddress').val();
    var comFoundedDate = $('#comFoundedDate').val();
    var comCEO = $('#comCEO').val();


    const form1 = document.getElementById('companyUpdate');
    const formData1 = new FormData(form1);
    const emailRegex = /\S+@\S+\.\S+/;
    const phoneRegex = /^[0-9]{10,11}$/;



    if (comName.length === 0 && comContact.length === 0 && comEmail.length === 0 && comAddress.length === 0 && comFoundedDate.length === 0 && comCEO.length === 0) {
        alert("All fields are required!");
        event.preventDefault();
        return false;
    }
    else if(comName.length === 0){
        alert("Please enter your company name!");
        event.preventDefault();
        return false;
    }
    else if(comContact.length === 0){
        alert("Please enter your contact no!");
        event.preventDefault();
        return false;
    }
    else if(comEmail.length === 0){
        alert("Please enter your email!");
        event.preventDefault();
        return false;
    }
    else if(comAddress.length === 0){
        alert("Please enter your company address!");
        event.preventDefault();
        return false;
    }
    else if(comFoundedDate.length === 0){
        alert("Please select your founded date!");
        event.preventDefault();
        return false;
    }
    else if(comCEO.length === 0){
        alert("Please enter your CEO name!");
        event.preventDefault();
        return false;
    }
    else if(!phoneRegex.test(comContact) && comContact.length < 10){
        alert("Please enter a correct contact number! eg: 0123344556");
        event.preventDefault();
        return false;
    }
    else if(!emailRegex.test(comEmail)){
        alert("Please enter a correct email format! eg: abc123@gmail.com");
        event.preventDefault();
        return false;
    }
    else{
        form1.submit();
        return true;
    }

}

function confirmDelete() {

    const form1 = document.getElementById('companyDelete');
    const formData1 = new FormData(form1);

    var userConfirmed = confirm('Are you sure you want to delete this company profile?');

    if (userConfirmed) {
        form1.submit();
        return true;
    } else {
        alert('Delete canceled.');
        event.preventDefault();    
        return false;
    }
}