// Seleciona o primeiro (e único) elemento <form> da página.
const form = document.getElementsByTagName("form")[0];

// Começa em 1 porque o campo 0 já existe estático no HTML (index.html).
// A cada chamada de novoCampo(), x é incrementado, garantindo que cada
// campo tenha um identificador único
let x = 1;


// se o valor selecionado for "select", exibe o span de opções;
// caso contrário, o oculta. Usa display "inline" para manter o fluxo
// de texto da página (os elementos ficam na mesma linha).
function toggleOpcoes(select, id) {
    const wrap = document.getElementById("opcoes-wrap" + id);
    wrap.style.display = select.value === "select" ? "inline" : "none";
}

// Cria dinamicamente um novo conjunto de elementos (rótulo + tipo) e os
// anexa ao formulário. Chamada pelo botão "Novo campo" no HTML.
function novoCampo() {

    // cria um <label> com o texto "Rótulo" e atributo
    // "for" apontando para o input de mesmo id.
    let label = document.createElement("label");
    label.setAttribute("for", "rotulo" + x);
    label.innerText = "Rótulo";

    // campo de texto onde o usuário digita o nome/rótulo
    // do campo que será gerado. O name usa o índice x para ser único.
    let input = document.createElement("input");
    input.setAttribute("type", "text");
    input.setAttribute("name", "rotulo" + x);

    let label1 = document.createElement("label");
    label1.setAttribute("for", "tipo" + x);
    label1.innerText = " Tipo ";

    // A constante "id" é necessária para capturar o valor correto de x
    // no momento da criação — sem ela, o closure do onchange sempre
    // leria o valor atual (já incrementado) de x, referenciando o
    // span errado.
    let select = document.createElement("select");
    select.setAttribute("name", "tipo" + x);
    const id = x;
    select.onchange = function () { toggleOpcoes(this, id); };

    // mapa de tipos disponíveis.
    let vet = {
        text:     "Texto",
        number:   "Número",
        date:     "Data",
        select:   "Opções",   
        textarea: "Textarea" 
    };

    // Percorre o mapa e cria um <option> para cada tipo
    for (let chave in vet) {
        let opt = document.createElement("option");
        opt.value = chave;
        opt.innerText = vet[chave];
        select.appendChild(opt);
    }

    // span de opções do select
    // Cria um <span> inicialmente oculto que contém um input de texto.
    // Esse input aparece apenas quando o usuário escolhe o tipo "Opções"
    // (controlado por toggleOpcoes). Nele o usuário digita as opções do
    // select separadas por vírgula, ex: "sim,não,talvez".
    //
    // O id do span segue o padrão "opcoes-wrap{x}" para que toggleOpcoes
    // e visualizarForm consigam localizá-lo pelo índice do campo.
    let opcoesWrap = document.createElement("span");
    opcoesWrap.id = "opcoes-wrap" + x;
    opcoesWrap.style.display = "none"; // oculto por padrão

    let opcoesLabel = document.createElement("br");
    let opcoesText  = document.createTextNode("Opções (separadas por vírgula): ");

    let opcoesInput = document.createElement("input");
    opcoesInput.setAttribute("type", "text");
    opcoesInput.setAttribute("name", "opcoes" + x); // name único por campo
    opcoesInput.setAttribute("placeholder", "ex: sim,não,talvez");

    opcoesWrap.appendChild(opcoesLabel);
    opcoesWrap.appendChild(opcoesText);
    opcoesWrap.appendChild(opcoesInput);
    
    // Incrementa o contador ANTES de anexar ao DOM, para que o próximo
    // campo já use o índice seguinte.
    x++;

    let br = document.createElement("br");

    // Anexa todos os elementos ao formulário.
    form.appendChild(label);
    form.appendChild(input);
    form.appendChild(label1);
    form.appendChild(select);
    form.appendChild(opcoesWrap);
    form.appendChild(br);
}

// Lê todos os campos configurados no formulário, monta uma string HTML e
// a escreve dentro do <iframe id="preview">, permitindo que o usuário
// veja o resultado final do formulário criado.
function visualizarForm() {

    // Localiza o iframe de preview
    const iframe = document.getElementById("preview");

    // Obtém o documento interno do iframe de forma compatível entre
    // navegadores
    let doc = iframe.contentDocument || iframe.contentWindow.document;

    // Inicia a string HTML do formulário gerado
    let html = "<form>";

    // Itera de 0 até x-1, cobrindo todos os campos (incluindo o campo 0
    // que existe estático no HTML) 
    for (let i = 0; i < x; i++) {

        // Lê o valor do rótulo e o tipo escolhido para o campo i.
        let rotulo = document.getElementsByName("rotulo" + i)[0].value;
        let tipo   = document.getElementsByName("tipo" + i)[0].value;

        // Adiciona o <label> com o rótulo informado
        html += `<label>${rotulo}</label>`;

        if (tipo === "select") {
            // buscamos o input de opções (name="opcoesN") e dividimos
            // seu valor pela vírgula para gerar uma <option> para cada item.
            //
            // Se o campo estiver vazio ou não existir, cai no fallback
            // ["opção 1"]. O .map(trim) remove espaços acidentais ao redor
            // de cada opção digitada.
            let opcoesEl = document.getElementsByName("opcoes" + i)[0];
            let opcoes = opcoesEl && opcoesEl.value.trim() !== ""
                ? opcoesEl.value.split(",").map(o => o.trim())
                : ["opção 1"]; // fallback 

            html += "<select>";
            opcoes.forEach(op => { html += `<option>${op}</option>`; });
            html += "</select><br>";

        } else if (tipo === "textarea") {
            // Gera um <textarea> com o name igual ao rótulo informado.
            // rows e cols definem o tamanho padrão de exibição.
            html += `<textarea name="${rotulo}" rows="4" cols="30"></textarea><br>`;

        } else {
            // Tipos simples (text, number, date): gera um <input> com o
            // type correspondente — igual ao original.
            html += `<input type="${tipo}" name="${rotulo}"><br>`;
        }
    }

    html += "</form>";

    // Escreve o HTML gerado dentro do iframe e o fecha.
    doc.open();
    doc.write(html);
    doc.close();
}