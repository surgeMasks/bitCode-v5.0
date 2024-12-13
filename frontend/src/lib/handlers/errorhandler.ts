import { browser } from "$app/environment";
import { goto } from "$app/navigation";

class CustomError extends Error {
  status: number;

  constructor(message: string, status: number) {
      super(message);
      this.status = status;
      Object.setPrototypeOf(this, CustomError.prototype);
  }
}

export async function handleErrorResponse(response: Response) {
  if (!response.ok) {
    
    let errorMsg = "Unknown error occurred";
    try {
      const errorData = await response.json();

      errorMsg =
        errorData.message ||
        errorData.msg ||
        errorData.errors[Object.keys(errorData.errors)[0]][0] ||
        errorMsg;
    } catch (error) {
      console.error("Error parsing error response:", error);
    }
    throw new CustomError(errorMsg, response.status);
  }
}
