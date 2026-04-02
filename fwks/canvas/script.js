const canvas = document.getElementById("meuCanvas");
const ctx = canvas.getContext("2d");

ctx.beginPath();
ctx.arc(100,100,50,0,Math.PI*2);
ctx.fillStyle="#77ce77";
ctx.fill();
ctx.stroke();

ctx.beginPath();
ctx.rect(150,40,100,60);
ctx.strokeStyle="#274a2d";
ctx.stroke();
ctx.closePath()

ctx.beginPath();
ctx.strokeStyle="#009018";
ctx.fillStyle="#77ce77";
ctx.moveTo(70,170);
ctx.lineTo(30,240);
ctx.lineTo(110,240);
ctx.closePath();
ctx.fill();
ctx.stroke();