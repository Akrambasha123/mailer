<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Emails</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <h1>Send Resume</h1>
    <form id="emailForm" enctype="multipart/form-data">
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

        <button type="button" class="btn btn-primary" onclick="sendEmail()">Send Email</button>
    </form>
</div>

<script>
    let emails = [];

    document.getElementById("emails").addEventListener("keydown", function(event) {
        if (event.key === "Enter") {
            event.preventDefault();
            const email = event.target.value.trim();
            if (email && !emails.includes(email)) {
                emails.push(email);
                displayEmails();
                event.target.value = '';
            }
        }
    });

    function displayEmails() {
        const emailList = document.getElementById("email-list");
        emailList.innerHTML = emails.map((email, index) =>
            `<span class="badge bg-primary mx-1">${email} <a href="#" onclick="removeEmail(${index})">&times;</a></span>`
        ).join('');
    }

    function removeEmail(index) {
        emails.splice(index, 1);
        displayEmails();
    }

    function sendEmail() {
        const formData = new FormData(document.getElementById("emailForm"));
        formData.append("emails", emails.join(","));

        fetch("send_email.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.text())
        .then(data => alert(data))
        .catch(error => console.error("Error:", error));
    }
</script>

</body>
</html>
