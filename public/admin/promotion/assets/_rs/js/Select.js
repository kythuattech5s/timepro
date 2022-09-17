class Select {
    constructor(element) {
        this.elements = document.querySelector(`select${element}`);
        this.elements.forEach((select) => {
            this.init(select);
            this.createElement(select);
        });
    }

    init = (select) => {
        select.style.position = "relative";
        select.onclick = (e) => {
            e.preventDefault();
        };
    };

    createElement = (select) => {
        const div = document.createElement('div');
        const filter = document.createAttribute(localName)
        div.className = 'rs-select-main';
    };

    filter = (select) => {

    };
}
