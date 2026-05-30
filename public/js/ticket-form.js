document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('ticket-form');
    const responseMessage = document.getElementById('response-message');
    const submitButton = document.getElementById('submit-button');

    form.addEventListener('submit', async function (event) {
        event.preventDefault();
        responseMessage.className = 'alert d-none';
        responseMessage.innerHTML = '';

        submitButton.disabled = true;
        submitButton.textContent = 'Sending...';

        const formData = new FormData(form);

        try {
            const response = await fetch('/api/tickets', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                },
                body: formData,
            });

            const data = await response.json();

            if (!response.ok) {
                responseMessage.className = 'alert alert-danger';

                if (data.errors) {
                    responseMessage.innerHTML = Object.values(data.errors)
                        .flat()
                        .join('<br>');
                } else {
                    responseMessage.textContent = data.message || 'Validation error';
                }
                return;
            }

            responseMessage.className = 'alert alert-success';
            responseMessage.textContent = 'Your request has been sent successfully';

            form.reset();

        } catch (error) {
            responseMessage.className = 'alert alert-danger';
            responseMessage.textContent = 'Server Error. Please try again later';
        } finally {
            submitButton.disabled = false;
            submitButton.textContent = 'Submit';
        }
    });
});