// Importar el modelo de usuario
const e = require('express');
const usuario = require('../Models/usuario');
// Importar bcrypt
const cifrar = require('bcrypt');

async function login(req, res) {
    try {
        // Recuperar los datos
        const { email, password } = req.body;
        if (!email || !password) {
            throw 'Falta email o ps';
        }
        //Recuperar el us por email
        const us = await usuario.findOne({ where: { email } });
        if (!us) {
            throw 'Usuario incorrecto';
        }
        else {
            // Comprobar con bcrypt si la contraseña es correcta
            if (await cifrar.compare(password, us.password)) {
                res.status(200).send({"email": us.email, "nombre": us.nombre, "perfil": us.perfil});
               //res.status(200).send(us);
            }
            else {
                throw 'usuario incorrecto';
            }
        }
    }
    catch (error) {
        res.status(500).send({textoError: error});
    }
}

async function registro(req, res) {
    try {
        // Recuperar los datos de la solicitud (req)
        const { nombre, email, password, perfil } = req.body;

        // Validar si vienen todos los datos para el registro
        if (!nombre || !email || !password || !perfil) {
            return res.status(400).send({ textoError: 'Faltan datos para registrar al usuario' });
        }

        // Comprobar que no hay otro usuario con ese email
        const u = await usuario.findOne({ where: { email: email } });
        if (u) {
            return res.status(400).send({ textoError: 'Ya existe un usuario con ese email' });
        }

        // Cifrar el password
        const hashPs = await cifrar.hash(password, 10);

        // Crear el usuario
        const us = await usuario.create({ nombre, email, password: hashPs, perfil });

        // Devolver el usuario creado
        res.status(201).send({ mensaje: 'Usuario registrado con éxito', usuario: us });
    } catch (error) {
        // Enviar un mensaje de error al cliente
        res.status(500).send({ textoError: error.message || 'Error en el servidor' });
    }
}

// Exportar funciones para usarlas fuera de este fichero
module.exports = {
    login,
    registro
};
