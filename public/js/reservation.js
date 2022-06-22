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
        // affichage des différentes section au clic
        if(e.target.classList == 'card-text' || e.target.classList == 'massagist-photo-profile' 
        || e.target.classList == 'card-title' || e.target.classList == 'card-body'){
            calendarSection.style.display = 'block';
        }
        if(e.target.classList == 'date' || e.target.classList[1] == 'date'){
            timeslotsSection.style.display = 'block';
        }
        if(e.target.classList[4]=='timeSlot'){
            formSection.style.display = 'block';
        }
        

        let massageId = massageText.dataset.massageId;
        let massageName = massageText.dataset.massageName;
        let price = massageText.dataset.massagePrice;
        let massagistId = el.dataset.massagistId;
        let massagistName = el.dataset.massagistName;
        let date = el.dataset.date;
        let timeslot = el.dataset.timeslot;
        

        let reservation = JSON.parse(localStorage.getItem('reservation'))||{};

        if(Object.keys(reservation).indexOf("massageId") ==-1 || reservation.massage ==''){
            reservation.massageId = massageId;
        }
        if(Object.keys(reservation).indexOf("massageName") ==-1 || reservation.massage ==''){
            reservation.massageName = massageName;
        }
        if(Object.keys(reservation).indexOf("massagistId") ==-1 || reservation.massagist ==''){
            reservation.massagistId = massagistId;
        }
        if(Object.keys(reservation).indexOf("massagistName") ==-1 || reservation.massagist ==''){
            reservation.massagistName = massagistName;
        }
        if(Object.keys(reservation).indexOf("date") ==-1 || reservation.date ==''){
            reservation.date = date;
        }
        if(Object.keys(reservation).indexOf("timeslot") ==-1 || reservation.timeslot ==''){
            reservation.timeslot = timeslot;
        }

        if(e.target.classList[3]=='next'){
            summary.style.display = 'block';
            next.style.display = 'none';
            const lastname = document.querySelector('#reservation_form_lastname').value;
            const firstname = document.querySelector('#reservation_form_firstname').value;
            const email = document.querySelector('#reservation_form_email').value;
            const telephone = document.querySelector('#reservation_form_telephone').value;

            if(Object.keys(reservation).indexOf("lastname") ==-1 || reservation.lastname ==''){
                reservation.lastname = lastname;
            }
            if(Object.keys(reservation).indexOf("firstname") ==-1 || reservation.firstname ==''){
                reservation.firstname = firstname;
            }
            if(Object.keys(reservation).indexOf("email") ==-1 || reservation.email ==''){
                reservation.email = email;
            }
            if(Object.keys(reservation).indexOf("telephone") ==-1 || reservation.telephone ==''){
                reservation.telephone = telephone;
            }

            summaryMassage.innerHTML = 'Massage: '+reservation.massageName;
            summaryMassagist.innerHTML = 'Masseur: '+reservation.massagistName;
            summaryDate.innerHTML = 'Date et horaire: '+reservation.date+' '+reservation.timeslot;
            summaryPrice.innerHTML = 'Prix: '+price;
            
        }
       

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
    .then(response => console.log(JSON.stringify(response)))
    .catch(error => console.log("Erreur : " + error));
    window.location.href = '/payement'
        
})