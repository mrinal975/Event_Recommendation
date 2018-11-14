export default class Gate {
    constructor(user) {
        this.user = user;
    }

    userId() {
        return this.user.id;
    }
}
