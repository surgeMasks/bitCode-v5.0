<script lang="ts">
  import { goto } from "$app/navigation";
  import { toasts, ToastContainer, FlatToast } from "svelte-toasts";
  import api from "$lib/apis/auth";

  let username = '';
  let password = '';
  
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

  const handleSubmit = async (e: Event) => {
    e.preventDefault();
    try {
      // Simulate login API call
      if (username && password) {
        const response = await api.login(username, password);
        console.log('Login response:', response);
        localStorage.setItem('token', response.token);
        goto('/profile');
        showToast("Login successful!", "success");
      } else {
        throw new Error("Both username and password are required.");
      }
    } catch (error: any) {
      showToast(error.message, "error");
    }
  };
</script>

<main class="flex items-center justify-center min-h-screen bg-gray-100">
  <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-2xl font-semibold text-center text-gray-700 mb-6">Login</h2>
    
    <form on:submit={handleSubmit} class="space-y-4">
      <!-- Email/Username Field -->
      <div>
        <label for="username" class="block text-sm font-medium text-gray-600">Email or Username</label>
        <input
          id="username"
          type="text"
          bind:value={username}
          class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
          placeholder="Enter your email or username"
          required
        />
      </div>
      
      <!-- Password Field -->
      <div>
        <label for="password" class="block text-sm font-medium text-gray-600">Password</label>
        <input
          id="password"
          type="password"
          bind:value={password}
          class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
          placeholder="Enter your password"
          required
        />
      </div>

      <!-- Submit Button -->
      <div>
        <button
          type="submit"
          class="w-full mt-4 px-4 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500"
        >
          Log In
        </button>
      </div>
    </form>
  
    <!-- Register Link -->
    <p class="mt-4 text-sm text-center text-gray-600">
      Don't have an account? 
      <a href="/auth/register" class="text-blue-500 hover:underline">Sign up</a>
    </p>
  </div>

  <ToastContainer placement="bottom-right" let:data={data}>
    <FlatToast {data} /> <!-- Provider template for your toasts -->
  </ToastContainer>
</main>
