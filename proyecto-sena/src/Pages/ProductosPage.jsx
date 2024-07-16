import React, { useState } from 'react';

const products = [
  { name: 'Aceite Extra Virgen', price: 11000, image: 'img/Productos/Aceitextravirgen.jpg' },
  { name: 'Pan Bimbo Artesanal', price: 15000, image: 'img/Productos/panbimbo.jpg' }
  // Añadir más productos aquí
];

function ProductosPage() {
  const [searchTerm, setSearchTerm] = useState('');

  const filteredProducts = products.filter(product =>
    product.name.toLowerCase().includes(searchTerm.toLowerCase())
  );

  return (
    <div>
      <header>
        <h1>Comparador de Precios</h1>
        <nav>
          <ul>
            <li><a href="/">Inicio</a></li>
            <li><a href="/productos">Productos</a></li>
            <li><a href="/tiendas">Tiendas</a></li>
            <li><a href="/contacto">Contacto</a></li>
          </ul>
        </nav>
      </header>
      <main>
        <section className="search">
          <input
            type="text"
            placeholder="Buscar productos..."
            value={searchTerm}
            onChange={(e) => setSearchTerm(e.target.value)}
          />
          <button>Buscar</button>
        </section>
        <section className="product-list">
          {filteredProducts.length > 0 ? (
            filteredProducts.map((product, index) => (
              <div key={index} className="product">
                <img src={product.image} alt={product.name} />
                <h2>{product.name}</h2>
                <p>Precio: ${product.price}</p>
              </div>
            ))
          ) : (
            <div>No se encontraron productos.</div>
          )}
        </section>
      </main>
      <footer>
        <p>Proyecto Sena, Nicolas Mutis</p>
      </footer>
    </div>
  );
}

export default ProductosPage;
