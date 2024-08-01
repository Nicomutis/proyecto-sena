const express = require('express');
const router = express.Router();
const mysql = require('mysql');

// Configuración de la base de datos
const db = mysql.createConnection({
    host: process.env.DB_HOST,
    user: process.env.DB_USER,
    password: process.env.DB_PASS,
    database: process.env.DB_NAME
});

db.connect((err) => {
    if (err) throw err;
    console.log('MySQL Connected...');
});

// Obtener todos los productos
router.get('/', (req, res) => {
    let sql = 'SELECT * FROM products';
    db.query(sql, (err, results) => {
        if (err) throw err;
        res.json(results);
    });
});

// Agregar un nuevo producto
router.post('/', (req, res) => {
    const newProduct = req.body;
    let sql = 'INSERT INTO products SET ?';
    db.query(sql, newProduct, (err, result) => {
        if (err) throw err;
        res.json({ id: result.insertId, ...newProduct });
    });
});

// Actualizar un producto
router.put('/:id', (req, res) => {
    const { id } = req.params;
    const updatedProduct = req.body;
    let sql = 'UPDATE products SET ? WHERE id = ?';
    db.query(sql, [updatedProduct, id], (err, result) => {
        if (err) throw err;
        res.json({ id, ...updatedProduct });
    });
});

// Eliminar un producto
router.delete('/:id', (req, res) => {
    const { id } = req.params;
    let sql = 'DELETE FROM products WHERE id = ?';
    db.query(sql, [id], (err, result) => {
        if (err) throw err;
        res.json({ message: 'Product deleted', id });
    });
});

module.exports = router;
