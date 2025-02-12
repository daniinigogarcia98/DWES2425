//importar librería de tipo de datos de sequelize
const { DataTypes } = require('sequelize');

//importar configuracion de base de datos
const bd = require('../config/database');

const Usuario = bd.define('Usuarios',{
    id: {
        type: DataTypes.INTEGER,
        autoIncrement: true,
        primaryKey: true
    },
    nombre:{
        type: DataTypes.STRING,
        allowNull: false
    },
    email:{
        type: DataTypes.STRING,
        allowNull: false,
        unique: true //clave alternativa
    },
    password:{
        type: DataTypes.STRING,
        allowNull: false
    },
    perfil:{
        type: DataTypes.ENUM('tienda','ciudadano'),
        allowNull: false
    },
    avatar:{
        type: DataTypes.STRING,
        allowNull: true
    },
},
{
    // tablename: 'usuarios',
    timestamps: false
}
)

module.exports = Usuario;