document.addEventListener('DOMContentLoaded', () => {
    // Manejo del formulario de contacto
    const contactForm = document.getElementById('contactForm');

    contactForm.addEventListener('submit', async (event) => {
        event.preventDefault();

        const formData = new FormData(contactForm);
        const data = Object.fromEntries(formData);

        try {
            const response = await fetch('/api/comments', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            });

            if (response.ok) {
                alert('Comentario enviado exitosamente');
                contactForm.reset();
            } else {
                alert('Error al enviar el comentario');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Error al enviar el comentario');
        }
    });

    // Manejo de la búsqueda de productos
    const searchButton = document.getElementById('searchButton');
    searchButton.addEventListener('click', searchProducts);

    function searchProducts() {
        const searchTerm = document.getElementById('searchTerm').value.toLowerCase();
        const productList = document.getElementById('productList');
        const noResultsMessage = document.getElementById('noResultsMessage');
        productList.innerHTML = '';
        noResultsMessage.style.display = 'none';

        fetch('/api/products')
            .then(response => response.json())
            .then(data => {
                const filteredProducts = data.filter(product => 
                    product.name.toLowerCase().includes(searchTerm)
                );

                if (filteredProducts.length > 0) {
                    const productsById = {};
                    filteredProducts.forEach(product => {
                        if (!productsById[product.id]) {
                            productsById[product.id] = {
                                id: product.id,
                                name: product.name,
                                image: product.image,
                                prices: []
                            };
                        }
                        productsById[product.id].prices.push({
                            store: product.store_name,
                            price: product.price
                        });
                    });

                    for (let productId in productsById) {
                        const product = productsById[productId];
                        const productDiv = document.createElement('div');
                        productDiv.classList.add('product');
                        productDiv.innerHTML = `
                            <img src="${product.image}" alt="${product.name}">
                            <h2>${product.name}</h2>
                            <div class="prices">
                                ${product.prices.map(priceInfo => `
                                    <p>${priceInfo.store}: $${priceInfo.price.toFixed(2)}</p>
                                `).join('')}
                            </div>
                        `;
                        productList.appendChild(productDiv);
                    }
                } else {
                    noResultsMessage.style.display = 'block';
                }
            })
            .catch(error => console.error('Error:', error));
    }
});
