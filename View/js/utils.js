function storeUserData(data) {
    window.localStorage.setItem("idPortal", data.email);
    window.localStorage.setItem("emailPortal", data.email);
    window.localStorage.setItem("nomePortal", data.nome);
    window.localStorage.setItem("sobrenomePortal", data.sobrenome);
    if(typeof data.tipo != "undefined"){
        window.localStorage.setItem("tipoPortal", data.tipo);
    }
    else{
        window.localStorage.setItem("tipoPortal", data.tipoDeUsuario);
    }
    window.localStorage.setItem("entidades", JSON.stringify(data.entidades));
    window.localStorage.setItem("tokenPortal", data.tokenPortal);
}
function removeUserData() {
    window.localStorage.removeItem("idPortal");
    window.localStorage.removeItem("emailPortal");
    window.localStorage.removeItem("nomePortal");
    window.localStorage.removeItem("sobrenomePortal");
    window.localStorage.removeItem("tipoPortal");
    window.localStorage.removeItem("entidadesPortal");
    window.localStorage.removeItem("tokenPortal");
}
function pegarDadosForm(formulario) {
    var paramObj = {};
    $.each($(formulario).serializeArray(), function(_, kv) {
        if (paramObj.hasOwnProperty(kv.name)) {
            paramObj[kv.name] = $.makeArray(paramObj[kv.name]);
            paramObj[kv.name].push(kv.value);
        }
        else {
            paramObj[kv.name] = kv.value;
        }
    });
    return paramObj;
}

$("header nav a#sair").on("click", function (event) {
    event.preventDefault();
    removeUserData();
    pathServer = 'http://165.227.86.76/projetoDS/View/';

    window.location.replace(pathServer + "welcome.php");
});
