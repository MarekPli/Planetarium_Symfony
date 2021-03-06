var canvas, ctx, w, h, L=null, do_speed = true;
var planets = [];
var planetNames = [];
var circle = {centerX:250, centerY:250,r:0,angle:0};
var glob_interval = 23;
var nr_day = 2691880; // 1 stycznia '70, dana Unixa
var speed_dates = 23;
var Planet = function (step,speed,name,nameShow,color='black') {
    this.x = 0;
    this.y = 0;
    this.AU = 0;
    this.AUplus = false;
    this.radius = h/70;
    this.interval = h/glob_interval;
    this.angle = 0;
    this.name = name;
    planetNames.push(name);
    this.nameShow = nameShow;
    this.color = color;
    this.speed = speed;
    this.is_moving = false;

    this.ctx= ctx;
    this.ctx.font ='13px Arial';
    this.pos=0;
    this.step = step;
    this.wasClicked = false;
    this.modifRadius = 0;

    this.modifyRadius = function(dist){
        // alert($dist);
        this.modifRadius = 2 * this.radius * dist - this.radius;
    }
    this.drawPlanet = function (angle=-1) {
        if (angle >= 0) {
            this.pos = angle;
        }

        if (this.pos >= 360) {
            this.pos = 0;
        }
        if (this.AU == this.radius || this.AU == -this.radius) {
            this.AUplus = !this.AUplus;
        }
        if (this.AUplus) {
            this.AU += 1;
        } else {
            this.AU -= 1;
        }

        this.AU = 0; // gdy nie ma innej opcji
        if (do_speed) {
            this.pos += this.speed;
        }
        // orb_len = h/20;


        this.ctx.beginPath();
        this.ctx.moveTo(w/2,h/2);
        this.ctx.lineTo(this.x,this.y);
        this.ctx.closePath();
        //      this.ctx.stroke();

        this.paintPath();
        this.ctx.fillStyle=this.color;
        this.ctx.fill();
        this.ctx.fillStyle= 'black';
        // this.ctx.stroke();

        if (!this.is_moving) {
            this.ctx.fillText(this.nameShow,
                this.x + 10, this.y - 10);
        }
    }

    this.clearPlanet = function () {
        var wh = this.radius * 2 + 2;
        this.ctx.clearRect(this.x-this.radius-1, this.y-this.radius-1, wh, wh);

        drawCircleOrbit(this.step * this.interval,'gray');

    }


    this.setAngle = function(x,y) {
        var tgY = h/2 - y;
        var tgX = w/2 - x;
        var tg = Math.abs(tgY) / Math.abs(tgX);
        this.pos = rad2us(Math.atan(tg));

        // quarter
        // +---+---+
        // | 4 | 1 |
        // +-------+
        // | 3 | 2 |
        // +-------+

        var quarter = 4;
        if (tgY < 0) {
            if (tgX  <0) { quarter = 2;}
            else { quarter = 3;}
        } else if (tgX < 0) { quarter = 1 ;}

        if (quarter == 2) {
            this.pos = 90 + (90 - this.pos);
        } else if (quarter == 1) {
            this.pos += 180;
        } else if (quarter == 4) {
            this.pos = 270 + (90 - this.pos);
        }
        this.angle = this.pos;
    }

    this.paintPath = function() {
        this.x = w/2+ Math.sin(grad2ian(this.pos+270))*(this.interval*step + this.AU + this.modifRadius);
        this.y = h/2+ Math.cos(grad2ian(this.pos+270))*(this.interval*step + this.AU + this.modifRadius);

        this.ctx.beginPath();
        // this.ctx.style = 'red';
        this.ctx.arc(this.x,this.y,this.radius,0,2*Math.PI,true);
        this.ctx.closePath();
    }

    this.clicked = function (x,y){
        if ( x >= (this.x - this.radius) && x <= (this.x + this.radius)
            && y >= (this.y - this.radius) && y <= (this.y + this.radius)
        ) {
            // this.color='red';
            // this.clearPlanet();
            this.wasClicked=true;
            this.moving(this.x,this.y);
            this.is_moving = true;
        }
    }

    this.clearText = function() {
        if (this.is_moving) {return}
        var color = this.ctx.fillStyle;
        this.ctx.fillStyle = 'b5b5b5';
        this.ctx.fillText(this.nameShow,
            this.x+10,this.y-10);
        this.ctx.fillStyle = color;

    }
    this.moving = function(x,y) {
        if (this.wasClicked) {
            this.clearPlanet();
            this.clearText();
            this.setAngle(x,y);
            this.paintPath();
            this.ctx.stroke();
            // this.ctx.fillText(this.name,
            //  this.x+10,this.y-10);
        }
    }
    this.moved = function(x,y) {
        if (this.wasClicked) {

            this.setAngle(x,y);
            do_speed = false;
            this.is_moving = false;
            moveOnePlanet(this.name,this.angle);
            do_speed = true;
            this.wasClicked = false;
        }
    }
};

function grad2ian(gradus) {
    return (Math.PI/180) * gradus;
}
function rad2us(radian) {
    return (180*radian) / Math.PI;
}

function startMovePlanet (event) {
    var x = event.offsetX;
    var y = event.offsetY;
    for (var i=0; i<planets.length; i++) {
        planets[i].clicked(x,y);
    }
}
function movePlanet (event) {
    var x = event.offsetX;
    var y = event.offsetY;
    for (var i=0; i<planets.length; i++) {
        planets[i].moving(x,y);
    }
}
function endMovePlanet (event) {
    var x = event.offsetX;
    var y = event.offsetY;
    for (var i=0; i<planets.length; i++) {
        planets[i].moved(x,y);
    }
}

