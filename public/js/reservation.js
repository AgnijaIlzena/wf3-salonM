const elementsForAjax = document.querySelectorAll('.ajax');
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


elementsForAjax.forEach(el=>{
    el.addEventListener('click', (e) => {
        let reservation = JSON.parse(localStorage.getItem('reservation'))||{};

        // affichage des différentes section au clic
        // clic sur une carte massagist -> calendrier
        if(e.target.classList == 'card-text' || e.target.classList == 'massagist-photo-profile' 
        || e.target.classList == 'card-title' || e.target.classList == 'card-body'){
            calendarSection.style.display = 'block';

            // remplissage du localstorage - massagist 
            let massagistId = el.dataset.massagistId;
            let massagistName = el.dataset.massagistName;
            reservation.massagistId = massagistId;
            reservation.massagistName = massagistName;
        }

        // clic sur  calendrier -> timeSlot
        if(e.target.classList == 'date' || e.target.classList[1] == 'date'){
            timeslotsSection.style.display = 'block';

            // remplissage du localstorage - date
            let date = el.dataset.date;
            reservation.date = date;
        }

        // clic sur  timeSlot -> form infos client
        if(e.target.classList[4]=='timeSlot'){
            formSection.style.display = 'block';

            // remplissage du localstorage - timeSlot
            let timeslot = el.dataset.timeslot;
            reservation.timeslot = timeslot;
        }

        // remplissage du localstorage - infos massage
        let massageId = massageText.dataset.massageId;
        let massageName = massageText.dataset.massageName;
        let price = massageText.dataset.massagePrice;
        reservation.massageId = massageId;
        reservation.massageName = massageName;


        // clic sur  btn 'suivant' -> summary 
        // if(e.target.classList[3]=='next'){
        //     summary.style.display = 'block';
        //     next.innerHTML = 'Valider les mo';

        //     // résumé
        //     summaryMassage.innerHTML = 'Massage: '+reservation.massageName;
        //     summaryMassagist.innerHTML = 'Masseur: '+reservation.massagistName;
        //     summaryDate.innerHTML = `Date et horaire: le ${reservation.date.slice(8,10)}-${reservation.date.slice(5,7)}-${reservation.date.slice(0,4)} 
        //     de ${reservation.timeslot.slice(0,2)}h à ${reservation.timeslot.slice(8,10)}h`;
        //     summaryPrice.innerHTML = `Prix: ${price} €`;
        // }

        localStorage.setItem('reservation', JSON.stringify(reservation));
})

})

elementsForAjax.forEach(el=>{
    el.addEventListener('change', (e) => {

    // remplissage du localstorage - infos client
    let reservation = JSON.parse(localStorage.getItem('reservation'))||{};
    const lastname = document.querySelector('#reservation_form_lastname').value;
    const firstname = document.querySelector('#reservation_form_firstname').value;
    const email = document.querySelector('#reservation_form_email').value;
    const telephone = document.querySelector('#reservation_form_telephone').value;
    reservation.lastname = lastname;
    reservation.firstname = firstname;
    reservation.email = email;
    reservation.telephone = telephone;
    localStorage.setItem('reservation', JSON.stringify(reservation));
})
})

book.addEventListener('click',()=>{

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
        window.location.href = `/payement/${id}`;
    })
    .catch(error => console.log("Erreur : " + error));
    
        
})