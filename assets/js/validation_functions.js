const inputFieldValidation = (elementId, elementRegex, elementErrorId,
    elementErrorMessage, errorArray) => {
    if(!elementRegex.test(elementId)){
        createValidationErrorMessage(elementErrorId, elementErrorMessage)
        errorArray.push(elementErrorMessage)
    }else{
        removeValidationErrorMessage(elementErrorId)
    }
}