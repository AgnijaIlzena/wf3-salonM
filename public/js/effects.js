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
const btnDetails = document.querySelectorAll('.btnDetails');
btnDetails.forEach(btn => {

        // Get the modal
        let modal = document.getElementById("myModal");
        // Get the <span> element that closes the modal
        let span = document.getElementsByClassName("close")[0];

        let el = document.getElementById("showName");

        btn.addEventListener('click', (event)=> {
          event.preventDefault();
          modal.style.display = "block";
          // Insert Data here
          console.log(el.dataset.massage.name);
        })

        span.addEventListener('click', (event)=> {
          event.preventDefault();
          modal.style.display = "none";
        })
        
        window.addEventListener('click', (event)=> {
          if (event.target == modal) {
            modal.style.display = "none";
          }
        })

        console.log('hello');
        // console.log(el.dataset.name);

        
})




