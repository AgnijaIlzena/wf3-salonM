// let options = {
//     root: document.querySelector('#scrollArea'),
//     rootMargin: '0px',
//     threshold: 1.0
//   }
  
//   let observer = new IntersectionObserver(callback, options);
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
