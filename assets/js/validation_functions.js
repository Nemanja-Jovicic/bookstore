const inputFieldValidation = (elementId, elementRegex, elementErrorId,
    elementErrorMessage, errorArray) => {
    if(!elementRegex.test(elementId)){
        createValidationErrorMessage(elementErrorId, elementErrorMessage)
        errorArray.push(elementErrorMessage)
    }else{
        removeValidationErrorMessage(elementErrorId)
    }
}
const selectFieldValidation = (elementId, errorElementId, errorMessage, errorArray) => {
    if(parseInt(elementId) === 0){
        createValidationErrorMessage(errorElementId, errorMessage)
        errorArray.push(errorMessage)
    }else{
        removeValidationErrorMessage(errorElementId)
    }
}
const checkBoxFieldValidation = (elementArray, errorElementId, errorMessage, errorArray) => {
    if(elementArray.length === 0){
        createValidationErrorMessage(errorElementId, errorMessage)
        errorArray.push(errorMessage)
    }else{
        removeValidationErrorMessage(errorElementId)
    }
}
const inputFileFieldValidation = (file, errorElementId, errorMessages, errorArray) => {
    const [emptyMessage, typeMessage, sizeMessage] = errorMessages
    if(file.length === 0){
        createValidationErrorMessage(errorElementId, emptyMessage)
        errorArray.push(emptyMessage)
    }else{
        console.log(file)
        file = file[0]

        const fileSize = file['size']
        const fileType = file['type'];

        const validFormats = ['image/png', 'image/jpeg', 'image/jpg'] 

        if(!validFormats.includes(fileType)){
            errorArray.push(typeMessage)
            createValidationErrorMessage(errorElementId, typeMessage)
        }else if(fileSize > 3 * 1024 * 1024){
            errorArray.push(sizeMessage)
            createValidationErrorMessage(errorElementId, sizeMessage)
        }else{
            removeValidationErrorMessage(errorElementId)
        }
    }
}