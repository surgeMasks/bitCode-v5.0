import { get, post, put } from "$lib/middleware/apimiddleware";

interface profileData {
    full_name: string;
    email :string;
    username: string;
    password: string;
    uni_reg_no: string;
    university_id: string;
}

const api = {
    
    getMyProfile: async () => {
        const response = await get("/user");
    
        return response.json();
    },
    
    // Change password function
    changePassword: async (data: {
        oldPassword: string;
        newPassword: string;
        passwordConfirmation: string;
    }) => {
        const newData = {
        oldPassword: data.oldPassword,
        newPassword: data.newPassword,
        newPassword_confirmation: data.passwordConfirmation,
        _method: "PATCH",
        };
        const response = await post("/user", newData, "application/json");

        return response.json();
    },
  
  // Delete function
  deleteUser: async (password: string) => {
    const data = { password: password };
    const response = await post("/user/delete", data, "application/json");

    return response.json();
  },
  
  // Update function
  updateMyProfile: async (profile: any) => {
    const response = await put("/user", profile, "application/json");

    return response.json();
  },

  
};

export default api;


