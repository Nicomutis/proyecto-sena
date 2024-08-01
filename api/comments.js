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

// Obtener todos los comentarios
router.get('/', (req, res) => {
    let sql = 'SELECT * FROM comments';
    db.query(sql, (err, results) => {
        if (err) throw err;
        res.json(results);
    });
});

// Agregar un nuevo comentario
router.post('/', (req, res) => {
    const { email, message } = req.body;
    let sql = 'INSERT INTO comments (email, message) VALUES (?, ?)';
    db.query(sql, [email, message], (err, result) => {
        if (err) throw err;
        res.json({ id: result.insertId, email, message });
    });
});

module.exports = router;
