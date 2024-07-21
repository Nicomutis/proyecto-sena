const express = require('express');
const mysql = require('mysql');
const path = require('path');
const bodyParser = require('body-parser');
const dotenv = require('dotenv');
const nodemailer = require('nodemailer');

dotenv.config();

const app = express();
const port = process.env.PORT || 3000;

// Configuración de la base de datos
const db = mysql.createConnection({
    host: process.env.DB_HOST,
    user: process.env.DB_USER,
    password: process.env.DB_PASS,
    database: process.env.DB_NAME
});

db.connect((err) => {
    if (err) {
        throw err;
    }
    console.log('MySQL Connected...');
});

// Configuración de body-parser
app.use(bodyParser.urlencoded({ extended: true }));
app.use(bodyParser.json());

// Configuración de la carpeta pública
app.use(express.static(path.join(__dirname, 'pro/public')));

// Ruta para obtener productos
app.get('/api/products', (req, res) => {
    let sql = 'SELECT * FROM products';
    db.query(sql, (err, results) => {
        if (err) throw err;
        res.json(results);
    });
});

// Ruta para manejar envíos del formulario de contacto
app.post('/contact', (req, res) => {
    const { email, message } = req.body;

    const sql = 'INSERT INTO contact_messages (email, message) VALUES (?, ?)';
    db.query(sql, [email, message], (err, result) => {
        if (err) throw err;
        console.log('Mensaje guardado en la base de datos');

        // Enviar correo de confirmación 
        const transporter = nodemailer.createTransport({
            service: 'gmail',
            auth: {
                user: process.env.EMAIL_USER,
                pass: process.env.EMAIL_PASS
            }
        });

        const mailOptions = {
            from: process.env.EMAIL_USER,
            to: email,
            subject: 'Gracias por contactarnos',
            text: 'Hemos recibido tu mensaje y te responderemos pronto.'
        };

        transporter.sendMail(mailOptions, (error, info) => {
            if (error) {
                console.log(error);
                res.status(500).send('Error al enviar el correo');
            } else {
                console.log('Correo enviado: ' + info.response);
                res.status(200).send('Mensaje recibido y correo enviado');
            }
        });
    });
});

// Iniciar el servidor
app.listen(port, () => {
    console.log(`Server started on port ${port}`);
});
