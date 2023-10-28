import axios from "axios";

export function createRoom(name) {
  return axios.post("/api/rooms", { name: name });
}

export function createRound(roomId) {
  return axios.post("/api/rounds", {
    room_id: roomId,
  });
}

export const rooms = (roomSlug) => ({
  get() {
    return axios.get(`/api/rooms/${roomSlug}`);
  },
});

export const rounds = (roundId) => ({
  get() {
    return axios.get(`/api/rounds/${roundId}`);
  },
  finish(shouldFinish = true) {
    return axios.put(`/api/rounds/${roundId}`, {
      finished: shouldFinish,
    });
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
