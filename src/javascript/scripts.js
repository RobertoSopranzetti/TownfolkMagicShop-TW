function aggiungiAlCarrello(idProdotto) {
    fetch(`carrello.php?azione=aggiungi&id=${idProdotto}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Mostra un messaggio di successo sotto l'icona del carrello
                let carrelloIcon = document.getElementById('carrello-icon');
                let message = document.createElement('div');
                message.className = 'alert alert-success';
                message.innerText = data.message;
                carrelloIcon.appendChild(message);
                setTimeout(() => {
                    carrelloIcon.removeChild(message);
                }, 3000);
            } else {
                alert(data.message);
            }
        });
}

function rimuoviDalCarrello(idProdotto) {
    fetch(`carrello.php?azione=rimuovi&id=${idProdotto}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message);
            }
        });
}

function aggiornaQuantita(idProdotto, quantita) {
    fetch(`carrello.php?azione=aggiorna&id=${idProdotto}&quantita=${quantita}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message);
            }
        });
}

function aggiornaTotale(subtotale) {
    let spedizione = parseFloat(document.getElementById('spedizione').value);
    let totale = subtotale + spedizione;
    document.getElementById('totale').innerText = totale.toFixed(2) + ' €';
}

function applicaCoupon() {
    let coupon = document.getElementById('coupon').value;
    // Logica fittizia per applicare il coupon
    alert('Coupon applicato: ' + coupon);
}