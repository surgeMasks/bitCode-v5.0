import api from "$lib/apis/profile";

export async function fetchMyProfile() {
  try {
    const myProfile = await api.getMyProfile();
    return myProfile;
  } catch (error) {
    console.error(error);
  }
}
