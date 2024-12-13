<script>
  import { loadStripe } from "@stripe/stripe-js";
  import api from "$lib/apis/payment";

  const stripePromise = loadStripe(import.meta.env.VITE_STRIPE_PUBLISHABLE_KEY);

  async function handleCheckout() {
    const stripe = await stripePromise;

    if (!stripe) {
      console.error("Stripe failed to initialize.");
      return;
    }

    const session = api.createCheckoutSession;

    await stripe.redirectToCheckout({ sessionId: session });
  }
</script>

<button on:click={handleCheckout} class="bg-blue-500 text-white py-2 px-4 rounded">
  Pay Now
</button>