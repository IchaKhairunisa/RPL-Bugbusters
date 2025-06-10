const express = require('express');
const mysql = require('mysql');
const bodyParser = require('body-parser');
const cors = require('cors');

const app = express();
const port = 3000;

app.use(cors());
app.use(bodyParser.json());

// Koneksi ke database
const db = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: '', // sesuaikan dengan password MySQL kamu
  database: 'rpl'
});

db.connect(err => {
  if (err) throw err;
  console.log('Terhubung ke database');
});

// Endpoint untuk menambahkan penghuni
app.post('/tambah-penghuni', (req, res) => {
  const { noKamar, nama, noHP, status } = req.body;
  const sql = 'INSERT INTO penghuni (no_kamar, nama, no_hp, status) VALUES (?, ?, ?, ?)';
  db.query(sql, [noKamar, nama, noHP, status], (err, result) => {
    if (err) {
      console.error('Gagal menambahkan:', err);
      return res.status(500).json({ success: false, message: 'Gagal menyimpan data' });
    }
    res.json({ success: true, message: 'Data berhasil ditambahkan' });
  });
});

app.listen(port, () => {
  console.log(`Server berjalan di http://localhost:${port}`);
});
