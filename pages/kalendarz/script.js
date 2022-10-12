let nav = 0;
let clicked = null;
let events = [];

const calendar = document.getElementById('calendar')
const newEventModal = document.getElementById('newEventModal')
const deleteEventModal = document.getElementById('deleteEventModal')
const backDrop = document.getElementById('modalBackDrop')
const eventTitleInput = document.getElementById('eventTitleInput');


const weekdays = ['niedziela', 'poniedziałek', 'wtorek', 'środa', 'czwartek', 'piątek', 'sobota'];

function retrieveEvents() {
    // retrieve reminders from database
    const param = JSON.stringify({"action":'retrieve'});
    const request = new XMLHttpRequest();
    request.onload = function() {
        const obj = JSON.parse(this.responseText);
        for (let i = 0; i < obj.length; i++) {
            // convert to datestring
            let date_array = obj[i]['reminder_date'].split('-');
            // delete 0s at the beginning of month and day
            if (date_array[1][0] == '0') {
                date_array[1] = date_array[1][1];
            }
            if (date_array[2][0] == '0') {
                date_array[2] = date_array[2][1];
            }

            let date_string = date_array[1] + '.' + date_array[2] + '.' + date_array[0];

            events.push({
                date: date_string,
                title: obj[i]['reminder_type'],
                id: obj[i]['ID']
            });
        }
        // load page after request has been completed
        load();
    }

    request.open("POST", "scripts/manageReminders.php")
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
    request.send("x=" + param);
}

function openModal(date) {
    clicked = date;
    const eventForDay = events.find(e => e.date == clicked);

    if(eventForDay){
        document.getElementById('eventText').innerText = eventForDay.title;
        deleteEventModal.style.display = 'block'
    } else {
        newEventModal.style.display = 'block';
    }
    backDrop.style.display = 'block';

}

function changeCover(dat) {


    document.getElementById('main').style.backgroundImage = "url(../images/"+ `${dat.toLocaleDateString('en', {month: 'long'})}`+".jpg)";


    console.log(`${dat.toLocaleDateString('en', {month: 'long'})}`)
}
function load() {


    const dt = new Date();

    if (nav !== 0) {
        dt.setMonth(new Date().getMonth() + nav);
    }

    const day = dt.getDate();
    const month = dt.getMonth();
    const year = dt.getFullYear();

    const firstDayOfMonth = new Date(year, month, 1);
    const daysInMonth = new Date(year, month+1, 0).getDate();
    

    const dateString = firstDayOfMonth.toLocaleDateString('pl', {
        weekday: 'long',
        year: 'numeric',
        month: 'numeric',
        day: 'numeric',
    });
    
    const paddingDays = weekdays.indexOf(dateString.split(', ')[0]);

    document.getElementById('monthDisplay').innerText = 
    `${dt.toLocaleDateString('pl', {month: 'long'}).toUpperCase()} ${year}`;
    changeCover(dt);
    calendar.innerHTML = '';

    console.log( events.length);
    
    for(let i = 1; i <= paddingDays + daysInMonth; i++) {
        const daySquare = document.createElement('div');
        daySquare.classList.add('day');
        const dayString = `${month+1}.${i-paddingDays}.${year}`;

        if (i > paddingDays) {
            daySquare.innerText = i - paddingDays;
            const eventForDay = events.find(e => e.date === dayString );
            if(i - paddingDays === day && nav === 0) {
                daySquare.id = 'currentDay';
            }

            if (eventForDay) {
                const eventDiv = document.createElement('div');
                eventDiv.classList.add('event')
                eventDiv.innerText = eventForDay.title;
                daySquare.appendChild(eventDiv)
            }

            daySquare.addEventListener('click', () => openModal(dayString));

        } else {
            daySquare.classList.add('padding');
        }

        calendar.appendChild(daySquare)
    }
}


function closeModal() {
    eventTitleInput.classList.remove('error');
    newEventModal.style.display = 'none';
    deleteEventModal.style.display = 'none';
    backDrop.style.display = 'none';
    eventTitleInput.value = '';
    clicked = null;
    load();
}

function saveEvent() {
    // sending data to database
    const param = JSON.stringify({"action":'set', "date":clicked, "title":eventTitleInput.value});
    const request = new XMLHttpRequest()
    let reminder_id = 0;

    request.onload = function() {
        const obj = JSON.parse(this.responseText);
        reminder_id = obj['ID'];
    }

    request.open("POST", "scripts/manageReminders.php")
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
    request.send("x=" + param);

    if (eventTitleInput.value) {
        eventTitleInput.classList.remove('error');
        events.push({
            date: clicked,
            title: eventTitleInput.value,
            id: reminder_id
        });
        closeModal();
    } else {
        eventTitleInput.classList.add('error');
    }
}

function deleteEvent() {
    let chosen = events.find(e => e.date == clicked);

    // sending data to database
    const param = JSON.stringify({"action":'remove', "ID":chosen.id});
    const request = new XMLHttpRequest()
    request.open("POST", "scripts/manageReminders.php")
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
    request.send("x=" + param);

    events = events.filter(e => e.date !== clicked);
    closeModal();
}
function initButtons() {
    document.getElementById('nextButton').addEventListener('click', () => {
        nav++;
        load();
    });
    document.getElementById('backButton').addEventListener('click', () => {
        nav--;
        load();
    });

    document.getElementById('saveButton').addEventListener('click', saveEvent)

    document.getElementById('cancelButton').addEventListener('click', closeModal);

    document.getElementById('deleteButton').addEventListener('click', deleteEvent)

    document.getElementById('closeButton').addEventListener('click', closeModal);

    

}


retrieveEvents();
initButtons();




