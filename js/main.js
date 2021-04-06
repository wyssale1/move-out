!function(e,t){"use strict";var n=null,a="ontouchstart"in e||navigator.MaxTouchPoints>0||navigator.msMaxTouchPoints>0,i=a?"touchstart":"mousedown",o=a?"touchend":"mouseup",m=a?"touchmove":"mousemove",r=0,u=0,s=10,c=10;function l(e){var n;d(),n=e,e=a&&n.touches&&n.touches[0]?n.touches[0]:n,this.dispatchEvent(new CustomEvent("long-press",{bubbles:!0,cancelable:!0,detail:{clientX:e.clientX,clientY:e.clientY},clientX:e.clientX,clientY:e.clientY,offsetX:e.offsetX,offsetY:e.offsetY,pageX:e.pageX,pageY:e.pageY,screenX:e.screenX,screenY:e.screenY}))||t.addEventListener("click",function e(n){t.removeEventListener("click",e,!0),function(e){e.stopImmediatePropagation(),e.preventDefault(),e.stopPropagation()}(n)},!0)}function v(a){d(a);var i=a.target,o=parseInt(function(e,n,a){for(;e&&e!==t.documentElement;){var i=e.getAttribute(n);if(i)return i;e=e.parentNode}return a}(i,"data-long-press-delay","800"),10);n=function(t,n){if(!(e.requestAnimationFrame||e.webkitRequestAnimationFrame||e.mozRequestAnimationFrame&&e.mozCancelRequestAnimationFrame||e.oRequestAnimationFrame||e.msRequestAnimationFrame))return e.setTimeout(t,n);var a=(new Date).getTime(),i={},o=function(){(new Date).getTime()-a>=n?t.call():i.value=requestAnimFrame(o)};return i.value=requestAnimFrame(o),i}(l.bind(i,a),o)}function d(t){var a;(a=n)&&(e.cancelAnimationFrame?e.cancelAnimationFrame(a.value):e.webkitCancelAnimationFrame?e.webkitCancelAnimationFrame(a.value):e.webkitCancelRequestAnimationFrame?e.webkitCancelRequestAnimationFrame(a.value):e.mozCancelRequestAnimationFrame?e.mozCancelRequestAnimationFrame(a.value):e.oCancelRequestAnimationFrame?e.oCancelRequestAnimationFrame(a.value):e.msCancelRequestAnimationFrame?e.msCancelRequestAnimationFrame(a.value):clearTimeout(a)),n=null}"function"!=typeof e.CustomEvent&&(e.CustomEvent=function(e,n){n=n||{bubbles:!1,cancelable:!1,detail:void 0};var a=t.createEvent("CustomEvent");return a.initCustomEvent(e,n.bubbles,n.cancelable,n.detail),a},e.CustomEvent.prototype=e.Event.prototype),e.requestAnimFrame=e.requestAnimationFrame||e.webkitRequestAnimationFrame||e.mozRequestAnimationFrame||e.oRequestAnimationFrame||e.msRequestAnimationFrame||function(t){e.setTimeout(t,1e3/60)},t.addEventListener(o,d,!0),t.addEventListener(m,function(e){var t=Math.abs(r-e.clientX),n=Math.abs(u-e.clientY);(t>=s||n>=c)&&d()},!0),t.addEventListener("wheel",d,!0),t.addEventListener("scroll",d,!0),t.addEventListener(i,function(e){r=e.clientX,u=e.clientY,v(e)},!0)}(window,document);
const appHeight = () => {
    const t = document.documentElement;
    t.style.setProperty("--app-height", `${window.innerHeight}px`)
};
window.addEventListener("resize", appHeight), appHeight();

const categories = ["", "Küche", "Wohnzimmer", "Schlafzimmer", "Arbeitszimmer", "Bad", "Terrasse"]
const url = "../includes/getData.php"

const generalModel = {
    generatePage(page) {
        console.log(page)
        this.resetPage()
        if (page.match("categories")) { 
            this.generateOverview()
        } else if(page == "costs") { 
            this.generateCosts()
        }
    },
    resetPage() {
        elements.main.remove()
    },
    generateOverview() {
        this.generatePageTitle("Kategorie auswählen")
    },
    generateCosts() {
        this.generatePageTitle("Kosten")
    },
    generatePageTitle(title) {
        let titleContainer = elements.pageTitle.content.cloneNode(true)
        titleContainer.querySelector("h2").innerText = title
        elements.main.appendChild(title)
    }
}

