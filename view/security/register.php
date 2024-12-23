
<body class="register-page no-navbar no-footer">
    <a href="index.php" class="back-action"><i class="fa-solid fa-chevron-left"></i> Retour</a>
    
    <section class="container-register">
        <article class="container-form-register">
            <h2>S'inscrire</h2>
            <form action="index.php?ctrl=security&action=register" method="post">
                
                <div class ="form-header">
                    <input type="text" name="nickName" id="nickName" placeholder="Pseudonyme" required>

                    <input type="email" name="email" id="email" placeholder="Email" required>

                    <input type="password" name="pass1" id="pass1" placeholder="Mot de passe" required>
                    
                    <input type="password" name="pass2" id="pass2" placeholder="Confirmer le mot de passe" required>
                </div>

                <div class="accept-terms">
                    <input type="checkbox" name="accept-terms" id="accept-terms" required>
                    <label for="accept-terms">
                        J’ai lu et j’accepte les <a href="#">Conditions d’utilisation</a> et la <a href="#">Politique de confidentialité</a> 
                        ainsi que j’ai été informé(e) de mon droit à l’information
                    </label>
                </div>

                <div class="confirm">
                    <button type="submit" name="submit" class="btn-register">S'inscrire</button>
                </div>

                <div class="login-link">
                    <p>Déjà inscrit ?</p>
                    <p><a href="index.php?ctrl=security&action=login">Se connecter</a></p>
                </div>
            </form>
        </article>
    </section>
</body>

