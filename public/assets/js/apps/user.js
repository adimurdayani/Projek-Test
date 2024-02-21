const User = {
  showPassword() {
    const checkboxShowPassword = document.querySelector("#checkboxShowPassword");
    const input = document.querySelector(`[name="password"]`);

    if (checkboxShowPassword.checked) {
      input.setAttribute("type", "text")
    } else {
      input.setAttribute("type", "password")
    }
  },
};
