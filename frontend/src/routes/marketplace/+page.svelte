<script>
    import CheckoutButton from "$lib/components/Payment.svelte";
  </script>
  
  <style>
    .container {
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background-color: #f3f4f6; /* Light gray */
      font-family: Arial, sans-serif;
    }
  
    h1 {
      font-size: 2rem;
      color: #374151; /* Gray-800 */
      margin-bottom: 1.5rem;
    }
  
    p {
      color: #6b7280; /* Gray-600 */
      font-size: 1rem;
      margin-bottom: 2rem;
    }
  </style>
  
  <div class="container">
    <h1>Complete Your Payment</h1>
    <p>Click the button below to proceed with your payment.</p>
    <CheckoutButton />
  </div>  