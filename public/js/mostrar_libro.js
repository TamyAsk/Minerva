document.querySelectorAll('.star').forEach(star => {
    star.addEventListener('mouseover', () => {
        highlightStars(star);
    });

    star.addEventListener('mouseout', () => {
        clearStars();
    });

    star.addEventListener('click', () => {
        setRating(star);
    });
});

function highlightStars(star) {
    const stars = Array.from(document.querySelectorAll('.star'));
    stars.forEach(s => {
        if (s.dataset.value <= star.dataset.value) {
            s.style.color = 'gold';
        } else {
            s.style.color = 'black';
        }
    });
}

function clearStars() {
    const stars = Array.from(document.querySelectorAll('.star'));
    stars.forEach(star => {
        star.style.color = 'black';
    });
}

function setRating(star) {
    const rating = star.dataset.value;
    const libroId = document.querySelector('.libro-id').value;  // Asegúrate de tener el libro_id en la página
    const userId = document.querySelector('.user-id').value;  // O puedes usar el usuario autenticado con una variable JS o desde el backend

    document.querySelector('.rating').setAttribute('data-rating', rating);
    highlightStars(star);

    // Enviar la calificación al servidor
    fetch(`/libro/${libroId}/calificar`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: JSON.stringify({ calificacion: rating })
    })
    .then(response => response.json())
    .then(data => {
        console.log('Calificación guardada:', data.calificacion);
        alert(data.message);
    })
    .catch(error => {
        console.error('Error al guardar la calificación:', error);
    });
}
