const costsModal = {
    openCosts() {
        this.parentElement.classList.toggle("open")
    },
    calculatePersonalCosts(data) {
        if(data) {
            let costs = 0
            data.forEach(el => costs = costs + parseInt(el.price))
            document.querySelector("p#personal-costs").innerHTML = costs
            data.forEach(el =>{
                let temp = document.querySelector("template.costs-detail")
                let detail = temp.content.cloneNode(true)
                detail.querySelector(".title").innerHTML = el.title + " (" + categories[el.category] +")"
                detail.querySelector(".money").innerHTML = el.price
                document.querySelector(".my-costs").appendChild(detail)
            })
        } else {
            document.querySelector("p#personal-costs").innerHTML = "0"
        }
    },
    calculateGeneralCosts(data) {
        if(data) {
            let costs = 0
            data.forEach(el => costs = costs + parseInt(el.price))
            document.querySelector("p#general-costs").innerHTML = costs
            data.forEach(el =>{
                let temp = document.querySelector("template.costs-detail")
                let detail = temp.content.cloneNode(true)
                detail.querySelector(".title").innerHTML = el.title + " (" + categories[el.category] +")"
                detail.querySelector(".money").innerHTML = el.price
                document.querySelector(".overall-costs").appendChild(detail)
            })
        } else {
            document.querySelector("p#general-costs").innerHTML = "0"
        }
    }
}