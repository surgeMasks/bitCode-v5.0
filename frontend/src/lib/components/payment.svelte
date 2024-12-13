<script>
    import { loadStripe } from "@stripe/stripe-js";
  
    let stripePromise = loadStripe("your-publishable-key"); // Replace with your Publishable Key from Stripe Dashboard
  
    async function handleCheckout() {
      const stripe = await stripePromise;
  
      // Check if stripe is null
      if (!stripe) {
        console.error("Stripe failed to initialize.");
        return;
      }
  
      // Call your backend to create a checkout session
      const response = await fetch("/create-checkout-session", {
        method: "POST",
      });
  
      if (!response.ok) {
        console.error("Failed to create checkout session");
        return;
      }
  
      const session = await response.json();
  
      // Redirect to Stripe Checkout
      await stripe.redirectToCheckout({ sessionId: session.id });
    }
  </script>
  
<button on:click={handleCheckout} class="bg-blue-500 text-white py-2 px-4 rounded">
    Pay Now
</button>
  