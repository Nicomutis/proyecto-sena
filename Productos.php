<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comparador de Precios - Productos</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="Styles/stylesproductos.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playwrite+GB+S:ital,wght@0,100..400;1,100..400&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <?php
// Iniciar conexión a la base de datos
$servername = "localhost";
$username = "root"; // Cambia según tu configuración
$password = ""; // Cambia según tu configuración
$dbname = "comparador_precios"; // Nombre de tu base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Manejar búsqueda
$searchTerm = isset($_GET['searchTerm']) ? $_GET['searchTerm'] : '';
$productos = [];

// Obtener productos de la base de datos
$sql = "SELECT * FROM productos WHERE nombre LIKE '%$searchTerm%'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $productos[] = $row;
    }
}
$conn->close();
?>

</head>
<body>
    <header>
        <h1>Comparador de Precios</h1>
        <nav>
            <ul>
                <li><a href="index.html">Inicio</a></li>
                <li><a href="productos.html">Productos</a></li>
                <li><a href="tiendas.html">Tiendas</a></li>
                <li><a href="contacto.html">Contacto</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="search">
            <input type="text" id="searchTerm" placeholder="Buscar productos...">
            <button onclick="searchProducts()">Buscar</button>
            <div id="loadingMessage" style="display: none;">Buscando...</div>
            <div id="noResultsMessage" style="display: none;">No se encontraron productos.</div>
        </section>

        <section class="product-list" id="productList">
            <!-- Lista de productos -->
    <?php foreach ($productos as $producto): ?>
    <div class="product" data-name="<?= $producto['nombre'] ?>">
        <img src="<?= $producto['imagen'] ?>" alt="<?= $producto['nombre'] ?>">
        <h2><?= $producto['nombre'] ?></h2>
        <p>Precio: <?= $producto['precio'] ?></p>
    </div>
    <?php endforeach; ?>
</section>

            <div class="product" data-name="Aceite Extra Virgen">
                <img src="img/Productos/Aceitextravirgen.jpg" alt="Aceite Extra Virgen">
                <h2>Aceite Extra Virgen</h2>
                <p>Precio: $11,000</p>
            </div>

            <div class="product" data-name="Pan Bimbo Artesanal">
                <img src="img/Productos/panbimbo.jpg" alt="Pan Bimbo Artesanal">
                <h2>Pan Bimbo Artesanal</h2>
                <p>Precio: $15,000</p>
            </div>

            <!-- Añadir más productos aquí -->
        </section>
    </main>

    <footer>
        <p>Proyecto Sena, Nicolas Mutis</p>
    </footer>

    <button id="backToTopBtn" onclick="scrollToTop()">&#8679; Volver arriba</button>

    <script src="script.js"></script>
</body>
</html>

