
BX.ready(() => {
    const link = document.querySelector(".ajax-link");

    if(link) {
        link.addEventListener("click", sendAjax);
    }

    else {
        const infoElement = document.querySelector(".feedback-info-send-complaint");
        
        if(infoElement) {
            createInfoElementNotAjax();
        } 
    }
})

function sendAjax(event) {
    event.preventDefault();
    BX.ajax.runComponentAction("bitrix:news.detail", "complaint", {
        mode: "ajax",
        data: {
            id: event.target.id
        }})
        .then(response => {
            showFeedbackSuccesInfo(response["data"]);
        })
        .catch(response => {
            showFeedbackErrorInfo();
        })
}

function showFeedbackSuccesInfo(idNews) {
    createInfoElement(`Ваше мнение учтено, №${idNews}`);
}

function showFeedbackErrorInfo() {
    createInfoElement("Ошибка!");
}

function createInfoElement(text) {
    
    const infoElement = document.querySelector(".feedback-info-send-complaint");
    const infoElementWrapper = document.querySelector(".feedback-info-send-complaint-wrapper");

    if(infoElement) {
        BX.remove(infoElement);
    }

    const newInfoElement = document.createElement("p");
    newInfoElement.innerHTML = text;
    newInfoElement.classList.add("feedback-info-send-complaint");
    infoElementWrapper.append(newInfoElement);
}

function createInfoElementNotAjax() {
    const element = document.querySelector(".feedback-info-send-complaint");
    const elementWrapper = document.querySelector(".feedback-info-send-complaint-wrapper");
    const textElement = element.textContent;

    const newInfoElement = document.createElement("p");
    newInfoElement.innerHTML = textElement;
    newInfoElement.classList.add("feedback-info-send-complaint");

    BX.remove(element);

    elementWrapper.append(newInfoElement);

}



