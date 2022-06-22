// Delay effects in HOME page

const ratio = .1;

let options = {
  root: null,
  rootMargin: '0px',
  threshold: ratio
}

const handleIntersect = function(entries, observer) {
      entries.forEach(function(entry) {
          if (entry.intersectionRatio > ratio) {
              entry.target.classList.add('reveal-visible')
              observer.unobserve(entry.target)
          }        
  })   
}

const observer = new IntersectionObserver(handleIntersect, options);
document.querySelectorAll('.reveal').forEach(function(r) {
  observer.observe(r);
})

// Modal

let btnDetails = document.querySelectorAll(".btnDetails");
btnDetails.forEach(btn => {

          btn.addEventListener('click', ()=> {
          let modal = document.querySelector(".modal");      
          modal.style.display = "block";
          document.querySelector("#showName").innerText = btn.dataset.massageName;     
          document.querySelector("#showDescription").innerText = btn.dataset.massageDescription; 
          document.querySelector("#showPrice").innerText = `60 min ${btn.dataset.massagePrice} €` ;
          let cover =  document.querySelector("#showCover"); 
          cover.src =  `images/${btn.dataset.massageCover} `;  
          let buttonR = document.querySelector("#showReserve");
          buttonR.href = `/reservation/${btn.dataset.massageId}`;                 
          })  

          let close = document.querySelector(".close");
          close.addEventListener('click', (event)=> {
          event.preventDefault();
          let modal = document.querySelector(".modal");
          modal.style.display = "none";
          })
       })   
      
       window.addEventListener('click', (event)=> {
        let modal = document.querySelector(".modal");
        if (event.target == modal) {
          modal.style.display = "none";
        }
      })
      
      

      

