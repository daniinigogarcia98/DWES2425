//Importar el modelo de usuario
const Usuario = require('../models/usuario');
//Importar bcyrpt
const cifrar = require('bcrypt');
function login(req, res) {
    res.status(200).send('Página de login');
}

function registro(req, res) {
     //Recuperar los datos de la solicitud (req)
     const {nombre, email, password,perfil} = req.body;

     //Validar si vienen todos los datos para el registro
     if(!nombre || !email || !password || !perfil){
         throw{textoError: 'Faltan datos para registrar al usuario'};
     }
     //Comprobar que no hay otro usuario con ese emasil
    res.status(200).send('Página de registro');
}

//Exportar funciones para usarlas fuera de este fichero
module.exports = {
    login,
    registro
}

