//Importtamos la libreria JWT
const jwt = require('jsonwebtoken');
//Importar dotenv
const dotenv = require('dotenv');
dotenv.config();

//Funcion que crear token
function crearToken(usuario ,caducidad) {
  try {
      //Obtener datos de usario que van en el token
    //Esto es el payload
    const { id,email } = usuario;

    //Crear el payload
    const payload = {
        id,
        email
    };

    //Generar y devolver el token 
    return jwt.sign(payload, process.env.CLAVE_JWT, {
        expiresIn: caducidad
    });
  } catch (error) {
    throw` Error al generar el token: ${error}`;
  }
}
//Funcion verificar token verifica la firma y la caducidad del token
function verificarToken(token) {
    try {
        const datosVerificacion= jwt.verify(token, process.env.CLAVE_JWT);
        return datosVerificacion;
    } catch (error) {
      throw` Error al verificar el token: ${error}`;
    }
}

module.exports={
  crearToken,
  verificarToken
}