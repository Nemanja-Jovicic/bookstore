const authRegisterFormValidation = (objData) => {
    const {first_name, last_name, email, password}  = objData

    const regFirstLastName = /\b([A-ZÀ-ÿ][-,a-z. ']+[ ]*)+/
    const regEmail = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/
    const regPassword = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/

    const errorArray = []

    inputFieldValidation(first_name, regFirstLastName, "first_name_error","Ime nije u redu", errorArray)
    inputFieldValidation(last_name, regFirstLastName, "last_name_error","Prezime nije u redu", errorArray)
    inputFieldValidation(email, regEmail, "email_error","Email nije u redu", errorArray)
    inputFieldValidation(password, regPassword, "password_error","Lozinka nije u redu", errorArray)

    return errorArray;
}

const authLoginFormValidation = (objData) => {
    const {email, password} = objData
    const regEmail = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/
    const regPassword = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/

    const errorArray = []

    inputFieldValidation(email, regEmail, "email_error","Email nije u redu", errorArray)
    inputFieldValidation(password, regPassword, "password_error","Lozinka nije u redu", errorArray)

    return errorArray;

}