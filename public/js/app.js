const toggle = document.querySelector('#toggle-menu');
const loginContainer = document.querySelector('.login-container');
const loginButton = document.querySelector('.login-btn');login-close-button
const loginCloseButton = document.querySelector('.login-close-button');
if(toggle){
    toggle.addEventListener('click', function(){
        document.getElementById("navLinks").classList.toggle("active");
    })
}
if(loginButton){
    loginButton.addEventListener('click', function() {
        document.getElementById("loginModal").style.display = "block";
        document.getElementById("navLinks").classList.toggle("active");
    })
}

  if (loginCloseButton) {
    document.getElementById("loginModal").style.display = "none";
  }

  window.onclick = function(event) {
    const modal = document.getElementById("loginModal");
    if (event.target == modal) {
      modal.style.display = "none";
    }
  }

   const loginForm  = document.querySelector('#loginForm')
   if(loginForm){
        loginForm.addEventListener('submit', async function(e) {
            e.preventDefault();

            const form = e.target;
            const formData = new FormData(form);

            const payload = {
            username: formData.get('username'),
            password: formData.get('password'),
            };

            try {
            const response = await fetch('/login', {
                method: 'POST',
                headers: {
                'Content-Type': 'application/json'
                },
                body: JSON.stringify(payload)
            });

            const data = await response.json();

            if (response.ok) {
                alert('Login successful!');
                closeModal();
            } else {
                alert(data.message || 'Login failed!');
            }
            } catch (err) {
            console.error('Fetch error:', err);
            alert('Something went wrong.');
            }
        });
   }