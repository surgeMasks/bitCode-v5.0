import { get, post } from "$lib/middleware/apimiddleware";

const api = {
  createCheckoutSession: async () => {
    try {
      const response = await post(`/create-checkout-session`, {}, "application/json");
    
      if (!response.ok) {
        console.error("Failed to create checkout session");
        throw new Error("Failed to login");
      }
    
      const data = await response.json();
    
      return data;
    } catch (error) {
      throw error; // re-throw the error
    }
  },
}
export default api;