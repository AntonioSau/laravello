<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App Birre</title>
    <style>
        /* Stili generali */
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, sans-serif; background-color: #f3f4f6; display: flex; justify-content: center; align-items: center; height: 100vh; }

        /* Contenitore principale */
        .container {
            width: 100%;
            max-width: 400px;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        /* Stili per il titolo */
        h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333333;
        }

        /* Stili per gli input */
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        /* Stili per il bottone */
        .button {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .button:hover {
            background-color: #45a049;
        }

        /* Stili per la sezione delle birre */
        #brewery-list {
            list-style: none;
            margin-top: 20px;
        }

        /* Mostra/Nascondi sezioni */
        #login-section, #brewery-section { display: none; }
    </style>
</head>
<body>

    <!-- Sezione di Login -->
    <div class="container" id="login-section">
        <h2>Login</h2>
        <input type="text" id="email" placeholder="Email" required>
        <input type="password" id="password" placeholder="Password" required>
        <button class="button" onclick="login()">Login</button>
    </div>

    <!-- Sezione Lista di Birre -->
    <div class="container" id="brewery-section">
        <h2>Lista di Birre</h2>
        <ul id="brewery-list"></ul>
        <br/><br/>
        <button class="button" onclick="logout()">Logout</button>
    </div>

    <script>
        const API_URL = 'http://localhost/api'; // Assumi che l'API Laravel sia disponibile a questo URL
        let token = localStorage.getItem('token');

        // Funzione per mostrare la sezione appropriata
        function showSection() {
            if (token) {
                document.getElementById('login-section').style.display = 'none';
                document.getElementById('brewery-section').style.display = 'block';
                fetchBreweries();
            } else {
                document.getElementById('login-section').style.display = 'block';
                document.getElementById('brewery-section').style.display = 'none';
            }
        }

        // Funzione per gestire il login
        async function login() {
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            try {
                const response = await fetch(`${API_URL}/login`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ email, password })
                });
                const data = await response.json();

                if (response.ok) {
                    token = data.token;
                    localStorage.setItem('token', token);
                    showSection();
                } else {
                    alert('Login fallito: ' + data.message);
                }
            } catch (error) {
                console.error('Errore durante il login:', error);
            }
        }

        // Funzione per gestire il logout
        function logout() {
            token = null;
            localStorage.removeItem('token');
            showSection();
        }

        // Funzione per recuperare e visualizzare la lista delle birre
        async function fetchBreweries() {
            try {
                const response = await fetch(`${API_URL}/breweries`, {
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                });
                const breweries = await response.json();

                if (response.ok) {
                    const listElement = document.getElementById('brewery-list');
                    listElement.innerHTML = ''; // Svuota la lista precedente

                    breweries.forEach(brewery => {
                        const li = document.createElement('li');
                        li.textContent = `${brewery.name} - ${brewery.city}`;
                        listElement.appendChild(li);
                    });
                } else {
                    alert('Errore nel recupero delle birre');
                }
            } catch (error) {
                console.error('Errore durante il recupero delle birre:', error);
            }
        }

        // Mostra la sezione appropriata al caricamento della pagina
        showSection();

    </script>
</body>
</html>
