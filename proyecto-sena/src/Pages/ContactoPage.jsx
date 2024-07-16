import React from 'react';

function ContactoPage() {
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
        <h2>Contacto</h2>
        <form>
          <label>
            Nombre:
            <input type="text" name="name" />
          </label>
          <label>
            Email:
            <input type="email" name="email" />
          </label>
          <label>
            Mensaje:
            <textarea name="message"></textarea>
          </label>
          <button type="submit">Enviar</button>
        </form>
      </main>
      <footer>
        <p>Proyecto Sena, Nicolas Mutis</p>
      </footer>
    </div>
  );
}

export default ContactoPage;
