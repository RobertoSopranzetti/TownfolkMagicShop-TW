<?php
class DatabaseHelper
{
    private $db;

    public function __construct($servername, $username, $password, $dbname, $port)
    {
        $this->db = new mysqli($servername, $username, $password, $dbname, $port);
        if ($this->db->connect_error) {
            die("Connection failed: " . $this->db->connect_error);
        }
    }

    public function getRandomProducts($n = 2)
    {
        $stmt = $this->db->prepare("SELECT id, titolo, immagine FROM prodotti ORDER BY RAND() LIMIT ?");
        $stmt->bind_param('i', $n);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getCategories()
    {
        $stmt = $this->db->prepare("SELECT * FROM categorie");
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getCategoryById($idcategory)
    {
        $stmt = $this->db->prepare("SELECT nome, descrizione FROM categorie WHERE id=?");
        $stmt->bind_param('i', $idcategory);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getProducts($n = -1)
    {
        $query = "SELECT * FROM prodotti ORDER BY data_creazione DESC";
        if ($n > 0) {
            $query .= " LIMIT ?";
        }
        $stmt = $this->db->prepare($query);
        if ($n > 0) {
            $stmt->bind_param('i', $n);
        }
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getProductById($id)
    {
        $query = "SELECT * FROM prodotti WHERE id=?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    public function getProductsByCategory($idcategory)
    {
        $query = "SELECT * FROM prodotti WHERE id_categoria=?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $idcategory);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getProductsByPriceRange($minPrice, $maxPrice)
    {
        $query = "SELECT * FROM prodotti WHERE prezzo BETWEEN ? AND ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('dd', $minPrice, $maxPrice);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getLimitedProducts()
    {
        $stmt = $this->db->prepare("SELECT * FROM prodotti WHERE edizione_limitata = 1");
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getShortageProducts($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM prodotti WHERE quantita_disponibile = 0 AND id_venditore = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function searchProducts($query)
    {
        $query = "%" . $query . "%";
        $sql = "SELECT id, titolo, prezzo, immagine FROM prodotti WHERE titolo LIKE ? OR descrizione LIKE ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('ss', $query, $query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getProductsByUserId($userId)
    {
        $query = "SELECT * FROM prodotti WHERE id_venditore=?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getProductByIdAndSeller($productId, $sellerId)
    {
        $query = "SELECT * FROM prodotti WHERE id = ? AND id_venditore = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ii', $productId, $sellerId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function getSellerIdByProductId($productId)
    {
        $query = "SELECT id_venditore FROM prodotti WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['id_venditore'];
    }

    public function insertProduct($titolo, $descrizione, $prezzo, $sconto, $quantita, $categoria, $id_utente, $immagine, $edizione_limitata)
    {
        $query = "INSERT INTO prodotti (titolo, descrizione, prezzo, sconto, quantita_disponibile, id_categoria, id_venditore, immagine, edizione_limitata)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ssddiiisi', $titolo, $descrizione, $prezzo, $sconto, $quantita, $categoria, $id_utente, $immagine, $edizione_limitata);
        $stmt->execute();
        return $stmt->insert_id;
    }

    public function updateProduct($id_prodotto, $titolo, $descrizione, $prezzo, $sconto, $quantita, $categoria, $immagine, $edizione_limitata)
    {
        $query = "UPDATE prodotti SET titolo = ?, descrizione = ?, prezzo = ?, sconto = ?, quantita_disponibile = ?, id_categoria = ?, immagine = ?, edizione_limitata = ?
                WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ssddiisii', $titolo, $descrizione, $prezzo, $sconto, $quantita, $categoria, $immagine, $edizione_limitata, $id_prodotto);
        $stmt->execute();
    }

    public function reduceProductQuantity($productId, $quantity)
    {
        $query = "UPDATE prodotti SET quantita_disponibile = quantita_disponibile - ? WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ii', $quantity, $productId);
        $stmt->execute();

        // Controlla se il prodotto è esaurito
        $query = "SELECT id_venditore, quantita_disponibile, titolo FROM prodotti WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row['quantita_disponibile'] <= 0) {
            $message = "Il prodotto '{$row['titolo']}' è esaurito.";
            $this->sendNotification($row['id_venditore'], $message);
        }
    }

    public function deleteProduct($id)
    {
        $query = "DELETE FROM prodotti WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();

        return $stmt->affected_rows > 0;
    }

    public function createCart($id_utente)
    {
        $query = "INSERT INTO carrelli (id_utente, id_stato_carrello, data_creazione) VALUES (?, 1, NOW())";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $id_utente);
        $stmt->execute();
        $stmt->close();
    }

    public function addToCart($id_utente, $id_prodotto, $quantita)
    {
        // Verifica se esiste un carrello aperto per l'utente
        $query = "SELECT id FROM carrelli WHERE id_utente = ? AND id_stato_carrello = 1";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $id_utente);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows === 0) {
            // Se non esiste un carrello aperto, creane uno nuovo
            $stmt->close();
            $this->createCart($id_utente);
            // Riprova a ottenere l'id del carrello appena creato
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('i', $id_utente);
            $stmt->execute();
            $stmt->store_result();
        }
        $stmt->bind_result($id_carrello);
        $stmt->fetch();
        $stmt->close();

        // Aggiungi il prodotto al carrello
        $query = "INSERT INTO articoli_carrello (id_carrello, id_prodotto, quantita, prezzo)
            VALUES (?, ?, ?, (SELECT prezzo FROM prodotti WHERE id = ?))
            ON DUPLICATE KEY
            UPDATE quantita = quantita + VALUES(quantita)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('iiii', $id_carrello, $id_prodotto, $quantita, $id_prodotto);
        $stmt->execute();
        $stmt->close();
    }

    public function removeFromCart($id_utente, $id_prodotto)
    {
        $query = "DELETE FROM articoli_carrello WHERE id_carrello = (SELECT id FROM carrelli WHERE id_utente = ? AND id_stato_carrello = 1) AND id_prodotto = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ii', $id_utente, $id_prodotto);
        return $stmt->execute();
    }

    public function updateCartQuantity($id_utente, $id_prodotto, $quantita)
    {
        $query = "UPDATE articoli_carrello ac
            JOIN carrelli c ON ac.id_carrello = c.id
            SET ac.quantita = ?
            WHERE c.id_utente = ? AND c.id_stato_carrello = 1 AND ac.id_prodotto = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('iii', $quantita, $id_utente, $id_prodotto);
        return $stmt->execute();
    }

    public function getProductsInCart($id_utente)
    {
        $query = "SELECT p.*, ac.quantita, (p.prezzo * ac.quantita) AS prezzo_totale FROM prodotti p
            JOIN articoli_carrello ac ON p.id = ac.id_prodotto
            JOIN carrelli c ON ac.id_carrello = c.id
            WHERE c.id_utente = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $id_utente);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function clearCart($userId)
    {
        $query = "DELETE FROM articoli_carrello WHERE id_carrello = (SELECT id FROM carrelli WHERE id_utente = ? AND id_stato_carrello = 1)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $userId);
        return $stmt->execute();
    }

    public function createOrder($userId, $totale)
    {
        $query = "INSERT INTO ordini (id_utente, id_stato_ordine, data_ordine, spesa_complessiva) VALUES (?, 1, NOW(), ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('id', $userId, $totale);
        $stmt->execute();
        return $stmt->insert_id;
    }

    public function getOrderById($orderId)
    {
        $query = "SELECT o.id, o.data_ordine, DATE_ADD(o.data_ordine, INTERVAL 7 DAY) AS consegna_prevista, so.nome AS status,
                            p.titolo AS prodotto_nome, p.immagine AS prodotto_immagine, p.id AS prodotto_id,
                            ao.quantita, ao.prezzo, u.nome AS cliente, p.id_venditore
                    FROM ordini o
                    JOIN articoli_ordine ao ON o.id = ao.id_ordine
                    JOIN prodotti p ON ao.id_prodotto = p.id
                    JOIN utenti u ON o.id_utente = u.id
                    JOIN stati_ordini so ON o.id_stato_ordine = so.id
                    WHERE o.id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $orderId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function updateOrderStatus($orderId, $newStatus)
    {
        $query = "UPDATE ordini SET id_stato_ordine = (SELECT id FROM stati_ordini WHERE nome = ?) WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('si', $newStatus, $orderId);
        return $stmt->execute();
    }

    public function getOrdersByUserId($userId)
    {
        $query = "SELECT o.id, o.data_ordine, DATE_ADD(o.data_ordine, INTERVAL 7 DAY) AS consegna_prevista, so.nome AS status,
                    o.spesa_complessiva, p.titolo AS prodotto_nome, p.immagine AS prodotto_immagine, p.id AS prodotto_id,
                    ao.quantita, ao.prezzo
            FROM ordini o
            JOIN articoli_ordine ao ON o.id = ao.id_ordine
            JOIN prodotti p ON ao.id_prodotto = p.id
            JOIN stati_ordini so ON o.id_stato_ordine = so.id
            WHERE o.id_utente = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getOrdersBySellerId($sellerId)
    {
        $query = "SELECT o.id, o.data_ordine, o.spesa_complessiva, DATE_ADD(o.data_ordine, INTERVAL 7 DAY) AS consegna_prevista, so.nome AS status,
                    p.titolo AS prodotto_nome, p.immagine AS prodotto_immagine, p.id AS prodotto_id,
                    ao.quantita, ao.prezzo, u.username AS cliente
            FROM ordini o
            JOIN articoli_ordine ao ON o.id = ao.id_ordine
            JOIN prodotti p ON ao.id_prodotto = p.id
            JOIN utenti u ON o.id_utente = u.id
            JOIN stati_ordini so ON o.id_stato_ordine = so.id
            WHERE p.id_venditore = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $sellerId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getOrderItems($orderId)
    {
        $query = "SELECT p.titolo, ao.quantita, ao.prezzo
                FROM articoli_ordine ao
                JOIN prodotti p ON ao.id_prodotto = p.id
                WHERE ao.id_ordine = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $orderId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function insertOrderItem($id_ordine, $id_prodotto, $quantita, $prezzo)
    {
        $query = "INSERT INTO articoli_ordine (id_ordine, id_prodotto, quantita, prezzo) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('iiid', $id_ordine, $id_prodotto, $quantita, $prezzo);
        return $stmt->execute();
    }

    public function deleteOrderItem($id)
    {
        $query = "DELETE FROM articoli_ordine WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }

    public function getUserById($id)
    {
        $query = "SELECT id, username FROM utenti WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    public function registerUser($nome, $cognome, $email, $username, $password, $id_ruolo)
    {
        $query = "INSERT INTO utenti (email, username, nome, cognome, id_ruolo, password) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ssssis', $email, $username, $nome, $cognome, $id_ruolo, $password);
        $stmt->execute();

        return $stmt->insert_id;
    }

    public function checkLogin($identifier, $password)
    {
        // Recupera l'utente e le credenziali
        $query = "SELECT id, nome, email, username, id_ruolo, password
                FROM utenti
                WHERE (email = ? OR username = ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ss', $identifier, $identifier);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Verifica la password
            if (password_verify($password, $row['password'])) {
                return $row;
            }
        }
        return false;
    }


    public function getRoleByUsername($username)
    {
        $query = "SELECT r.nome AS ruolo FROM utenti u JOIN ruoli r ON u.id_ruolo = r.id WHERE u.username = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    public function getUserNotifications($userId)
    {
        $query = "SELECT * FROM notifiche n WHERE n.id_utente = ? ORDER BY n.data_creazione DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function sendNotification($userId, $message)
    {
        $query = "INSERT INTO notifiche (id_utente, messaggio, data_creazione, id_stato_notifica) VALUES (?, ?, NOW(), 1)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('is', $userId, $message);
        return $stmt->execute();
    }

    public function markNotificationAsRead($notificationId, $userId)
    {
        $query = "UPDATE notifiche SET id_stato_notifica = 2 WHERE id = ? AND id_utente = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ii', $notificationId, $userId);
        return $stmt->execute();
    }

    public function markNotificationAsUnread($notificationId, $userId)
    {
        $query = "UPDATE notifiche SET id_stato_notifica = 1 WHERE id = ? AND id_utente = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ii', $notificationId, $userId);
        return $stmt->execute();
    }

    public function deleteNotification($notificationId, $userId)
    {
        $query = "DELETE FROM notifiche WHERE id = ? AND id_utente = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ii', $notificationId, $userId);
        return $stmt->execute();
    }

    public function getCartStatuses()
    {
        $stmt = $this->db->prepare("SELECT * FROM stati_carrelli");
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getOrderStatuses()
    {
        $stmt = $this->db->prepare("SELECT * FROM stati_ordini");
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getNotificationStatuses()
    {
        $stmt = $this->db->prepare("SELECT * FROM stati_notifiche");
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getMinPrice()
    {
        $stmt = $this->db->prepare("SELECT MIN(prezzo) as min_price FROM prodotti WHERE quantita_disponibile > 0");
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc()["min_price"];
    }

    public function getMaxPrice()
    {
        $stmt = $this->db->prepare("SELECT MAX(prezzo) as max_price FROM prodotti WHERE quantita_disponibile > 0");
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc()["max_price"];
    }
}
?>