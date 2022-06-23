const buttons = document.querySelectorAll('.ajax');
const calendarSection = document.querySelector('.calendar');
const timeslotsSection = document.querySelector('.timeslots');
const formSection = document.querySelector('.form');

const summary = document.querySelector('.summary');
const summaryMassage = document.querySelector('.summary-massage');
const summaryMassagist = document.querySelector('.summary-massagist');
const summaryDate = document.querySelector('.summary-date');
const summaryPrice = document.querySelector('.summary-price');


const massageText = document.querySelector('.massage');
const book = document.querySelector('.book');
const next = document.querySelector('.next');

// messages d'erreur
const errorLastName = document.querySelector('.errorLastName');
const errorFirstName = document.querySelector('.errorFirstName');
const errorEmail = document.querySelector('.errorEmail');
const errorPhone = document.querySelector('.errorPhone');
const errorGlobal = document.querySelector('.errorGlobal');




// scroll jusqu'au calendrier si clic sur un des btn mois suivant, 
// mois ou mois précédent ou mois en cours
const params = new Proxy(new URLSearchParams(window.location.search), {
    get: (searchParams, prop) => searchParams.get(prop),
  });

  let calendarView = params.calendar;
  if(calendarView == 1){
    calendarSection.style.display = 'block';
    window.scrollTo(0,calendarSection.getBoundingClientRect().top + document.documentElement.scrollTop -30);
  }

  let massagistParam = params.massagist;
  if(massagistParam !=null){
    calendarSection.style.display = 'block';
    window.scrollTo(0,calendarSection.getBoundingClientRect().top + document.documentElement.scrollTop -200);
  }

  let date = params.date;
  if(date !=null){
    calendarSection.style.display = 'block';
    timeslotsSection.style.display = 'block';
    window.scrollTo(0,timeslotsSection.getBoundingClientRect().top + document.documentElement.scrollTop -200);
    
  }
  
          

buttons.forEach(el=>{
    el.addEventListener('click', (e) => {
        let reservation = JSON.parse(localStorage.getItem('reservation'))||{};

        // affichage des différentes section au clic
        // clic sur une carte massagist -> calendrier
        if(e.target.classList == 'card-text' || e.target.classList == 'massagist-photo-profile' 
        || e.target.classList == 'card-title' || e.target.classList == 'card-body'){
            calendarSection.style.display = 'block';
            window.scrollTo(0,calendarSection.getBoundingClientRect().top + document.documentElement.scrollTop -30);

            // remplissage du localstorage - massagist 
            let massagistId = el.dataset.massagistId;
            let massagistName = el.dataset.massagistName;
            reservation.massagistId = massagistId;
            reservation.massagistName = massagistName;
        }

        // clic sur  calendrier -> timeSlot
        if(e.target.classList == 'date' || e.target.classList[1] == 'date'){
            timeslotsSection.style.display = 'block';
            window.scrollTo(0,timeslotsSection.getBoundingClientRect().top + document.documentElement.scrollTop -200);
            // remplissage du localstorage - date
            let date = el.dataset.date;
            reservation.date = date;
        }

        // clic sur  timeSlot -> form infos client
        if(e.target.classList[4]=='timeSlot'){
            formSection.style.display = 'block';
            window.scrollTo(0,formSection.getBoundingClientRect().top + document.documentElement.scrollTop-100);

            // remplissage du localstorage - timeSlot
            let timeslot = el.dataset.timeslot;
            reservation.timeslot = timeslot;
        }

        // remplissage du localstorage - infos massage
        let massageId = massageText.dataset.massageId;
        let massageName = massageText.dataset.massageName;
        reservation.massageId = massageId;
        reservation.massageName = massageName;


        localStorage.setItem('reservation', JSON.stringify(reservation));
})

})

// inputs
buttons.forEach(el=>{
    el.addEventListener('input', () => {

    // remplissage du localstorage - infos client
    let reservation = JSON.parse(localStorage.getItem('reservation'))||{};

    const lastname = document.querySelector('#reservation_form_lastname').value;
    const firstname = document.querySelector('#reservation_form_firstname').value;
    const email = document.querySelector('#reservation_form_email').value;
    const telephone = document.querySelector('#reservation_form_telephone').value;


    // lastname
        if (/^[a-zA-Z- ]+$/.test(lastname) && lastname.length!=0){
            reservation.lastname = lastname;
            errorLastName.style.display='none';
        }
        else{
            errorLastName.style.display='block';
        }

    // firstname
        if (/^[a-zA-Z- ]+$/.test(firstname) && firstname.length!=0){
            reservation.firstname = firstname;
            errorFirstName.style.display='none';
        }
        else{
            errorFirstName.style.display='block';
        }

    // email
        if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email) && email.length!=0){
            reservation.email = email;
            errorEmail.style.display='none';
        }
        else{
            errorEmail.style.display='block';
        }

    // telephone
        if (/^\d+$/.test(telephone)&& telephone.length!=0){
            reservation.telephone = telephone;
            errorPhone.style.display='none';
        }
        else{
            errorPhone.style.display='block';
        }
    localStorage.setItem('reservation', JSON.stringify(reservation));
})
})


book.addEventListener('click',()=>{
    
    const lastname = document.querySelector('#reservation_form_lastname').value;
    const firstname = document.querySelector('#reservation_form_firstname').value;
    const email = document.querySelector('#reservation_form_email').value;
    const telephone = document.querySelector('#reservation_form_telephone').value;

    if(lastname.length != 0 && firstname.length != 0 && email.length != 0 && telephone.length != 0 &&
        window.getComputedStyle(errorLastName).display=='none' && window.getComputedStyle(errorFirstName).display=='none'&& 
        window.getComputedStyle(errorEmail).display=='none'&& window.getComputedStyle(errorPhone).display=='none'){
        
        errorGlobal.style.display = 'none';

        fetch("/reservation", {
            method: "POST",
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: localStorage.getItem('reservation')
        })
        .then(response => response.json())
        .then(id => {
            window.location.href = `/checkout/${id}`;
        })
        .catch(error => console.log("Erreur : " + error));
    }
    else{
        errorGlobal.style.display = 'block';
    }
})