function init() {
    canvas = document.getElementById("canvas");
    ctx = canvas.getContext('2d');
    w = canvas.width;
    h = canvas.height;
    do_speed = false;
    canvas.addEventListener('mousedown', startMovePlanet);
    canvas.onmousemove = movePlanet;
    canvas.addEventListener('mouseup', endMovePlanet);

    planets.push (new Planet(1,2,'Moon', 'Księżyc','#f7ecde'));
    planets.push (new Planet(2,10/3,'Mercury', 'Merkury'));
    planets.push (new Planet(3,10/6,'Venus', 'Wenus'));
    planets.push (new Planet(4,1,'Sun','Słońce','yellow'));
    planets.push (new Planet(5,1/2,'Mars', 'Mars'));
    planets.push (new Planet(6,1/15,'Ceres', 'Ceres','#d3d3d3'));
    planets.push (new Planet(7,1/12,'Jupiter', 'Jowisz'));
    planets.push (new Planet(8,1/29,'Saturn', 'Saturn'));
    planets.push (new Planet(9,1/84,'Uranus', 'Uran'));
    planets.push (new Planet(10,1/168,'Neptune', 'Neptun'));
    planets.push (new Planet(11,1/248,'Pluto', 'Pluton'));
    // setInterval(drawPlanets,33)
    // drawPlanets(0);
    drawPlanetsDate();
    do_speed = true;
}

function modifDraw() {
    // angle = parseInt (document.getElementById("range").value);
    // drawPlanets(angle);
    var difference = parseInt (document.getElementById("range").value) - 180;
    nr_day += difference;
    drawPlanetsBase();
    document.getElementById("range").value = 180;

}

function myInterval() {
    var button = document.getElementById('interval');
    if (button.value == 'Włącz obroty') {
        // L = setInterval(drawPlanets,23);
        L = setInterval(drawPlanetsBase,speed_dates);
        button.value = 'Wyłącz obroty'
    }
    else {
        clearInterval(L);
        button.value = 'Włącz obroty'
    }
}

function drawPlanets(start_angle = -1) {
    // niepotrzebna, bo tylko umieszczała planety w jednym miejscu
    // planet.x = 300+ Math.cos(0.1*Math.PI)*30*3;
    // planet.y = 300+ Math.sin(0.1*Math.PI)*30*3;
    ctx.clearRect(0,0,w,h);
    ctx.strokeRect(0,0,w,h);
    for (var i = 1; i <= 11; i++) {
        drawCircleOrbit(i * h/glob_interval);
    }
    // for (var i=4; i<5; i++) {
    for (var i=0; i<planets.length; i++) {
        planets[i].drawPlanet(start_angle);
    }
}
function moveOnePlanet(name, angle) {
    nr_day--; // wskaźnik już ustawiony na następny dzień
    drawPlanetsBase('', name, angle);
}
function drawPlanetsDate() {
    drawPlanetsBase( $('#put_date').val( ) );
}

function drawPlanetsBase(put_date = '', namePlanet = '', angle = -1) {
    // for (var i=4; i<5; i++) {
    // var put_date = $('put_date').innerText;
    // alert(planetNames); // tu jest OK
    $.ajax({
        type: "POST",
        // url: "php/modifyPlanets.php",
        url: "/getDataFromPlanets",
        async: false,
        dataType: "json",
        // dataType: "html",
        data: {
            nr: nr_day,
            date: put_date,
            names: planetNames,
            namePlanet: namePlanet,
            anglePlanet: angle
        }
        // x: x,
        // y: y
    }).done ( function (arrPlanets) {
        // alert(arrPlanets);
        // arrPlanets = JSON.parse(arrPlanets); // albo parse albo dataType: "json"
        // $('#current_date').attr('html',arrPlanets[0]);

        // arrPlanets zwraca: datę, nr dnia, listę [kątów, arv] dla planet
        var dateData = arrPlanets.shift();
        var dateDay = arrPlanets.shift();
        var test = arrPlanets.pop();

        ctx.clearRect(0,0,w,h);
        ctx.strokeRect(0,0,w,h);
        for (var i = 1; i <= 11; i++) {
            drawCircleOrbit(i * h/glob_interval);
        }
        var fontSize = ctx.font;
        ctx.font ='23px Arial';
        ctx.fillText(dateData,10,60);
        ctx.font = fontSize;
        if (put_date || angle != -1) {
            nr_day = dateDay;
        }
        // alert(arrPlanets);
        for (var i=0; i<planets.length; i++) {
            var arr = arrPlanets[i];
            // alert(arr);
            planets[i].modifyRadius(arr[1]); // radius
            planets[i].drawPlanet(arr[0]);
        }
        nr_day++;
        // var test = arrPlanets[arrPlanets.length-1][0];
        if (test.length) { // było 400, 500
            var fontSize = ctx.font;
            ctx.font ='14px Arial';
            ctx.fillText(test[0], 450, 20);
            ctx.fillText(test[1], 450, 38);
            ctx.fillText(test[2], 450, 56);
            ctx.font = fontSize;
        }
    });
}

function drawCircleOrbit(radius,color=0) {
    // ctx.clearRect(0,0,w,h);
    // ctx.strokeRect(0,0,w,h);
    var color1 = ctx.strokeStyle
    var lineWidth = ctx.lineWidth;
    ctx.beginPath();
    ctx.arc(w/2,h/2,radius,0, 2*Math.PI,true);
    ctx.closePath();
    if (color) {
        ctx.strokeStyle = 'white';
        ctx.lineWidth = lineWidth + 4;
        ctx.stroke()
        ctx.strokeStyle = color1;
        ctx.lineWidth = lineWidth;
    }
    // ctx.fill();
    ctx.stroke();
    // ctx.strokeStyle = color1;
    // ctx.lineWidth = lineWidth;
}

