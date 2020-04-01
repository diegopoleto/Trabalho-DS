function request(verb, token, email, url, body, callback) {
    var myHeaders = new Headers();
    var myInit;
    if (token != null){
        myHeaders.append("tokenPortal", token);
    }
    if (email != null){
        myHeaders.append("userId", email);
    }

    if (verb == 'GET') {
        var myInit = { method: 'GET',
            headers: myHeaders,
            mode: 'cors',
            cache: 'default'
        };
    }
    else {
        myHeaders.append('Content-Type', 'application/json');

        var myInit = { method: 'POST',
            headers: myHeaders,
            mode: 'cors',
            cache: 'default',
            body: JSON.stringify(body),
        };
    }

    var myRequest = new Request(url, myInit);

    fetch(myRequest)
    .then(function(response) {
        response.json().then(function(data) {
            callback(data);
        });
    })
    .catch(function(error) {
        console.log(error);
    });
}

function validateToken(tokenPortal, response, callback, callbackError) {
    if(tokenPortal != null && tokenPortal != ""){
        callback(response);
    }
    else {
        if (callbackError != null){
            callbackError();
        }
        else{
            console.log("token null");
        }
    }
}
