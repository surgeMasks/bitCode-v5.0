<script>
   

    let menuItems = [
        { name: "Posts", link: "/dashboard/posts" },
        { name: "MarketPlace", link: "/dashboard/marketplace" },
        { name: "Profile", link: "/dashboard/profile" },
        { name: "Logout", link: "/dashboard/auth/logout" }
    ];

    import { onMount } from 'svelte';

    onMount(() => {
        const token = localStorage.getItem('token');
        if (!token) {
            window.location.href = '/auth/login';
        }
    });
</script>

<style>
  /* General Styling */
  body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f3f4f6; /* Light gray background */
  }

  header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 2rem;
    background-color: #1f2937; /* Gray-900 */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    color: white;
  }

  .logo {
    font-size: 1.5rem;
    font-weight: bold;
    color: #10b981; /* Emerald-500 */
  }

  nav ul {
    display: flex;
    list-style: none;
    margin: 0;
    padding: 0;
  }

  nav ul li {
    margin-right: 1.5rem;
    font-size: 1rem;
  }

  nav ul li a {
    text-decoration: none;
    color: white;
    transition: color 0.3s ease;
  }

  nav ul li a:hover {
    color: #10b981; /* Emerald-500 */
  }

  .icons {
    display: flex;
    align-items: center;
  }

  .icons i {
    font-size: 1.5rem;
    margin-left: 1rem;
    cursor: pointer;
    transition: color 0.3s ease;
  }

  .icons i:hover {
    color: #10b981; /* Emerald-500 */
  }

  .about-section {
    padding: 3rem 1rem;
    text-align: center;
    background-color: white;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
  }

  .about-section h1 {
    font-size: 2.5rem;
    margin-bottom: 1rem;
    color: #1f2937; /* Gray-900 */
  }

  .about-section p {
    font-size: 1.2rem;
    line-height: 1.5;
    color: #6b7280; /* Gray-600 */
  }

  .content {
    max-width: 900px;
    margin: 2rem auto;
    padding: 0 1rem;
    text-align: left;
  }

  .content h2 {
    font-size: 2rem;
    color: #10b981; /* Emerald-500 */
    margin-bottom: 1rem;
  }

  .content p {
    font-size: 1rem;
    margin-bottom: 1rem;
    line-height: 1.6;
    color: #374151; /* Gray-800 */
  }

  .content img {
    width: 100%;
    border-radius: 8px;
    margin-top: 1.5rem;
  }

  .container {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    min-height: 60vh;
    background-color: white;
    padding: 2rem;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    margin: 2rem auto;
    max-width: 600px;
  }

  .container h1 {
    font-size: 2rem;
    color: #1f2937; /* Gray-900 */
    margin-bottom: 1rem;
  }

  .container p {
    color: #6b7280; /* Gray-600 */
    font-size: 1rem;
    margin-bottom: 2rem;
    text-align: center;
  }

  button {
    background-color: #10b981; /* Emerald-500 */
    color: white;
    font-size: 1.2rem;
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }

  button:hover {
    background-color: #059669; /* Emerald-600 */
  }

  button:focus {
    outline: none;
    box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.3); /* Emerald-500 */
  }
</style>

<header>
    <div class="logo">SurgicalMasks</div>
    <nav>
      <ul>
        {#each menuItems as item}
          <li><a href={item.link}>{item.name}</a></li>
        {/each}
      </ul>
    </nav>
    <div class="icons">
      <i class="fa fa-user-circle" aria-hidden="true"></i>
      <i class="fa fa-shopping-cart" aria-hidden="true"></i>
    </div>
</header>

<section class="about-section">
    <h1>Our Platform</h1>
    <p>On our platform, you can buy projects using Stripe. We have integrated Stripe to ensure secure and seamless transactions for all your purchases.</p>
</section>

<div class="content">
    <h2>Why Choose Stripe?</h2>
    <p>
      Stripe is a leading payment processing platform that offers robust security features, ensuring that your transactions are safe and secure. With Stripe, you can easily manage your payments and enjoy a hassle-free experience.
    </p>
    <p>
      Our integration with Stripe allows you to focus on what matters most - your projects. Whether you're buying or selling, Stripe makes the process smooth and efficient.
    </p>
</div>



<!-- Add the slot here -->
<slot></slot>