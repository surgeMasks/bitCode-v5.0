import { get, post } from "$lib/middleware/apimiddleware";

const api = {

    getProjects: async () => {
        try {
            const response = await get(`/projects`);
            if (!response.ok) {
                throw new Error("Failed to get projects");
            }

            const data = await response.json();
            return data;
        } catch (error) {
            throw error;
        }
    },

};

export default api;
