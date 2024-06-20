document.getElementById("myform").addEventListener("submit", function(event) {
    event.preventDefault();
    console.log("abc")
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;
    const apiUrl = 'http://localhost:3000/api/accounts';
    const requestData = {
        email: email,
        password: password
    };
    
    fetch(apiUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(requestData)
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
    })
    .catch(error => {
        console.error('Error sending data:', error);
    });
    
});