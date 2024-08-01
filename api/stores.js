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

// Obtener todas las tiendas
router.get('/', (req, res) => {
    let sql = 'SELECT * FROM stores';
    db.query(sql, (err, results) => {
        if (err) throw err;
        res.json(results);
    });
});

// Agregar una nueva tienda
router.post('/', (req, res) => {
    const newStore = req.body;
    let sql = 'INSERT INTO stores SET ?';
    db.query(sql, newStore, (err, result) => {
        if (err) throw err;
        res.json({ id: result.insertId, ...newStore });
    });
});

// Actualizar una tienda
router.put('/:id', (req, res) => {
    const { id } = req.params;
    const updatedStore = req.body;
    let sql = 'UPDATE stores SET ? WHERE id = ?';
    db.query(sql, [updatedStore, id], (err, result) => {
        if (err) throw err;
        res.json({ id, ...updatedStore });
    });
});

// Eliminar una tienda
router.delete('/:id', (req, res) => {
    const { id } = req.params;
    let sql = 'DELETE FROM stores WHERE id = ?';
    db.query(sql, [id], (err, result) => {
        if (err) throw err;
        res.json({ message: 'Store deleted', id });
    });
});

module.exports = router;
