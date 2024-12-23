<body class="login-page no-navbar no-footer">
    <a href="index.php" class="back-action"><i class="fa-solid fa-chevron-left"></i> Retour</a>
    
    <section class="container-login">
        <article class="container-form-login">
            <h2>Se connecter</h2>
            <form action="index.php?ctrl=security&action=login" method="post">
                
                <div class="form-header">
                    <input type="email" name="email" id="email" placeholder="Identifiant" required>

                    <input type="password" name="password" id="password" placeholder="Mot de passe" required>
                    <p><a href="index.php?ctrl=security&action=forgotPassword">Mot de passe oublié ?</a></p>
                </div>
                
                <div class="remember">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember">Se souvenir de moi</label><br>
                </div>
                
                <div class="confirm">
                    <button type="submit" name="submit" class="btn-login">Se connecter</button>
                </div>
            </form>

            <div class="register-link">
                <p>Pas encore inscrit ?</p>
                <p><a href="index.php?ctrl=security&action=register">Créer un compte</a></p>
            </div>

        </article>
    </section>
</body>