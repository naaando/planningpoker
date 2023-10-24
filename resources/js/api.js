import axios from "axios";

export const rounds = (roundId) => ({
  create() {
    return axios.post("/api/rounds");
  },
  get() {
    return axios.get(`/api/rounds/${roundId}`);
  },
  finish() {
    return axios.post(`/api/rounds/${roundId}/finish`);
  },
});

export const votes = (roundId) => ({
  async join() {
    const savedId = this.retrieveId();

    if (savedId !== null) {
      try {
        const response = await axios.get(
          `/api/rounds/${roundId}/votes/${savedId}`
        );

        return response.data.data;
      } catch (error) {
        console.log("Error retrieving vote, creating new one");
        console.log(error);
      }
    }

    const response = await axios.post(`/api/rounds/${roundId}/votes`, {
      name: this.retrieveUsername(),
    });

    this.saveId(response.data.data.id);
    return response.data.data;
  },
  set(value) {
    const id = this.retrieveId();
    axios.put(`/api/rounds/${roundId}/votes/${id}`, {
      name: this.retrieveUsername(),
      vote: value,
    });
  },
  retrieveId() {
    return sessionStorage.getItem(`vote.${roundId}`);
  },
  saveId(id) {
    sessionStorage.setItem(`vote.${roundId}`, id);
  },
  retrieveUsername() {
    return sessionStorage.getItem(`username`);
  },
});
