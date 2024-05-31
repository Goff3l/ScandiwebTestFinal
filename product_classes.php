<?php
class Database {
    private $host = "localhost";
    private $username = "task";
    private $password = "task123";
    private $database = "task";
    private $connection;

    public function __construct() {
        $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    public function getConnection() {
        return $this->connection;
    }

    public function query($sql) {
        return $this->connection->query($sql);
    }

    public function prepare($sql) {
        return $this->connection->prepare($sql);
    }

    public function __destruct() {
        $this->connection->close();
    }
}

abstract class Product {
    protected $sku;
    protected $name;
    protected $price;

    public function __construct($sku, $name, $price) {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
    }

    abstract public function save();
}

class DVD extends Product {
    private $size;

    public function __construct($sku, $name, $price, $size) {
        parent::__construct($sku, $name, $price);
        $this->size = $size;
    }

    public function save() {
        $db = new Database();
        $stmt = $db->prepare("INSERT INTO products (sku, name, price, type, size) VALUES (?, ?, ?, 'DVD', ?)");
        $stmt->bind_param("ssds", $this->sku, $this->name, $this->price, $this->size);
        $stmt->execute();
        $stmt->close();
    }
}

class Book extends Product {
    private $weight;

    public function __construct($sku, $name, $price, $weight) {
        parent::__construct($sku, $name, $price);
        $this->weight = $weight;
    }

    public function save() {
        $db = new Database();
        $stmt = $db->prepare("INSERT INTO products (sku, name, price, type, weight) VALUES (?, ?, ?, 'Book', ?)");
        $stmt->bind_param("ssds", $this->sku, $this->name, $this->price, $this->weight);
        $stmt->execute();
        $stmt->close();
    }
}

class Furniture extends Product {
    private $height;
    private $width;
    private $length;

    public function __construct($sku, $name, $price, $height, $width, $length) {
        parent::__construct($sku, $name, $price);
        $this->height = $height;
        $this->width = $width;
        $this->length = $length;
    }

    public function save() {
        $db = new Database();
        $stmt = $db->prepare("INSERT INTO products (sku, name, price, type, height, width, length) VALUES (?, ?, ?, 'Furniture', ?, ?, ?)");
        $stmt->bind_param("ssdddd", $this->sku, $this->name, $this->price, $this->height, $this->width, $this->length);
        $stmt->execute();
        $stmt->close();
    }
}

function getAllProducts() {
    $db = new Database();
    $result = $db->query("SELECT * FROM products");
    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
    return $products;
}

function deleteProducts($skus) {
    $db = new Database();
    foreach ($skus as $sku) {
        $stmt = $db->prepare("DELETE FROM products WHERE sku = ?");
        $stmt->bind_param("s", $sku);
        $stmt->execute();
        $stmt->close();
    }
}
?>
