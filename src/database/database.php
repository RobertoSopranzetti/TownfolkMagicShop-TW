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
        $stmt = $this->db->prepare("SELECT nome, descrizione FROM categorie");
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

    public function getOrders()
    {
        $stmt = $this->db->prepare("SELECT * FROM ordini");
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getOrderById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM ordini WHERE id=?");
        $stmt->bind_param('i', $id);
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

        return $result->fetch_all(MYSQLI_ASSOC);
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

    public function getLimitedProducts(){
        $stmt = $this->db->prepare("SELECT * FROM ordini WHERE edizione_limitata = 1");
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getProductsByUserId($userId)
    {
        $query = "SELECT id, titolo, immagine, descrizione, prezzo, sconto, quantita_disponibile, data_creazione
            FROM prodotti
            WHERE id_venditore=?";
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

    public function insertProduct($titolo, $descrizione, $prezzo, $sconto, $quantita_disponibile, $id_categoria, $id_venditore, $immagine)
    {
        $query = "INSERT INTO prodotti (titolo, descrizione, prezzo, sconto, quantita_disponibile, id_categoria, id_venditore, immagine) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ssdiisis', $titolo, $descrizione, $prezzo, $sconto, $quantita_disponibile, $id_categoria, $id_venditore, $immagine);
        $stmt->execute();

        return $stmt->insert_id;
    }

    public function updateProduct($id, $titolo, $descrizione, $prezzo, $sconto, $quantita_disponibile, $id_categoria, $immagine)
    {
        $query = "UPDATE prodotti SET titolo = ?, descrizione = ?, prezzo = ?, sconto = ?, quantita_disponibile = ?, id_categoria = ?, immagine = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ssdiissi', $titolo, $descrizione, $prezzo, $sconto, $quantita_disponibile, $id_categoria, $immagine, $id);

        return $stmt->execute();
    }

    public function deleteProduct($id)
    {
        $query = "DELETE FROM prodotti WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();

        return $stmt->affected_rows > 0;
    }

    public function insertCartItem($id_carrello, $id_prodotto, $quantita, $prezzo)
    {
        $query = "INSERT INTO articoli_carrello (id_carrello, id_prodotto, quantita, prezzo) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('iiid', $id_carrello, $id_prodotto, $quantita, $prezzo);
        return $stmt->execute();
    }

    public function deleteCartItem($id)
    {
        $query = "DELETE FROM articoli_carrello WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $id);
        return $stmt->execute();
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
        $query = "INSERT INTO utenti (email, username, nome, cognome, password, id_ruolo) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('sssssi', $email, $username, $nome, $cognome, $password, $id_ruolo);
        $stmt->execute();

        return $stmt->insert_id;
    }

    public function checkLogin($identifier, $password)
    {
        $query = "SELECT id, nome, email, username, id_ruolo FROM utenti WHERE (email = ? OR username = ?) AND password = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('sss', $identifier, $identifier, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
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
    public function getCarts()
    {
        $stmt = $this->db->prepare("SELECT * FROM carrelli");
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getCartById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM carrelli WHERE id=?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getNotifications()
    {
        $stmt = $this->db->prepare("SELECT * FROM notifiche");
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getNotificationById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM notifiche WHERE id=?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
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