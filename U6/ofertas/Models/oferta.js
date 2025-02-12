//importar librerias de tipo de datos de sequelize
const { DataTypes } = require("sequelize");

//importar configuracion de base de datos
const bd = require("../config/database");

//definir modelo de oferta
const Oferta = bd.define(
  "Ofertas",
  {
    id: {
      type: DataTypes.INTEGER,
      autoIncrement: true,
      primaryKey: true,
    },
    titulo: {
      type: DataTypes.STRING,
      allowNull: false,
    },
    descripcion: {
      type: DataTypes.STRING,
      allowNull: false,
    },
    usuario_id: {
      type: DataTypes.INTEGER,
      allowNull: false,
      references: {
        model: "Usuarios",
        key: "id",
      },
      onUpdate: "CASCADE",
      onDelete: "RESTRICT",
    },
  },
  {
    // tablename: "ofertas",
    timestamps: false,
  }
);

module.exports = Oferta;
