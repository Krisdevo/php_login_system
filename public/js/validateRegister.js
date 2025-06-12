// validateRegister.js
document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('register-form');
  const message = document.getElementById('message');

  //Si il n'y as pas de formulaire
  if (!form) return;

  // système de validation
  const validate = (data) => {
    // instancie une promesse 
    return new Promise((resolve, reject) => {
      // if le nom d'utilisateur est plus grand que 20 characteres
      if (data.username.length > 20) {
        return reject("Le pseudo est trop long (max 20 caractères)");
      }
      // si le mot de passe ne comporte pas de charactères spéciaux 
      console.log(data.password);
      const specialCharRegex = /[!@#$%^&*(),.?":{}|<>]/;
      if (!specialCharRegex.test(data.password)) {
        return reject("Le mot de passe doit contenir au moins un caractère spécial");
      }
      // si le mot de passe est plus petit de 6 charactères
      if (data.password.length < 6) {
        return reject("Le mot de passe est trop court");
      }
      // Si aucune non-validation est déclencher alors retourne une réponse resolve
      resolve(data);
    });
  };

  const sendData = (data) => {
    return fetch('process_register.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      body: new URLSearchParams(data)
    })
    .then(res => res.text());
  };

  form.addEventListener('submit', function (e) {
    // prevenir du double clique
    e.preventDefault();

    // remplir la data avec les clés du formulaire pour la validation
    const data = {
      username: form.username.value.trim(),
      email: form.email.value.trim(),
      password: form.password.value.trim()
    };

    // vide le container message d'info
    message.textContent = "";
    message.className = "";

    // on vérifie la data 
    validate(data)
      // si la promesse nous revient en resolve
      .then(validData => 
        // envoie la data a la page concerné 
        sendData(validData))
      // envoie la reponse a la page actuelle 
      .then(response => {
        message.textContent = response;
        message.className = "success";
      })
      // affiche l'erreur technique 
      .catch(err => {
        message.textContent = err;
        message.className = "error";
      });
  });
});
