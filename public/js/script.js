document.addEventListener('DOMContentLoaded', () => {
    const btnCreateTopic = document.getElementById('btn-create-topic');
    const formContainer = document.querySelector('.topics-container .form-container');

    if (btnCreateTopic && formContainer) {
        btnCreateTopic.addEventListener('click', () => {
            formContainer.classList.toggle('active');
            console.log('Button clicked, form container toggled');
        });
    } else {
        console.error('Button or form container not found');
    }
});