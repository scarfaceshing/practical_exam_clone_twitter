export default {
    async post(url, data) {
        const response = await axios.post(url, data);
        return response;
    },
};
