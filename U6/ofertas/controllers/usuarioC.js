// Importar el modelo de usuario
const e = require('express');
const usuario = require('../Models/usuario');
// Importar bcrypt
const cifrar = require('bcrypt');
//Importamos gestión del token
const servicioJWT = require('../service/jwt');
//Importar librerias que permiten trabajar con ficheros
const fs = require('fs');
const path = require('path');
const { error } = require('console');

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
                // Crear el token
                const token = servicioJWT.crearToken(us,'24h');
                res.status(200).send({"email": us.email, "nombre": us.nombre, "perfil": us.perfil, "token": token});
               //res.status(200).send({us: us, token: token});
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

async function subirAvatar(req, res) {
    try {
        if (!req.files || !req.files.avatar) {
            return res.status(400).send({ textoError: 'No has proporcionado un fichero' });
        }

        console.log(req.files);

        // Obtener el nombre del fichero para guardarlo en la bd en el usuario
        const rutaF = req.files.avatar.path.split('/');
        // datosUs lo hemos creado en el req al validar el token
        const us = await usuario.findByPk(req.datosUS.id);
        us.avatar = rutaF[1];

        if (us.changed('avatar')) {
            await us.save();
            return res.status(200).send({ mensaje: 'Avatar Actualizado' });
        }

        return res.status(200).send({ mensaje: 'No se han modificado los datos' });
        
    } catch (error) {
        // En caso de error, enviar la respuesta de error
        return res.status(500).send({ textoError: error });
    }

}


async function obtenerAvatar(req, res) {
    try {
          //Comprobrar el usuario existe y tiene avatar
    const us = await usuario.findByPk(req.datosUS.id);
    if(!us || !us.avatar){
        throw 'Usuario no existe o no tiene avatar';
    }
    else{
        const nombreF =`./avatars/${us.avatar}`;
        //Acceder al ficchero para devolverlo
        fs.stat(nombreF,(error,stats)=>{
            if(error){
                throw 'imagen no disponible';
            }
            else{
                res.sendFile(path.resolve(nombreF));
            }
        });
    }
    } catch (error) {
        res.status(500).send({textoError: error});
        
    }
}

// Exportar funciones para usarlas fuera de este fichero
module.exports = {
    login,
    registro,
    subirAvatar,
    obtenerAvatar
};
