class Storage {
    constructor(key) {
        this.key = key;
        this.data = {};
    }

    set(name, value) {
        this.data[name] = value;
    }

    get(name) {
        return this.data[name];
    }

    has(name){
        return name in this.data ? true : false
    }
}
