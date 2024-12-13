import api from "$lib/apis/profile";

export async function updateMyProfile(profile: { [key: string]: any }) {
  try {
    const response = await api.updateMyProfile(profile);
    profile = response;
  } catch (error: any) {
    throw new Error(error.message);
  }
}

export async function updatePassword(
  oldPassword: string,
  newPassword: string,
  passwordConfirmation: string
) {
  try {
    const response = await api.changePassword({
      oldPassword,
      newPassword,
      passwordConfirmation,
    });
  } catch (error: any) {
    throw new Error(error.message);
  }
}

export async function deleteMyProfile(password: string) {
  try {
    await api.deleteUser(password);
  } catch (error: any) {
    throw new Error(error.message);
  }
}
