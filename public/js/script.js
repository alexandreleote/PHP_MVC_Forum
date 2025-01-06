// Ouvrir le formulaire de création de contenu
document.addEventListener('DOMContentLoaded', () => {
    const btnCreateContent = document.querySelector('#btn-new-content');
    const formContainer = document.querySelector('.contents-form');

    if (btnCreateContent && formContainer) {
        btnCreateContent.addEventListener('click', () => {
            formContainer.classList.add('active');
            console.log('Button clicked, form container toggled');
        });
    } else {
        console.error('Button or form container not found');
        console.log('btnCreateContent:', btnCreateContent);
        console.log('formContainer:', formContainer);
    }
});

// Fermer le formulaire de création de contenu
document.addEventListener('DOMContentLoaded', () => {
    const closeBtn = document.querySelector('.close-btn');
    const formContainer = document.querySelector('.contents-form');

    if (closeBtn && formContainer) {
        closeBtn.addEventListener('click', (event) => {
            event.preventDefault(); // Empêche le rechargement de la page
            formContainer.classList.remove('active');
            console.log('Close button clicked, form container toggled');
        });
    } else {    
        console.error('Close button or form container not found');
        console.log('closeBtn:', closeBtn);
        console.log('formContainer:', formContainer);
    }
});

// Visibilité du mot de passe pour les formulaires de connexion et d'inscription
document.addEventListener('DOMContentLoaded', function() {
    // Fonction générique pour basculer la visibilité du mot de passe
    function setupPasswordToggle(inputId, toggleButtonId, toggleIconId) {
        const passwordInput = document.getElementById(inputId);
        const togglePasswordButton = document.getElementById(toggleButtonId);
        const passwordToggleIcon = document.getElementById(toggleIconId);

        if (passwordInput && togglePasswordButton && passwordToggleIcon) {
            togglePasswordButton.addEventListener('click', function() {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    passwordToggleIcon.classList.replace('fa-eye-slash', 'fa-eye');
                } else {
                    passwordInput.type = 'password';
                    passwordToggleIcon.classList.replace('fa-eye', 'fa-eye-slash');
                }
            });
        }
    }

    // Configuration pour le formulaire de connexion
    setupPasswordToggle('password', 'togglePassword', 'passwordToggleIcon');

    // Configuration pour le formulaire d'inscription
    setupPasswordToggle('pass1', 'togglePassword1', 'passwordToggleIcon1');
    setupPasswordToggle('pass2', 'togglePassword2', 'passwordToggleIcon2');
});

// Confirmer la suppression du compte
document.addEventListener('DOMContentLoaded', () => {
    if (document.querySelector('#delete-user-btn') && document.querySelector('.form-delete-account')) {
        document.querySelector('#delete-user-btn').addEventListener('click', () => {
            document.querySelector('.form-delete-account').classList.add('active');
            console.log('Button clicked, form container toggled');
        });
    } else {
        console.error('Button or form container not found');
        console.log('btnDeleteAccount:', document.querySelector('#delete-user-btn'));
        console.log('formDeleteAccount:', document.querySelector('.form-delete-account'));
    }
});