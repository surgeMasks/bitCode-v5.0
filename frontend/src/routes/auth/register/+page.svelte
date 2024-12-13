<script lang="ts">
  import { toasts, ToastContainer, FlatToast } from "svelte-toasts";
  import api from "$lib/apis/auth";

  let fullName = '';
  let userName = '';
  let universityReg = '';
  let university = '';
  let email = '';
  let password = '';
  let confirmPassword = '';

  const showToast = (message: string, type: "success" | "error") => {
    toasts.add({
      title: type === "success" ? "Success" : "Error",
      description: message,
      duration: 5000,
      placement: 'bottom-right',
      type: type,
      theme: 'dark',
    });
  };

  const handleRegister = async () => {
    try {
      if (fullName && userName && universityReg && university && email && password) {
        const regData = {
          full_name: fullName,
          email: email,
          username: userName,
          password: password,
          uni_reg_no: universityReg,
          university_id: university,
          password_confirmation: password
        };

        const response = await api.register(regData);

        if (response.status === 200) {
          showToast("Registration successful!", "success");
          // Redirect to another page (e.g., login page)
          // goto('/login'); // Uncomment if you're using $app/navigation
        } else {
          const errorData = await response.json();
          throw new Error(errorData.message || "Registration failed.");
        }
      } else {
        throw new Error("Please fill in all fields.");
      }
    } catch (error : any) {
      showToast(error.message, "error");
    }
  };
</script>

<div class="min-h-screen flex items-center justify-center bg-gray-100">
  <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-sm">
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Create an Account</h2>

    <form on:submit|preventDefault={handleRegister}>
      <!-- Full Name -->
      <div class="mb-4">
        <label for="fullName" class="block text-sm font-medium text-gray-700">Full Name</label>
        <input
          id="fullName"
          type="text"
          bind:value={fullName}
          class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
          placeholder="Enter your full name"
          required
        />
      </div>

      <!-- User Name -->
      <div class="mb-4">
        <label for="userName" class="block text-sm font-medium text-gray-700">User Name</label>
        <input
          id="userName"
          type="text"
          bind:value={userName}
          class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
          placeholder="Enter a user name"
          required
        />
      </div>

      <!-- University Registration Number -->
      <div class="mb-4">
        <label for="universityReg" class="block text-sm font-medium text-gray-700">University Registration Number</label>
        <input
          id="universityReg"
          type="text"
          bind:value={universityReg}
          class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
          placeholder="Enter your university registration number"
          required
        />
      </div>

      <!-- University -->
      <div class="mb-4">
        <label for="university" class="block text-sm font-medium text-gray-700">University</label>
        <input
          id="university"
          type="text"
          bind:value={university}
          class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
          placeholder="Enter your university name"
          required
        />
      </div>

      <!-- Email -->
      <div class="mb-4">
        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
        <input
          id="email"
          type="email"
          bind:value={email}
          class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
          placeholder="Enter your email address"
          required
        />
      </div>

      <!-- Password -->
      <div class="mb-4">
        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
        <input
          id="password"
          type="password"
          bind:value={password}
          class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
          placeholder="Choose a secure password"
          required
        />
        <small class="text-xs text-gray-500 mt-2">Password must be at least 8 characters, with at least one uppercase letter, one number, and one special character.</small>
      </div>
      <!-- Confirm Password -->
      <div class="mb-4">
        <label for="confirmPassword" class="block text-sm font-medium text-gray-700">Confirm Password</label>
        <input
          id="confirmPassword"
          type="password"
          bind:value={confirmPassword}
          class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
          placeholder="Confirm your password"
          required
        />
        <small class="text-xs text-gray-500 mt-2">Please re-enter your password for confirmation.</small>
      </div>

      <button
        type="submit"
        class="w-full py-2 px-4 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
      >
        Register
      </button>
    </form>

    <div class="mt-4 text-center">
      <p class="text-sm text-gray-600">Already have an account? <a href="/auth/login" class="text-blue-500 hover:underline">Login</a></p>
    </div>
  </div>

  <ToastContainer placement="bottom-right" let:data={data}>
    <FlatToast {data} /> <!-- Provider template for your toasts -->
  </ToastContainer>
</div>

<style>
  /* Custom styles if needed */
</style>
