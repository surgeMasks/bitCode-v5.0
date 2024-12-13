<script>
  import { loadStripe } from "@stripe/stripe-js";
  import api from "$lib/apis/payment";
  import { goto } from "$app/navigation";

  // Initialize Stripe with your publishable key
  const stripePromise = loadStripe(import.meta.env.VITE_STRIPE_PUBLISHABLE_KEY);

  async function handleCheckout() {
    // Ensure Stripe has been properly initialized
    const stripe = await stripePromise;
    if (!stripe) {
      console.error("Stripe failed to initialize.");
      return;
    }

    try {
      // Create a checkout session by calling your backend API
      const url = await api.createCheckoutSession();
      if (!url || !url.id) {
        console.error("Invalid session data received.");
        return;
      }
      window.location.href = url.id
      // Redirect to Stripe Checkout with the session ID
      // const { error } = await stripe.redirectToCheckout({ sessionId: session.id });
      // if (error) {
      //   console.error("Stripe Checkout error:", error.message);
      // }

    } catch (error) {
      console.error("Error during checkout:", error);
    }
  }
</script>

<button on:click|preventDefault={handleCheckout} class="bg-blue-500 text-white py-2 px-4 rounded">
  Pay Now
</button>
