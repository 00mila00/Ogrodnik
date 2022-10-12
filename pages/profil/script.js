let nav = 0;
let clicked = null;
const dt = new Date();
let events = localStorage.getItem('events') ? JSON.parse(localStorage.getItem('events')) : [];

if (nav !== 0) {
        dt.setMonth(new Date().getMonth() + nav);
    }
const month = dt.getMonth();
// document.getElementById('backa').src = "../images/"+ `${dt.toLocaleDateString('en', {month: 'long'})}`+".jpg";;
console.log(`${dt.toLocaleDateString('en', {month: 'long'})}`)

const imgDiv = document.querySelector('.profil_pic_div');
const file = document.querySelector('#file');
const img = document.querySelector('#photo');
const uploadBtn = document.querySelector('#uploadBtn');

imgDiv.addEventListener('mouseenter',function(){
	uploadBtn.style.display  = "block";
});

imgDiv.addEventListener('mouseleave',function(){
	uploadBtn.style.display  = "none";
});

file.addEventListener('change',function(){
const choosedFile = this.files[0];

	if(choosedFile) {
	const reader = new FileReader();

	reader.addEventListener('load',function()
	{
		img.setAttribute('src',reader.result);
	});
	reader.readAsDataURL(choosedFile);

	}

});


