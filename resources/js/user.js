export default {
    saveUsername(username) {
        localStorage.setItem(`username`, username);
    },
    retrieveUsername() {
        return localStorage.getItem(`username`);
    }
}
