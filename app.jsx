import React from 'react';
import { BrowserRouter as Router, Route, Switch } from 'react-router-dom';
import HomePage from './proyecto-sena/src/Pages/HomePage.jsx';
import ProductosPage from './proyecto-sena/src/Pages/ProductosPage.jsx';
import TiendasPage from './pages/TiendasPage';
import ContactoPage from './proyecto-sena/src/Pages/ContactoPage.jsx';
import './App.css';

function App() {
  return (
    <Router>
      <div className="App">
        <Switch>
          <Route exact path="/" component={HomePage} />
          <Route path="/productos" component={ProductosPage} />
          <Route path="/tiendas" component={TiendasPage} />
          <Route path="/contacto" component={ContactoPage} />
        </Switch>
      </div>
    </Router>
  );
}

export default App;
