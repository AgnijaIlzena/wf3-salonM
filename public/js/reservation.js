const massagistBtn = document.querySelectorAll('.massagistBtn');
const calendar = document.querySelector('.calendar');


massagistBtn.forEach(btn=>{
    btn.addEventListener('click', () => {
        let id = btn.dataset.id;
        
        fetch(`/massagist/{massagistId}`, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
            .then(response => response.json())
            .then(data => {
                data.id = id;
            })
            .catch(error => alert(error))
            calendar.style.display = 'block';
})


})