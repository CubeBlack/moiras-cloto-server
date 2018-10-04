page = {};
page.comList = [];
///--------- pegar valores da URL
var query = location.search.slice(1);
var partes = query.split('&');
var data = {};
partes.forEach(function (parte) {
    var chaveValor = parte.split('=');
    var chave = chaveValor[0];
    var valor = chaveValor[1];
    data[chave] = valor;
});

//console.log(data);
///
page.inputEnter = function (event) {
    var keynum;
    if (window.event) { //IE
        keynum = event.keyCode
    } else if (event.which) { // Netscape/Firefox/Opera AQUI ESTAVA O PEQUENINO ERRO ao invés de "e." é "event."
        keynum = event.which
    }
    if (keynum == 13) {
        this.com();
    }
    //console.log(keynum);
}
page.com = function (msg = "") {
    if (msg == "") {
        msg = page.comandInp.value;
    }

    page.comListAdd(msg);
    this.setContent(msg, "sended");
    term.com(msg, page.receved);
    this.setContent(term.ultimoRequerimentoDoServidor);
    page.comandInp.value = "";
}
page.comListAdd = function (com) {
    page.comList[page.comList.length] = com;
    retorno = "";
    for (i = page.comList.length - 1; i >= 0; i--) {
        retorno += "<input type=\"button\" onClick = \"page.com('" + page.comList[i] + "')\" value=\"" + page.comList[i] + "\">";
    }
    if (page.comList.length > 10) {
        page.comList.shift();
    }
    page.eleComLinst.innerHTML = retorno;
}
//chamado no script "terminal"
page.receved = function (msg) {
    page.setContent(msg, "receved");

}
//tipo:log/sended/receved
page.setContent = function (nStr, tipo = "log") {
    this.content.innerHTML += "<p id = \"" + tipo + "\">" + nStr + "</p>";
    this.content.scrollTop = this.content.scrollHeight;
}
page.openServer = function (url) {
    term.com(".setServer(" + url + ")", page.receved);
    term.com(".on", page.receved);
    term.com("", page.receved);
    term.setBase("", "");
}
page.clear = function () {
    this.content.innerHTML = "<h1>" + term.id + "</h1>";
}
page.confCheck = false;
page.config = function () {
    //console.log("pop");
    page.confCheck = !page.confCheck;
    if (page.confCheck) {
        document.getElementById("menu-closed").style.display = "none"
        document.getElementById("menu-content").style.display = "block";
    } else {
        document.getElementById("menu-closed").style.display = "block";
        document.getElementById("menu-content").style.display = "none";
    }
}
page.configHide = function () {
    page.btnMenu.style.display = "none";
}
// elementos
page.title = document.getElementById("title");
page.btnMenu = document.getElementById("menu-closed");
page.eleComLinst = document.getElementById("comlist");
page.statusLbl = document.getElementById("statusLbl");
page.comandInp = document.getElementById("comandInp");
page.content = document.getElementById("content");

//------------ configuracao

term = new Terminal();
//
if (typeof data["server"] == "undefined") {
    if (typeof server == "undefined") {
        server = "";
    }
} else {
    server = data["server"];
}
console.log(server);
if (!server == "") {
    page.openServer(server);
    page.configHide();
} else {
    page.config();
}
//
if (typeof data["label"] == "undefined") {
    if (typeof label == "undefined")
        label = "";
} else label = data["label"];
//console.log(data);
if (label != "") page.title.innerHTML = "Term2.2 | " + label;
else page.title.innerHTML = "Term2.2 | undefined";
//if(!config){page.getconfig();}
//------------------


//mensagem de boas vindas do servidor
//term.com("",page.receved);
page.clear();
console.log("pageTerminal.js");
