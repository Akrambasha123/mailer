<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Emails</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .pill {
            display: inline-block;
            padding: 5px 10px;
            background-color: #007bff;
            color: white;
            border-radius: 25px;
            margin-right: 5px;
            margin-bottom: 5px;
        }
        .pill .remove {
            margin-left: 8px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Send Resume</h1>
    <form action="send_email.php" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="subject" class="form-label">Subject:</label>
            <input type="text" class="form-control" id="subject" name="subject" required>
        </div>
        <div class="mb-3">
            <label for="resume" class="form-label">Upload Resume:</label>
            <input type="file" class="form-control" id="resume" name="resume" required>
        </div>
        <div class="mb-3">
            <label for="emails" class="form-label">Enter Emails (press Enter to add or paste multiple):</label>
            <input type="text" class="form-control" id="emails" placeholder="Enter email(s)">
            <div id="email-list"></div>
        </div>

        <input type="hidden" name="emails_hidden" id="emails_hidden">

        <button type="submit" class="btn btn-primary">Send Email</button>
    </form>
</div>

<script>
    const emailInput = document.getElementById('emails');
    const emailList = document.getElementById('email-list');
    const emailsHidden = document.getElementById('emails_hidden');

    let emails = [];

    // Function to handle pasting multiple emails
    emailInput.addEventListener('paste', function (event) {
        setTimeout(() => {
            const pastedData = emailInput.value;
            processEmails(pastedData);
        }, 100); // Small delay to ensure pasted content is captured
    });

    emailInput.addEventListener('keydown', function (event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            const inputValue = emailInput.value.trim();
            if (inputValue) {
                processEmails(inputValue);
                emailInput.value = '';
            }
        }
    });

    function processEmails(input) {
        // Split input by commas or newlines and filter out empty values
        const newEmails = input.split(/[\s,;]+/).filter(email => email);
        newEmails.forEach(email => {
            if (!emails.includes(email)) {
                emails.push(email);
            }
        });
        updateHiddenField();
        displayEmails();
    }

    function addEmail(email) {
        if (!emails.includes(email)) {
            emails.push(email);
            updateHiddenField();
            displayEmails();
        }
    }

    function removeEmail(index) {
        emails.splice(index, 1);
        updateHiddenField();
        displayEmails();
    }

    function updateHiddenField() {
        emailsHidden.value = emails.join(',');
    }

    function displayEmails() {
        emailList.innerHTML = '';
        emails.forEach((email, index) => {
            const pill = document.createElement('span');
            pill.className = 'pill';
            pill.innerHTML = email + ' <span class="remove" onclick="removeEmail(' + index + ')">&times;</span>';
            emailList.appendChild(pill);
        });
    }
</script>

</body>
</html>
