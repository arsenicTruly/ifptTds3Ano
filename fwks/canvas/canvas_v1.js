const canvas = document.getElementById("meuCanvas");
const ctx = canvas.getContext("2d");

let circulo={
    x:100,
    y:100,
    raio:50,
    desenhar:function(){
        ctx.beginPath();
        ctx.arc(this.x,this.y,this.raio,0,Math.PI*2);
        ctx.fillStyle="green";
        ctx.fill();
        ctx.stroke();
        ctx.closePath();
    },
    mover:function(){
        this.x+=10;
    }
};

let retangulo={
    x:0,
    y:0,
    w:100,
    h:100,
    desenhar:function(){
        ctx.beginPath();
        ctx.rect(this.x,this.y,this.w,this.h);
        ctx.strokeStyle="#00450c";
        ctx.stroke();
        ctx.closePath()
    },
    mover:function(){
        this.x++;
    }
}

function executar(){
    ctx.clearRect(0,0,canvas.width,canvas.height);
    circulo.desenhar();
    circulo.mover();
    retangulo.desenhar();
    retangulo.mover();
    requestAnimationFrame(executar);
}
executar();