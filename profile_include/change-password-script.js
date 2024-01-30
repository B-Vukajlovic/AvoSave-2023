document.getElementById('passwordForm').onsubmit = function() {
    const newPass = this.new_password.value;
    const repeatPass = this.repeat_password.value;

    if(newPass !== repeatPass) {
        document.getElementById('message').textContent = 'New password and repeat password do not match.';
        return false;
    }

    return true;
}