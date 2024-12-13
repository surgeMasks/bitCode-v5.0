import { get, post } from "$lib/middleware/apimiddleware";

// Interface for registration data
interface regData {
    full_name: string;
    email: string;
    username: string;
    password: string;
    uni_reg_no: string;
    university_id: string;
    password_confirmation: string;
}

const api = {
  
  // Login function
  login: async (id: string, password: string) => {
    try {
      const response = await post(`/login`, { id, password }, "application/json");
    
      if (!response.ok) {
        throw new Error("Failed to login");
      }
    
      const data = await response.json();
    
      return data;
    } catch (error) {
      throw error; // re-throw the error
    }
  },
  
  // Register function
  register: async (data: regData) => {
    // Convert the data to FormData to match the backend's expected format
    const formData = new FormData();

    for (const key in data) {
      if (
        data[key as keyof regData] !== undefined &&
        data[key as keyof regData] !== null
      ) {
        formData.append(key, data[key as keyof regData]);
      }
    }

    // Send POST request with the form data
    const response = await post(`/register`, formData, "");

    if (!response.ok) {
      throw new Error("Failed to register");
    }

    return response;
  },
  
  // Logout function
  logout: async () => {
    try {
      const response = await post(`/logout`, {}, "application/json");
      
      if (!response.ok) {
        throw new Error("Failed to logout");
      }

      return response;
    } catch (error) {
      throw error; // re-throw the error
    }
  },
};

export default api;
