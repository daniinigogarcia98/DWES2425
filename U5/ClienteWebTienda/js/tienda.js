function login(){
  const url = 'http://localhost/DWES2425/U5/APITienda/public/api/login';
  const datos = {
    email: document.getElementById('email').value,
    ps: document.getElementById('ps').value
  }
  axios.post(url, datos)
  .then(response =>{
    const token = response.data.token;
    const us = response.data.nombreUS;
    localStorage.setItem('token',token);
    localStorage.setItem('us',us);
    window.location.href="tienda.html";
    if (response.data.status==200){
        alert('Login Correcto');
    }
  })
  .catch(error =>{
    if (error.response.status==401){
      alert('Login incorrecto');
    }

  });
}