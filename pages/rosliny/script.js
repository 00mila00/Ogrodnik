let nav = 0;
let clicked = null;
const dt = new Date();
let events = localStorage.getItem('events') ? JSON.parse(localStorage.getItem('events')) : [];


function addNEW(zd,nazwa,miesiac,odstepy,opis){

// struktura 

//Div clalosc
const PlantInfoDiv =  document.createElement("div");
PlantInfoDiv.classList.add('PlantInfoDiv');
document.getElementById("main").appendChild(PlantInfoDiv);
var elements = document.getElementsByClassName("PlantInfoDiv").length;

//Div ze zdjeciem
const profil_pic_div =  document.createElement("div");
profil_pic_div.classList.add('profil_pic_div');
profil_pic_div.setAttribute('id', 'picture');
document.getElementsByClassName("PlantInfoDiv")[elements-1].appendChild(profil_pic_div);

const img =  document.createElement("img");
img.setAttribute('src', '../plants_images/' +  zd + '.jpg');
img.setAttribute('id', 'photo');
img.setAttribute('alt', 'Profil picture');
img.setAttribute('class', 'image');
document.getElementsByClassName("profil_pic_div")[elements-1].appendChild(img);


//Div z info
const info =  document.createElement("div");
info.setAttribute('id', 'info');
info.setAttribute('class', 'infotext');
document.getElementsByClassName("PlantInfoDiv")[elements-1].appendChild(info);

// tekst
const node1 = document.createElement("p");
const node2 = document.createElement("p");
const node3 = document.createElement("p");
const node4 = document.createElement("p");

node1.classList.add('info_plant');
node2.classList.add('info_plant');
node3.classList.add('info_plant');
node4.classList.add('info_plant');

//te
const textnode1 = document.createTextNode(nazwa);
const textnode2 = document.createTextNode(miesiac);
const textnode3 = document.createTextNode(odstepy);
const textnode4 = document.createTextNode(opis);

node1.appendChild(textnode1);
node2.appendChild(textnode2);
node3.appendChild(textnode3);
node4.appendChild(textnode4);

info.innerHTML =' <p class="info_plant_text">nazwa:</p>  ' ;
document.getElementsByClassName("infotext")[elements-1].appendChild(node1);
let formelement ='<br>  ' ;
info.insertAdjacentHTML('beforeend',formelement)


formelement =' <p class="info_plant_text">miesiac rozkwitu:</p>    ' ;
info.insertAdjacentHTML('beforeend',formelement)
document.getElementsByClassName("infotext")[elements-1].appendChild(node2);
formelement ='<br>  ' ;
info.insertAdjacentHTML('beforeend',formelement)


formelement ='<p class="info_plant_text">odstepy pomiedzy podlewaniem:</p>  ' ;
info.insertAdjacentHTML('beforeend',formelement)
document.getElementsByClassName("infotext")[elements-1].appendChild(node3);
formelement ='<br>  ' ;
info.insertAdjacentHTML('beforeend',formelement)


formelement ='<p class="info_plant_text">opis:</p>  ' ;
info.insertAdjacentHTML('beforeend',formelement)
document.getElementsByClassName("infotext")[elements-1].appendChild(node4);
formelement ='<br>  ' ;
info.insertAdjacentHTML('beforeend',formelement)					
					 	


//Div link
const link =  document.createElement("li");
const linka =  document.createElement("a");
linka.setAttribute('class', 'plantlink');
linka.setAttribute('href', '');
linka.setAttribute('style', 'display:none;');
const textlink = document.createTextNode("wincyj informacji");
linka.appendChild(textlink);
document.getElementsByClassName("PlantInfoDiv")[elements-1].appendChild(link);
link.appendChild(linka);
aaa()
}



var elements = document.getElementsByClassName("PlantInfoDiv");
var elements1 = document.getElementsByClassName("plantlink");

function aaa(){
	for (var i = 0; i < elements.length; i++) {
    elements[i].addEventListener('mouseenter', (function(i) {
        return function() {
            elements1[i].style.display  = "block";
        };
    })(i), false);

}
for (var i = 0; i < elements.length; i++) {
    elements[i].addEventListener('mouseleave', (function(i) {
        return function() {
            elements1[i].style.display  = "none";
        };
    })(i), false);
}
}

aaa();