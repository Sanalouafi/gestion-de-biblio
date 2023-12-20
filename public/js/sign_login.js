const linksign = document.getElementById("link-sign");
const loginsign = document.getElementById("link-login");
const loginForm = document.querySelector(".login-section");
const signForm = document.querySelector(".sign-section");

let isForm1Visible = false;
let isForm2Visible = false;

linksign.addEventListener("click", function () {
  loginsign.classList.remove("activelink");
  linksign.classList.add("activelink");

  loginForm.classList.remove("activeForm");
  loginForm.classList.add("desactiveForm");
  signForm.classList.remove("desactiveForm");
  signForm.classList.add("activeForm");
});

loginsign.addEventListener("click", function () {
  linksign.classList.remove("activelink");
  loginsign.classList.add("activelink");

  signForm.classList.remove("activeForm");
  signForm.classList.add("desactiveForm");

  loginForm.classList.remove("desactiveForm");
  loginForm.classList.add("activeForm");
});

const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
const passwordRegex = /^[A-Za-z0-9!@#$%^&*()_+{}\[\]:;<>,.?~\\-]+$/;
//login validation
const logForm = document.querySelector(".login-section");
const emailInput = document.getElementById("log-email");
const passwordInput = document.getElementById("log-pswd");

logForm.addEventListener("keyup", function () {
  validateEmail(emailInput, emailRegex);
  validatePassword(passwordInput, passwordRegex);
});

////sign_up form

const signupForm = document.querySelector(".sign-section");
const emailInput2 = document.getElementById("sign-email");
const passwordInput2 = document.getElementById("sign-pswd");
const c_passwordInput2 = document.getElementById("c-sign-pswd");

signupForm.addEventListener("keyup", function () {
  validateEmail(emailInput2, emailRegex);
  validatePassword(passwordInput2, passwordRegex);
  comparePasswords(passwordInput2, c_passwordInput2);
});

function validateEmail(input, regex) {
  const value = input.value.trim();
  if (regex.test(value)) {
    input.nextElementSibling.style.display = "none";
  } else {
    input.nextElementSibling.style.display = "block";
  }
}

function validatePassword(input, regex) {
  const value = input.value.trim();
  if (regex.test(value)) {
    input.nextElementSibling.style.display = "none";
  } else {
    input.nextElementSibling.style.display = "block";
  }
}

function comparePasswords(passwordInput, confirmPasswordInput) {
  const password = passwordInput.value.trim();
  const confirmPassword = confirmPasswordInput.value.trim();

  if (password === confirmPassword) {
    confirmPasswordInput.nextElementSibling.style.display = "none";
  } else {
    confirmPasswordInput.nextElementSibling.style.display = "block";
  }
}
