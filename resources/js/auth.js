const REGISTER = "api/register";

export default {
    login(username, password) {
        console.log(username, password);
    },

    async register(data) {
        const response = axios.post(REGISTER, data);
        // axios
        //     .post(REGISTER, data)
        //     .then((response) => {
        //         console.log(response);
        //     })
        //     .catch((error) => {
        //         if (error.response) {
        //             console.log(error.response.data);
        //             console.log(error.response.status);
        //             console.log(error.response.headers);
        //         } else if (error.request) {
        //             console.log(error.request);
        //         } else {
        //             console.log("Error", error.message);
        //         }
        //         console.log(error.config);
        //     });

        return response;
    },
};
