document.getElementById('passwordForm').onsubmit = function() {
    const newPass = this.newPassword.value;
    const repeatPass = this.repeatPassword.value;

    if(newPass !== repeatPass) {
        document.getElementById('message').textContent = 'New password and repeat password do not match.';
        return false;
    }

    return true;
}