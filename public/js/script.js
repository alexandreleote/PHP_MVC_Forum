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