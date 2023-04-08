function confirmDelete() {
    return confirm('Are you sure you want to delete this?');
}

function comparePasswords() {
    const pw1 = document.getElementById('password').value;
    const pw2 = document.getElementById('confirm').value;
    const pwMsg = document.getElementById('pwMsg');

    if (pw1 != pw2) {
        pwMsg.innerText = 'Passwords do not match';
        return false; // this prevents the form submission
    }
    else {
        pwMsg.innerText = '';
        return true;
    }
}