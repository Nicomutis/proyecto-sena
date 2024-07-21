function searchProducts() {
    const searchTerm = document.getElementById('searchTerm').value.toLowerCase();
    const productList = document.getElementById('productList');
    productList.innerHTML = '';

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
                document.getElementById('noResultsMessage').style.display = 'block';
            }
        })
        .catch(error => console.error('Error:', error));
}
