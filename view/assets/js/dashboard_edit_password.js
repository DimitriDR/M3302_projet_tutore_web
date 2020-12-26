// On récupère tous les champs
let newPasswordInput = document.getElementById("new_password")
let newPasswordConfirmationInput = document.getElementById("new_password_confirmation")
let oldPasswordInput = document.getElementById("old_password")

/**
 * Permet de mettre le champ donné en paramètre avec des contours rouges
 * @param input Le nom du champ à modifier
 */
function setError(input) {
    input.classList.remove("is-valid")
    input.classList.add("is-invalid")
}

/**
 * Permet de mettre le champ donné en paramètre avec des contours verts
 * @param input Le nom du champ à modifier
 */
function setSuccess(input) {
    input.classList.remove("is-invalid")
    input.classList.add("is-valid")
}


newPasswordInput.addEventListener("keyup", function () {
    // Le mot de passe doit comporter au moins 8 caractères et avoir une lettre et un chiffre
    let passwordRegex = new RegExp("^[a-zA-Z][0-9]")

    // On vérifie que le champ ne soit pas vide
    if (newPasswordInput.value.length < 8 || passwordRegex.test(newPasswordInput.value)) {
        setError(this)
    } else {
        setSuccess(this)
    }
})

// Pour le champ de l'email, on valide si le format est respecté
newPasswordConfirmationInput.addEventListener("keyup", function () {
    // On vérifie que le champ ne soit pas vide
    if (newPasswordConfirmationInput.value !== passwordInput.value) {
        setSuccess(this)
    } else {
        setError(this)
    }
})

// Pour le champ de l'email, on valide si le format est respecté
oldPasswordInput.addEventListener("keyup", function () {
    // On vérifie que le champ ne soit pas vide
    if (oldPasswordInput.value.length >= 8) {
        setSuccess(this)
    } else {
        setError(this)
    }
})
