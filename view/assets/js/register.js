// On récupère tous les champs
let lastNameInput = document.getElementById("last_name")
let firstNameInput = document.getElementById("first_name")
let emailAddressInput = document.getElementById("email_address")
let passwordInput = document.getElementById("password");
let streetNameInput = document.getElementById("street_name");
let cityInput = document.getElementById("city")
let zipCodeInput = document.getElementById("zip_code")
let districtInput = document.getElementById("district")
let mobileNumberInput = document.getElementById("mobile_number")

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

// On ajoute pour tous un écouteur à chaque saisie d'une lettre
lastNameInput.addEventListener("keyup", function() {
    if (lastNameInput.value.length !== 0) {
        setSuccess(this)
    } else {
        setError(this)
    }
})

firstNameInput.addEventListener("keyup", function() {
    if (firstNameInput.value.length !== 0) {
        setSuccess(this)
    } else {
        setError(this)
    }
})

// Pour le champ de l'email, on valide si le format est respecté
emailAddressInput.addEventListener("keyup", function() {
    // On prépare le format souhaité pour l'adresse-email
    let emailRegex = new RegExp("^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\\.[a-zA-Z0-9-]+)*$")

    // On vérifie que le champ ne soit pas vide
    if (emailAddressInput.value.length !== 0) {
        // S'il n'est pas vide, alors on peut vérifier qu'il soit au bon format
        if(emailRegex.test(emailAddressInput.value)) {
            setSuccess(this)
        } else {
            setError(this)
        }
    } else {
        setError(this)
    }
})

passwordInput.addEventListener("keyup", function() {
    // On prépare le format souhaité pour l'adresse-email
    let passwordRegex = new RegExp("[a-zA-Z][0-9]")

    // On vérifie que le champ ne soit pas vide
    if (this.value.length >= 8) {
        // S'il n'est pas vide, alors on peut vérifier qu'il soit au bon format
        if(passwordRegex.test(this.value)) {
            setSuccess(this)
        } else {
            setError(this)
        }
    } else {
        setError(this)
    }
})

streetNameInput.addEventListener("keyup", function() {
    if (streetNameInput.value.length !== 0) {
        setSuccess(this)
    } else {
        setError(this)
    }
})

cityInput.addEventListener("keyup", function() {
    if (cityInput.value.length !== 0) {
        setSuccess(this)
    } else {
        setError(this)
    }
})

zipCodeInput.addEventListener("keyup", function() {
    if (zipCodeInput.value.length === 5) {
        setSuccess(this)
    } else {
        setError(this)
    }
})

districtInput.addEventListener("keyup", function() {
    if (districtInput.value.length !== 0) {
        setSuccess(this)
    } else {
        setError(this)
    }
})

mobileNumberInput.addEventListener("keyup", function() {
    // On vérifie que la valeur commence par un zéro
    let mobileNumberRegex = new RegExp("^0")

    if (this.value.length === 10) {
        if(mobileNumberRegex.test(mobileNumberInput.value)) {
            setSuccess(this)
        } else {
            setError(this)
        }
    } else {
        setError(this)
    }
})