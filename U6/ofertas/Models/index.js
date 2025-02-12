//importar sequelize
const { Sequelize } = require('sequelize');


//importar configuracion de base de datos
const bd = require('../config/database');


//importar modelos de usuario
const Usuario = require('./usuario');
//importar modelos de oferta
const Oferta = require('./oferta');

//Definir relaciones
//Un usuario (tienda) puede tener 0 muchas ofertas creadas
Usuario.hasMany(Oferta , { foreignKey: 'usuario_id'});
//Una oferta es de un usuario
Oferta.belongsTo(Usuario, { foreignKey: 'usuario_id'});
//Exportar conexion modelos y relaciones
module.exports = {
    bd,
    Usuario,
    Oferta
}