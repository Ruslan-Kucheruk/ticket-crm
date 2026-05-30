<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Feedback widget</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
</head>

<body class="bg-transparent p-3">
    <main>
        <div class="container" style="max-width: 600px">
            <h2 class="mb-4">Send your request</h2>
            <div class="alert d-none" id="response-message" role="alert"></div>   
            <form id="ticket-form" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="name_id" class="form-label">Your name</label>
                    <input type="text" name="name" class="form-control" id="name_id" placeholder="Your name">
                </div>
                <div class="mb-3">
                    <label for="phone_id" class="form-label">Your phone number</label>
                    <input type="tel" name="phone" class="form-control" id="phone_id" placeholder="+380507301111">
                </div>
                <div class="mb-3">
                    <label for="subject_id" class="form-label">Subject</label>
                    <input type="text" name="subject" class="form-control" id="subject_id" placeholder="Subject">
                </div>
                <div class="mb-3">
                    <label for="email_id" class="form-label">Email address</label>
                    <input type="email" name="email" class="form-control" id="email_id" placeholder="name@example.com">
                </div>
                <div class="mb-3">
                    <label for="textarea_id" class="form-label">Message</label>
                    <textarea class="form-control" name="message" id="textarea_id" rows="3"></textarea>
                </div>
                <div class="mb-3">
                    <label for="form_id" class="form-label">Attachments</label>
                    <input type="file"  class="form-control" name="files[]" accept=".jpg,.jpeg,.png,.pdf" id="form_id" multiple>
                </div>
                <button type="submit" id="submit-button" class="btn btn-primary w-100">Submit</button>
            </form>
        </div> 
    </main>
    <script src="{{ asset('js/ticket-form.js') }}"></script>
</body>

</html>
