const body = document.getElementsByTagName("body")[0];
const canvas = document.createElement("canvas");
canvas.width = window.innerWidth;
canvas.height = window.innerHeight;
body.appendChild(canvas);
const ctx = canvas.getContext("2d");

const arcos = document.querySelectorAll("arco");
const retangulos = document.querySelectorAll("retangulo");

function distancia(ax, ay, bx, by) {
    return Math.hypot(ax - bx, ay - by);
}

// Colisão círculo / círculo
function colisaoCirculoCirculo(c1, c2) {
    const x1 = parseInt(c1.getAttribute("posX"));
    const y1 = parseInt(c1.getAttribute("posY"));
    const r1 = parseInt(c1.getAttribute("raio"));
    const x2 = parseInt(c2.getAttribute("posX"));
    const y2 = parseInt(c2.getAttribute("posY"));
    const r2 = parseInt(c2.getAttribute("raio"));
    return distancia(x1, y1, x2, y2) < r1 + r2;
}

// TODO estudar Colisão retângulo / retângulo (AABB) (usei o chat :,3)
function colisaoRetRet(r1, r2) {
    const x1 = parseInt(r1.getAttribute("posX"));
    const y1 = parseInt(r1.getAttribute("posY"));
    const w1 = parseInt(r1.getAttribute("largura"));
    const h1 = parseInt(r1.getAttribute("altura"));
    const x2 = parseInt(r2.getAttribute("posX"));
    const y2 = parseInt(r2.getAttribute("posY"));
    const w2 = parseInt(r2.getAttribute("largura"));
    const h2 = parseInt(r2.getAttribute("altura"));
    return !(x1 + w1 < x2 || x2 + w2 < x1 || y1 + h1 < y2 || y2 + h2 < y1);
}

// TODO  estudar Colisão círculo / retângulo
function colisaoCirculoRet(circulo, retangulo) {
    const cx = parseInt(circulo.getAttribute("posX"));
    const cy = parseInt(circulo.getAttribute("posY"));
    const raio = parseInt(circulo.getAttribute("raio"));
    const rx = parseInt(retangulo.getAttribute("posX"));
    const ry = parseInt(retangulo.getAttribute("posY"));
    const rw = parseInt(retangulo.getAttribute("largura"));
    const rh = parseInt(retangulo.getAttribute("altura"));

    // Encontra o ponto mais próximo do círculo dentro do retângulo
    const closestX = Math.max(rx, Math.min(cx, rx + rw));
    const closestY = Math.max(ry, Math.min(cy, ry + rh));
    const dx = cx - closestX;
    const dy = cy - closestY;
    return (dx * dx + dy * dy) < raio * raio;
}

//Comportamento de colisão (inverte direção e, para arcos, altera raio)
function aplicarComportamentoColisao(el) {
    // Inverte direção
    const mover = el.getAttribute("mover");
    if (mover === "acima") el.setAttribute("mover", "abaixo");
    else if (mover === "abaixo") el.setAttribute("mover", "acima");
    else if (mover === "esquerda") el.setAttribute("mover", "direita");
    else if (mover === "direita") el.setAttribute("mover", "esquerda");

    // Se for arco, aplica comportamento de raio
    if (el.tagName === "ARCO") {
        const comportamento = el.getAttribute("comportamento");
        if (comportamento === "aumenta") {
            let raio = parseInt(el.getAttribute("raio"));
            raio = Math.min(raio * 2, 200); // limite máximo
            el.setAttribute("raio", raio);
        } else if (comportamento === "diminui") {
            let raio = parseInt(el.getAttribute("raio"));
            raio = Math.max(raio / 2, 10); // limite mínimo
            el.setAttribute("raio", raio);
        }
    }
}

// Verifica e resolve todas as colisões entre formas com o mesmo atributo "colisao" e mesma cor -----
function tratarColisoes() {
    const formas = document.querySelectorAll("[colisao]");
    for (let i = 0; i < formas.length; i++) {
        for (let j = i + 1; j < formas.length; j++) {
            const a = formas[i];
            const b = formas[j];

            let colidiu = false;
            const tagA = a.tagName;
            const tagB = b.tagName;

            if (tagA === "ARCO" && tagB === "ARCO") {
                colidiu = colisaoCirculoCirculo(a, b);
            }
            else if (tagA === "RETANGULO" && tagB === "RETANGULO") {
                colidiu = colisaoRetRet(a, b);
            }
            else if (tagA === "ARCO" && tagB === "RETANGULO") {
                // Só colidem se tiverem a MESMA COR
                if (a.getAttribute("cor") !== b.getAttribute("cor")) continue;
                colidiu = colisaoCirculoRet(a, b);
            }
            else if (tagA === "RETANGULO" && tagB === "ARCO") {
                if (a.getAttribute("cor") !== b.getAttribute("cor")) continue;
                colidiu = colisaoCirculoRet(b, a);
            }

            if (colidiu) {
                aplicarComportamentoColisao(a);
                aplicarComportamentoColisao(b);
            }
        }
    }
}

