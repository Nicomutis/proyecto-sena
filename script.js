const productos = [
    { nombre: 'Aceite Extra Virgen', precios: { tienda1: 11000, tienda2: 10500, tienda3: 11500 } },
    { nombre: 'Pan Bimbo Artesanal', precios: { tienda1: 15000, tienda2: 14500, tienda3: 15500 } }
];



function searchProducts() {
    const searchTerm = document.getElementById('searchTerm').value.toLowerCase();
    
    // Redirigir a la página de productos si la búsqueda se realiza desde la página de inicio
    if (window.location.pathname.endsWith('index.html')) {
        window.location.href = `productos.html?search=${searchTerm}`;
        return;
    }
    
    // Filtrar productos si la búsqueda se realiza desde la página de productos
    const products = document.querySelectorAll('.product');
    products.forEach(product => {
        const productName = product.getAttribute('data-name').toLowerCase();
        if (productName.includes(searchTerm)) {
            product.style.display = 'block';
        } else {
            product.style.display = 'none';
        }
    });
}

// Ejecutar la función de búsqueda cuando se carga la página de productos con una búsqueda
document.addEventListener('DOMContentLoaded', () => {
    if (window.location.pathname.endsWith('productos.html')) {
        const urlParams = new URLSearchParams(window.location.search);
        const searchTerm = urlParams.get('search');
        if (searchTerm) {
            document.getElementById('searchTerm').value = searchTerm;
            searchProducts();
        }
    }
});



// script.js

function searchProducts() {
    const searchTerm = document.getElementById('searchTerm').value.toLowerCase();
    const loadingMessage = document.getElementById('loadingMessage');
    const noResultsMessage = document.getElementById('noResultsMessage');

    loadingMessage.style.display = 'block';
    noResultsMessage.style.display = 'none';

    // Redirigir a la página de productos si la búsqueda se realiza desde la página de inicio
    if (window.location.pathname.endsWith('index.html')) {
        window.location.href = `productos.html?search=${searchTerm}`;
        return;
    }

    // Simular una breve demora para mostrar el mensaje de carga
    setTimeout(() => {
        loadingMessage.style.display = 'none';

        // Filtrar productos si la búsqueda se realiza desde la página de productos
        const products = document.querySelectorAll('.product');
        let resultsFound = false;

        products.forEach(product => {
            const productName = product.getAttribute('data-name').toLowerCase();
            if (productName.includes(searchTerm)) {
                product.style.display = 'block';
                resultsFound = true;
            } else {
                product.style.display = 'none';
            }
        });

        if (!resultsFound) {
            noResultsMessage.style.display = 'block';
        }
    }, 500); // Simular un retardo de 500 ms
}

// Ejecutar la función de búsqueda cuando se carga la página de productos con una búsqueda
document.addEventListener('DOMContentLoaded', () => {
    if (window.location.pathname.endsWith('productos.html')) {
        const urlParams = new URLSearchParams(window.location.search);
        const searchTerm = urlParams.get('search');
        if (searchTerm) {
            document.getElementById('searchTerm').value = searchTerm;
            searchProducts();
        }
    }
});

// Mostrar botón "Volver arriba" al desplazarse hacia abajo
window.onscroll = function() {
    const backToTopBtn = document.getElementById('backToTopBtn');
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        backToTopBtn.style.display = 'block';
    } else {
        backToTopBtn.style.display = 'none';
    }
};

// Función para desplazarse hacia arriba
function scrollToTop() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
}
