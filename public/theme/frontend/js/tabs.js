var tabLinks = document.querySelectorAll(".tablinks");
var tabContent = document.querySelectorAll(".tabcontent");

tabLinks.forEach(function (el) {
    el.addEventListener("click", openTabs);
});


/* tab home page */
var tabLinks = document.querySelectorAll(".tablinks");
var tabContent = document.querySelectorAll(".tabcontent");

tabLinks.forEach(function (el) {
    el.addEventListener("click", openTabs);
});


function openTabs(el) {
    var btn = el.currentTarget; // láº¯ng nghe sá»± kiá»‡n vĂ  hiá»ƒn thá»‹ cĂ¡c element
    
    var electronic = btn.dataset.electronic; // láº¥y giĂ¡ trá»‹ trong data-electronic
    var data=btn.dataset.target;
    var tab=Tech.$('[data-target]');
    for(let i=0;i<tab._element.length - 1;i++){
        if(tab._element[i]._element.dataset.target===data){
            tab._element[i]._element.classList.remove("active");
        }
    }

    document.querySelector("#" + electronic).classList.add("active");

    btn.classList.add("active");
    
}
/* end tab home page */