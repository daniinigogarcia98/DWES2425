//Importar Aplicación app.js
const app = require("./app");

//Cargar dotenv para trabajar con variables .env
const dotenv = require("dotenv");
dotenv.config();
//Obtener puerto de la aplicación
const puerto = process.env.APP_PORT;

//Cargar configuracion de bd
const { bd, Usuario,Oferta } = require("./Models");

//Conectar con la bd
bd.sync({
  force: true, // ¡¡¡ IMPORTANTE !!!  cambiar a false cuando el esquema del db sea definitivo¡¡¡
})
  .then(() => {
    console.log("Conexión con la bd establecida");
    //Lanzar aplicación
    app.listen(puerto, () => {
      console.log("Aplicación lanzada en http://localhost:3000");
    });
  })
  .catch((error) => {
    console.log("Error al conectar con la bd", error);
  });

