export default {
    async post(url, data, headers) {
        const response = await axios.post(url, data, headers);
        return response;
    },

    async get(url) {
        const response = await axios.get(url);
        return response;
    },
};