const frontendModel = {
    changeNav(){
        elements.navItems.forEach(item => item.classList.remove("active"))
        generalModel.generatePage(this.dataset.page)
        this.classList.add("active")
    },
    changeCategory(){
        this.parentNode.classList.toggle("open")
    },
    addNewEntry(id,cat,title,price){
        let newProduct = document.querySelector("template#newEntryTemp").content.cloneNode(true)
        newProduct.querySelector(".product").dataset.id = id
        newProduct.querySelector(".product-title").innerHTML = title
        newProduct.querySelector(".product-price").innerHTML = price
        document.querySelector(".category[data-id='" + cat + "'] .products").appendChild(newProduct)
        backendModel.resetForm()
    },
    openNewEntryModal(){
        if (this.parentNode.classList.contains("open")) backendModel.resetForm()  
        this.parentNode.classList.toggle("open") 
    },
    changeState(target){
        target.dataset.state = (target.dataset.state == "1") ? "0" : "1"
        target.firstElementChild.src = (target.dataset.state == "1") ? "img/mark-done.svg" : "img/mark-open.svg"
    },
    deleteModal() {
        databaseModel.deleteProduct(this.dataset.id)
    }
}

const backendModel = {
    changeState(){
        (this.dataset.state == "1") ? databaseModel.updateProduct(this.dataset.id, "0", this) : databaseModel.updateProduct(this.dataset.id, "1", this)
    },
    addNewEntry(){
        if (document.querySelector("#title").value && document.querySelector("#price").value) {
            databaseModel.addProduct(document.querySelector("#category").value,document.querySelector("#title").value,document.querySelector("#price").value)
        } else {
            console.log("Data not complet.")
        }
    },
    deleteProduct(id) {
        document.querySelector(".product[data-id='" + id + "'").remove()
        this.closeDetailModal()
    },
    resetForm() {
        document.querySelectorAll(".new-product-form input").forEach(input => input.value = "")
    },
    generateCategories() {
        for(let i = 1; i < categories.length; i++) {
            let option = document.querySelector("template#option").content.cloneNode(true)
            option.querySelector("option").value = i
            option.querySelector("option").innerHTML = categories[i]
            document.querySelector("#category").appendChild(option)
        }
    },
    generateDetailModal(id,titel,url,price) {
        console.log(id,url,price)
        let detail_modal = document.querySelector("template#detail-modal").content.cloneNode(true)
        detail_modal.querySelector(".container").dataset.id = id
        detail_modal.querySelector("h4").innerHTML = titel
        detail_modal.querySelector(".price").innerHTML = price
        document.body.prepend(detail_modal)
        document.querySelector("#close-modal").addEventListener("click", backendModel.closeDetailModal)
        document.querySelector(".deleteBtn").addEventListener("click", backendModel.getIdModal)
    },
    closeDetailModal() {
        document.querySelector(".detail").remove()
    },
    getIdModal() {
        let id = document.querySelector(".detail .container").dataset.id
        databaseModel.deleteProduct(id)
    }
}

const databaseModel = {
    addProduct(cat,title,price){
        fetch(url, {
            method: "post",
            body: JSON.stringify({
                function: "addNewEntry",
                category: cat,
                title: title,
                price: price
            })
        }).then((data) => data.text())
        .then((data) => frontendModel.addNewEntry(data,cat,title,price))
    },
    updateProduct(id, state, target){
        fetch(url, {
            method: "post",
            body: JSON.stringify({
                function: "updateState",
                id: id,
                state: state
            })
        }).then(data => {
            if(data.status == 200) frontendModel.changeState(target)
        })
    },
    deleteProduct(id){
        fetch(url, {
            method: "post",
            body: JSON.stringify({
                function: "deleteProduct",
                id: id
            })
        }).then(data => {
            if(data.status == 200) backendModel.deleteProduct(id)
        })
    },
    getData(){
        fetch(url, {
            method: "post",
            body: JSON.stringify({
                function: "getData",
                id: this.dataset.id
            })
        }).then((response) => response.json())
        .then((data) => backendModel.generateDetailModal(data.id,data.titel,data.url,data.price) )
    }
}

const elements = {
    main: document.querySelector("main"),
    pageTitle: document.querySelector("template#pageTitle"),
    navItems: document.querySelectorAll(".nav p"),
    categoryBoxes: document.querySelectorAll(".category :is(.icon, .title, .arrowBtn)"),
    products: document.querySelectorAll(".product"),
    newModal: document.querySelector("button.addProduct"),
    addNewEntryBtn: document.querySelector("#addNewProduct"),
    titlet: document.querySelector("h2")
}

elements.navItems.forEach(item => item.addEventListener("click", frontendModel.changeNav))
elements.categoryBoxes.forEach(categoryBox => categoryBox.addEventListener("click", frontendModel.changeCategory))
elements.products.forEach(product => product.addEventListener("click", backendModel.changeState))
elements.products.forEach(product => product.addEventListener("long-press", databaseModel.getData))
elements.newModal.addEventListener("click", frontendModel.openNewEntryModal)
elements.addNewEntryBtn.addEventListener("click", backendModel.addNewEntry)
window.addEventListener("load", backendModel.generateCategories)