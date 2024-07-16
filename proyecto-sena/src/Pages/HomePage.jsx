import React from 'react';
import { Link } from 'react-router-dom';

function HomePage() {
  return (
    <div>
      <header>
        <h1>Comparador de Precios</h1>
        <nav>
          <ul>
            <li><Link to="/">Inicio</Link></li>
            <li><Link to="/productos">Productos</Link></li>
            <li><Link to="/tiendas">Tiendas</Link></li>
            <li><Link to="/contacto">Contacto</Link></li>
          </ul>
        </nav>
      </header>
      <main>
        <section className="search">
          <input type="text" placeholder="Buscar productos..." />
          <button>Buscar</button>
        </section>
      </main>
      <footer>
        <p>Proyecto Sena, Nicolas Mutis</p>
      </footer>
    </div>
  );
}

export default HomePage;
