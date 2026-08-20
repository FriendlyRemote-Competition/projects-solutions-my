const year = document.querySelector('.year')
const emailError = document.querySelector('.email-error')
const emailInput = document.getElementById('email-input')
const emailSubmit = document.querySelector('.email-submit')

year.innerHTML = new Date().getFullYear()

emailSubmit.addEventListener('click', e => {
    let value = emailInput.value
    if(value.trim() === "")return showError("Please enter your email address.")

    if(!value.includes('@'))return showError("Please enter a valid email address.")

    showSuccess("Thank you. Shanghai stories are on their way.")
})
const showError = message => {
    emailError.style.display = 'block'
    emailError.style.color = 'red'
    emailError.innerHTML = message
}
const showSuccess = message => {
    emailError.style.display = 'block'
    emailError.style.color = 'green'
    emailError.innerHTML = message
}