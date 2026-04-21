const body=document.getElementsByTagName("body")[0];
const canvas = document.createElement("canvas");
canvas.width=window.innerWidth;
canvas.height=window.innerHeight;
body.appendChild(canvas);
const ctx = canvas.getContext("2d");
const arco =document.getElementsByTagName("arco");

const objArco={
    x:null,y:null,raio:null,rad:null,cor:null,
    velocidade:3,

    desenhar:function () {
       for (let a of arco) {
                      this.raio = parseInt(a.getAttribute("raio")) || 50;
            this.x = parseInt(a.getAttribute("posX")) || 100;
            this.y = parseInt(a.getAttribute("posY")) || 100;
            this.cor = a.getAttribute("cor") || "blue";
            let grau = parseInt(a.getAttribute("graus")) || 360;
            this.rad = grau * (Math.PI / 180);

            ctx.beginPath();
            ctx.arc(this.x, this.y, this.raio, 0, this.rad, true);
            ctx.fillStyle = this.cor;
            ctx.fill();
            ctx.closePath();

          let moverArco=a.getAttribute("mover");
          if(moverArco)
              this.mover(a,moverArco);
       }
    },

    mover:function(a,moverArco){
        if(moverArco==="acima") this.y-=this.velocidade;
        if(moverArco==="abaixo") this.y+=this.velocidade;
        if(moverArco==="esquerda") this.x-=this.velocidade;
        if(moverArco==="direita") this.x+=this.velocidade;

        a.setAttribute("posX",this.x);
        a.setAttribute("posY",this.y);
        altura  = canvas.height;
        largura = canvas.width;
        
        if(this.y > altura){
            a.setAttribute("posY", this.raio);
            this.y = this.raio;
        }
        if(this.y <= 0){
            a.setAttribute("posY", altura);
            this.y = this.raio;
        }
        if(this.x > largura){
            a.setAttribute("posX", this.raio);
        }
        if(this.x <= 0){
            a.setAttribute("posX", largura);
        }

        if(a.getAttribute("colisao")){
        colisao();
        }
    }
};

function desenharFormas() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    if (arco) {
        objArco.desenhar();
    }
    requestAnimationFrame(desenharFormas);
}

function calcularDistancia(a, b) {
    let ax = parseInt(a.getAttribute("posX"));
    let ay = parseInt(a.getAttribute("posY"));
    let bx = parseInt(b.getAttribute("posX"));
    let by = parseInt(b.getAttribute("posY"));
    return Math.sqrt((ax - bx) ** 2 + (ay - by) ** 2);
}

function inverterDirecao(el) {
    let mover = el.getAttribute("mover");
    if (!mover) return;
    if (mover === "acima") {
        el.setAttribute("mover", "abaixo");
    } else if (mover === "abaixo") {
        el.setAttribute("mover", "acima");
    } else if (mover === "direita") {
        el.setAttribute("mover", "esquerda");
    } else if (mover === "esquerda") {
        el.setAttribute("mover", "direita");
    }
}

function colisao() {
    let vetor = document.querySelectorAll('[colisao]');
    for (let i = 0; i < vetor.length; i++) {
        for (let j = 0; j < vetor.length; j++) {
            let a = vetor[i];
            let b = vetor[j];
            if (i != j) {
                let dist = calcularDistancia(a, b);
                let raioA = parseInt(a.getAttribute("raio"));
                let raioB = parseInt(b.getAttribute("raio")); 

                if (dist < raioA + raioB) {
                    inverterDirecao(a);
                    inverterDirecao(b);
                }
            }
        }
    }
}

desenharFormas();
