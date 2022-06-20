const elementsForAjax = document.querySelectorAll('.ajax');
const calendarSection = document.querySelector('.calendar');
const timeslotsSection = document.querySelector('.timeslots');
const formSection = document.querySelector('.form');
const summary = document.querySelector('.summary');

const lastname = document.querySelector('#reservation_form_lastname').value;
const firstname = document.querySelector('#reservation_form_firstname').value;
const email = document.querySelector('#reservation_form_email').value;
const telephone = document.querySelector('#reservation_form_telephone').value;
const massageText = document.querySelector('.massage');

const next = document.querySelector('.next');
next.addEventListener('click',()=>{
    if(lastname.length != 0 && firstname.length != 0 && email.length != 0 && telephone!=0){
        summary.style.display = 'block';
        next.style.display = 'none';
        }
})


// let massage = massageText.dataset.massage;
// console.log(massage);

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


        let massage = massageText.dataset.massage;
        let massagist = el.dataset.massagist;
        let date = el.dataset.date;
        let timeslot = el.dataset.timeslot;
      
        localStorage.setItem('reservation', JSON.stringify(
            {
                'massage':massage,
                'massagist':massagist,
                'date':date,
                'timeslot':timeslot,
                'lastname':lastname,
                'firstname':firstname,
                'email':email,
                'telephone':telephone
            })
        )
            
        let reservation = localStorage.getItem('reservation');
        
        
        fetch("/reservation", {
            method: "POST",
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: reservation
        })
        .then(response => response.json())
        .then(response => alert(response))
        .catch(error => alert("Erreur : " + error));
            
    })

})