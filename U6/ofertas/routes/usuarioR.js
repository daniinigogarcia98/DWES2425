// Cargar librería de Express
const express = require('express');

// Inicializar el sistema de rutas
const api = express.Router();

// Importar middleware
const mAuth = require('../middleware/auth');
const multiparty = require('connect-multiparty');  // Aquí cargamos connect-multiparty

// Crear una instancia de multiparty (aquí puedes especificar una ruta para los archivos)
const subirF = multiparty({ uploadDir: './avatars' });

// Importar el controlador donde se definen las funciones asignadas a las rutas
const controlador = require('../controllers/usuarioC');

// Crear rutas
api.post('/login', controlador.login);
api.post('/registro', controlador.registro);
api.put('/avatar', [mAuth.comprobarAuth, subirF], controlador.subirAvatar);  // Usamos el middleware aquí
api.get('/avatar', [mAuth.comprobarAuth], controlador.obtenerAvatar);

// Exportar las rutas de este fichero
module.exports = api;
