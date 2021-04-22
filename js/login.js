const appHeight = () => {
    const t = document.documentElement;
    t.style.setProperty("--app-height", `${window.innerHeight}px`)
};
window.addEventListener("resize", appHeight), appHeight();

const url = "../move-out/includes/login.php"

const frontendModel = {
    chooseUser() {
        elements.users.forEach(user => user.classList.add("hide"))
        this.classList.add("active")
        elements.close.classList.remove("hide")
        elements.input.addEventListener('keypress', (e) => {
            if (e.key === 'Enter')  backendModel.login()
        });
    },
    closeUser() {
        elements.users.forEach(user => user.classList.remove("hide", "active"))
        elements.pwdfield.value = ""
        this.classList.add("hide")
    },
    errorLogin() {
        elements.pwdfield.classList.add("error")
    },
    resetInputField(){
        elements.pwdfield.classList.remove("error")
    }
}

const backendModel = {
    login(){
        let name = document.querySelector(".user.active").dataset.name
        let pswd = document.querySelector("input").value
        fetch(url, {
            method: "post",
            body: JSON.stringify({
                function: "login",
                username: name,
                password: pswd
            })
        }).then((response) => response.json())
        .then((data) => (data == true) ? location.reload() : console.log(data) )
    }
}

const elements = {
    users: document.querySelectorAll(".user"),
    input: document.querySelector("button"),
    pwdfield: document.querySelector(".pwd"),
    close: document.querySelector("#close")
}

elements.users.forEach(user => user.addEventListener("click", frontendModel.chooseUser))
elements.input.addEventListener("click", backendModel.login)
elements.close.addEventListener("click", frontendModel.closeUser)
elements.pwdfield.addEventListener("focus", frontendModel.resetInputField)