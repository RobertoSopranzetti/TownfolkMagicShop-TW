async function aggiungiAlCarrello(idProdotto) {
    const quantita = document.getElementById('quantity').value;
    console.log(`Aggiungi al carrello: idProdotto=${idProdotto}, quantita=${quantita}`);
    const url = 'api-carrello.php?azione=Inserisci&id=' + idProdotto + '&quantita=' + quantita;
    console.log(`URL della richiesta: ${url}`); // Log per verificare l'URL della richiesta
    try {
        const response = await fetch(url);
        console.log('Response status:', response.status);
        console.log('Response headers:', response.headers);
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const data = await response.json();
        console.log('Response data:', data);
        if (data.success) {
            // Mostra un messaggio di successo con una finestra di avviso
            alert(data.message);
        } else {
            alert(data.message);
        }
    } catch (error) {
        console.error('Errore:', error);
    }
}

async function rimuoviDalCarrello(idProdotto) {
    const url = 'api-carrello.php?azione=Cancella&id=' + idProdotto;
    console.log(`URL della richiesta: ${url}`); // Log per verificare l'URL della richiesta
    try {
        const response = await fetch(url);
        console.log('Response status:', response.status);
        console.log('Response headers:', response.headers);
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const data = await response.json();
        console.log('Response data:', data);
        if (data.success) {
            // Mostra un messaggio di successo con una finestra di avviso
            alert(data.message);
            location.reload();
        } else {
            alert(data.message);
        }
    } catch (error) {
        console.error('Errore:', error);
    }
}

async function aggiornaQuantita(idProdotto, quantita) {
    const url = 'api-carrello.php?azione=Aggiorna&id=' + idProdotto + '&quantita=' + quantita;
    try {
        const response = await fetch(url);
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const data = await response.json();
        console.log('Response data:', data);
        if (data.success) {
            location.reload();
        } else {
            alert(data.message);
        }
    } catch (error) {
        console.error('Errore:', error);
    }
}

function aggiornaTotale() {
    const subtotale = parseFloat(document.getElementById('subtotale').innerText.replace(' €', ''));
    const spedizione = parseFloat(document.getElementById('spedizione').value);
    const totale = subtotale + spedizione;
    document.getElementById('totale').innerText = totale.toFixed(2) + ' €';
}

function applicaCoupon() {
    const coupon = document.getElementById('coupon').value;
    // Logica fittizia per applicare il coupon
    alert('Coupon applicato: ' + coupon);
}

async function performSearch(query) {
    if (query.length < 3) {
        // Non eseguire la ricerca se la query è troppo breve
        return;
    }

    const url = 'cerca.php?q=' + encodeURIComponent(query);
    try {
        const response = await fetch(url);
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const data = await response.json();
        console.log('Search results:', data);
        displaySearchResults(data);
    } catch (error) {
        console.error('Errore durante la ricerca:', error);
    }
}

function displaySearchResults(results) {
    const searchResultsContainer = document.getElementById('search-results');
    searchResultsContainer.innerHTML = '';

    if (results.length === 0) {
        searchResultsContainer.innerHTML = '<p>Nessun risultato trovato.</p>';
        return;
    }

    results.forEach(result => {
        const resultItem = document.createElement('div');
        resultItem.classList.add('search-result-item');
        resultItem.innerHTML = `
            <a href="prodotto.php?id=${result.id}">
                <img src="${result.immagine}" alt="${result.titolo}" class="search-result-image">
                <div class="search-result-info">
                    <h5>${result.titolo}</h5>
                    <p>${result.prezzo} €</p>
                </div>
            </a>
        `;
        searchResultsContainer.appendChild(resultItem);
    });
}