const objArco = {
    velocidade: 3,

    desenhar: function () {
        for (let a of arcos) {
            // Garantir atributos padrão
            if (!a.hasAttribute("raio")) a.setAttribute("raio", 50);
            if (!a.hasAttribute("posX")) a.setAttribute("posX", 100);
            if (!a.hasAttribute("posY")) a.setAttribute("posY", 100);
            if (!a.hasAttribute("cor")) a.setAttribute("cor", "blue");
            if (!a.hasAttribute("graus")) a.setAttribute("graus", 360);

            const raio = parseInt(a.getAttribute("raio"));
            const x = parseInt(a.getAttribute("posX"));
            const y = parseInt(a.getAttribute("posY"));
            const cor = a.getAttribute("cor");
            const graus = parseInt(a.getAttribute("graus"));
            const rad = graus * (Math.PI / 180);

            ctx.beginPath();
            ctx.arc(x, y, raio, 0, rad, true);
            ctx.fillStyle = cor;
            ctx.fill();
            ctx.closePath();

            const mover = a.getAttribute("mover");
            if (mover) this.mover(a, mover);
        }
    },

    mover: function (el, direcao) {
        let x = parseInt(el.getAttribute("posX"));
        let y = parseInt(el.getAttribute("posY"));
        let raio = parseInt(el.getAttribute("raio"));

        switch (direcao) {
            case "acima": y -= this.velocidade; break;
            case "abaixo": y += this.velocidade; break;
            case "esquerda": x -= this.velocidade; break;
            case "direita": x += this.velocidade; break;
        }

        // Colisão com bordas
        if (y + raio > canvas.height) y = canvas.height - raio;
        if (y - raio < 0) y = raio;
        if (x + raio > canvas.width) x = canvas.width - raio;
        if (x - raio < 0) x = raio;

        el.setAttribute("posX", x);
        el.setAttribute("posY", y);
    }
};

const objRet = {
    velocidade: 3,

    desenhar: function () {
        for (let r of retangulos) {
            if (!r.hasAttribute("altura")) r.setAttribute("altura", 50);
            if (!r.hasAttribute("largura")) r.setAttribute("largura", 50);
            if (!r.hasAttribute("posX")) r.setAttribute("posX", 100);
            if (!r.hasAttribute("posY")) r.setAttribute("posY", 100);
            if (!r.hasAttribute("cor")) r.setAttribute("cor", "blue");

            const w = parseInt(r.getAttribute("largura"));
            const h = parseInt(r.getAttribute("altura"));
            const x = parseInt(r.getAttribute("posX"));
            const y = parseInt(r.getAttribute("posY"));
            const cor = r.getAttribute("cor");

            ctx.fillStyle = cor;
            ctx.fillRect(x, y, w, h);

            const mover = r.getAttribute("mover");
            if (mover) this.mover(r, mover);
        }
    },

    mover: function (el, direcao) {
        let x = parseInt(el.getAttribute("posX"));
        let y = parseInt(el.getAttribute("posY"));
        const w = parseInt(el.getAttribute("largura"));
        const h = parseInt(el.getAttribute("altura"));

        switch (direcao) {
            case "acima": y -= this.velocidade; break;
            case "abaixo": y += this.velocidade; break;
            case "esquerda": x -= this.velocidade; break;
            case "direita": x += this.velocidade; break;
        }

        // Colisão com bordas
        if (y + h > canvas.height) y = canvas.height - h;
        if (y < 0) y = 0;
        if (x + w > canvas.width) x = canvas.width - w;
        if (x < 0) x = 0;

        el.setAttribute("posX", x);
        el.setAttribute("posY", y);
    }
};

function desenharFormas() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    objArco.desenhar();
    objRet.desenhar();

    tratarColisoes();

    requestAnimationFrame(desenharFormas);
}

document.addEventListener("keydown", (e) => {
    const elementos = document.querySelectorAll("[interacao]");
    if (elementos.length === 0) return;

    // Define a velocidade do teclado
    const velocidade = 10;
    let dx = 0, dy = 0;

    switch (e.key) {
        case "ArrowUp": dy = -velocidade; break;
        case "ArrowDown": dy = velocidade; break;
        case "ArrowLeft": dx = -velocidade; break;
        case "ArrowRight": dx = velocidade; break;
        default: return;
    }

    for (let el of elementos) {
        let x = parseInt(el.getAttribute("posX"));
        let y = parseInt(el.getAttribute("posY"));

        // Trata círculo ou retângulo
        if (el.tagName === "ARCO") {
            const raio = parseInt(el.getAttribute("raio"));
            x += dx;
            y += dy;
            // Limita bordas
            if (x - raio < 0) x = raio;
            if (x + raio > canvas.width) x = canvas.width - raio;
            if (y - raio < 0) y = raio;
            if (y + raio > canvas.height) y = canvas.height - raio;
        }
        else if (el.tagName === "RETANGULO") {
            const w = parseInt(el.getAttribute("largura"));
            const h = parseInt(el.getAttribute("altura"));
            x += dx;
            y += dy;
            if (x < 0) x = 0;
            if (x + w > canvas.width) x = canvas.width - w;
            if (y < 0) y = 0;
            if (y + h > canvas.height) y = canvas.height - h;
        }

        el.setAttribute("posX", x);
        el.setAttribute("posY", y);
    }
});

document.addEventListener("click", (e) => {
    const elementos = document.querySelectorAll("[teleportavel]");
    const mouseX = e.clientX;
    const mouseY = e.clientY;

    for (let el of elementos) {
        let x = mouseX;
        let y = mouseY;

        // Ajusta para não sair da tela
        if (el.tagName === "ARCO") {
            const raio = parseInt(el.getAttribute("raio"));
            if (x - raio < 0) x = raio;
            if (x + raio > canvas.width) x = canvas.width - raio;
            if (y - raio < 0) y = raio;
            if (y + raio > canvas.height) y = canvas.height - raio;
        }
        else if (el.tagName === "RETANGULO") {
            const w = parseInt(el.getAttribute("largura"));
            const h = parseInt(el.getAttribute("altura"));
            if (x < 0) x = 0;
            if (x + w > canvas.width) x = canvas.width - w;
            if (y < 0) y = 0;
            if (y + h > canvas.height) y = canvas.height - h;
        }

        el.setAttribute("posX", x);
        el.setAttribute("posY", y);
    }
});

// Inicia a animação
desenharFormas();